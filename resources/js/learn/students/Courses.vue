<template>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List of Assigned Courses</h3>

            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                    <button><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
        
        <div class="card-body table-responsive p-0">
            <table class="table m-b-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Course</th>
                        <th>Status</th>
                        <th>Progress</th>
                        <th>Expiry Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="course in courses.data" :key="course.id">
                        <td><h6 class="mb-0">{{course.course.name}}</h6></td>
                        <td>{{course.level === null ? 0 : course.level}} / {{((course.course.lessons !== null) && (typeof course.course.lessons !== 'undefined')) ? course.course.lessons.length : 0}}</td>
                        <td>
                            <div class="progress progress-xs">
                            <div class="progress-bar" :style="'width: '+courseCompletion(course)" :class="course.level== 0 || course.level == null ? 'bg-danger' :  'bg-success'"></div>
                            </div>
                        </td>
                        <td><span>{{course.expiry_date | ExcelDate}}</span></td>
                        <td>
                            <router-link v-show="Date.parse(course.expiry_date) >= Date.parse(Date())" :to="'/learn/student_area/course/'+course.course_id"><button class="btn btn-sm btn-success" title="See Course"><i class="fa fa-play"></i> {{course.level != null  ? "Continue" : "Start"}}</button></router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>    
</div>
</template>
<script>
export default {
    data(){
        return {
            courses: {},
            editMode: false,
            form: new Form({}),
        }
    },
    methods:{
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
            axios.get('/api/lms/std_courses').then(response =>{
                this.courses = response.data.courses;
                this.$Progress.finish();
                toast.fire({icon: 'success', title: 'Courses loaded successfully',});
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Courses not loaded successfully',});
            });
        },
        getUser(page=1){
            axios.get('/api/hrms/users?page='+page)
            .then(response=>{
                this.users = response.data.users;   
            });
        },
    },
    mounted() {
        this.getAllInitials();
    }   
}
</script>