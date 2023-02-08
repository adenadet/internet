<template>
    <div class="row">
        <div class="card col-lg-4 col-sm-6 col-md-6 d-flex align-items-stretch" v-for="(lesson, index) in lessons" :key="index">
            <div class="bg-light">
                <div class="card-header text-muted border-bottom-0"><h2 class="lead" :title="lesson.name">{{lesson.name | readMore(20, '...')}}</h2></div>
                <div class="card-body pt-0" style="height:100px;">
                    <div class="row">
                        <div class="col-9"><p class="text-muted text-sm">{{lesson.content | readMore(70, '...')}}</p></div>
                        <div class="col-3 text-center"><img src="" alt="" class="img-circle img-fluid"></div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-right" v-if="index > user_course.level">
                        <button title="Finish The Previous Lesson" class="btn btn-sm btn-danger" @click="prevent"><i class="fa fa-lock"></i> Locked</button>
                    </div>
                    <div class="text-right" v-else-if="index == 0 && user_course.level == null">
                        <button @click="startCourse(lesson.id)" title="Read Course" class="btn btn-sm btn-success"><i class="fa fa-play"></i> Start Course</button>
                    </div>
                    <div class="text-right" v-else>
                        <router-link v-if="index == course.level" :to="'/student_area/lesson/'+lesson.id" title="Read Course" class="btn btn-sm btn-success"><i class="fa fa-play"></i> Continue</router-link>
                        <router-link v-else :to="'/learn/student_area/lesson/'+lesson.id" title="Repeat Course" class="btn btn-sm btn-success"><i class="fa fa-circle-o"></i> Read Again</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            course: {},
            courses: {},
            editMode: false,
            exam:{},
            form: new Form({}),
            lessons: {},
            user_course: {},
        }
    },
    methods:{
        addLesson(){
        },
        deleteUser(id){
        },
        courseCompletion(course){
            if (course === null){ return '0%';}
            else{
                let level = (course.level === null ? 0 : course.level);
                let total = ((course.course.lessons !== null) && (typeof course.course.lessons !== 'undefined')) ? course.course.lessons.length : 0;
                if ((total = 0) || (level = 0)){return '0%';}
                else{
                    return (level * 100 / total);
                }
            }
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/lms/std_courses/'+this.$route.params.id).then(response =>{
                //this.courses = response.data.courses;
                this.course = response.data.course.course;
                this.lessons = response.data.course.course.lessons;
                this.user_course = response.data.course;
                this.$Progress.finish();
                toast.fire({icon: 'success', title: 'Courses loaded successfully',});
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Courses not loaded successfully',});
            });
        },
        getUser(page=1){
            axios.get('/api/hrms/users?page='+page).then(response=>{this.users = response.data.users;});
        },
        prevent(){
            Swal.fire({icon: 'error',title: 'Kindly complete the prerequisite module first!',});
        },
        startCourse(id){
            axios.get('/api/lms/std_courses/initialize/'+id)
            .then(response =>{
                console.log(response.data);
                if (response.data.message == "Error"){
                    Swal.fire({icon: 'error',title: 'You have not been assigned to do this course!',});
                    this.$router.push('/learn/student_area/courses');
                }
                else{
                    this.$router.push('/learn/student_area/lesson/'+id);
                }
            })
            .catch(()=>{});
        },
    },
    mounted() {
        console.log('Working');
        this.getAllInitials();
    }   
}
</script>