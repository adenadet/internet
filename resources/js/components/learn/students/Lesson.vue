<template>
    <div class="card">
        <StudentLessonDetail :lesson="lesson"/>
        <div class="card-footer">
            <div class="text-right" v-if="(lesson.exam != null && typeof lesson.exam != 'undefined')">
                <a v-if="user_exam.status >= 3" :href="'/learn/student_area/exam/'+lesson.exam.id"><button type="button" class="btn btn-sm btn-success">Redo Exam</button></a> 
                <a v-else-if="(parseInt(lesson.exam.trials != null ? lesson.exam.trials : 10000000) - parseInt(trial_count) > 0) && user_exam.status < 3" :href="'/learn/student_area/exam/'+lesson.exam.id"><button type="button" class="btn btn-sm btn-success">Go To Exam</button></a> 
                <button v-if="(parseInt(lesson.exam.trials != null ? lesson.exam.trials : 10000000) - parseInt(trial_count) > 0) && user_exam.status >= 3" type="button" class="btn btn-sm btn-default" @click="completeLesson(lesson.id)">Next >></button>
                <button v-else type="button" class="btn btn-sm btn-default" @click="skipLesson(lesson.id)">Skip >></button>
            </div>
            <div class="text-right" v-else><button type="button" class="btn btn-sm btn-success" @click="completeLesson(lesson.id)">Complete</button></div>
        </div>
    </div>
</template>
<script>
export default {
    computed: {player() {return this.$refs.videoPlayer.player}},
    data(){
        return {
            course:{},
            document: '',
            editMode: true,
            form: new Form({}),
            lesson: {},
            next: '',
            playerOptions: {
                height: '400', muted: false, language: 'en', playbackRates: [0.7, 1.0, 1.5, 2.0],
                sources: [{type: "video/mp4", src: "/"}],
            },
            subCategory: {},
            trial_count: 0,
            type: '',
            user_exam: {},
        }
    },
    methods:{
        completeLesson(id){
            this.$Progress.start();  
            console.log("Working Fine");
            axios.get('/api/lms/std_lessons/complete/'+id)
            .then(response =>{
                Swal.fire({icon: response.data.icon, title: response.data.message,});
                if(response.data.icon == 'success'){this.$router.push('/learn/student_area/course/'+this.lesson.course_id);}
                else if(response.data.icon == 'warning'){this.$router.push('/learn/student_area/exam/'+this.lesson.exam.id);}
            })
            .catch(()=>{

            });
            this.$Progress.finish();
        },
        deleteCourseUser(id){},
        skipLesson(id){},
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/lms/std_lessons/'+this.$route.params.id)
            .then(response =>{
                this.lesson         = response.data.lesson;
                this.course         = response.data.course;
                this.message        = response.data.message;
                this.trial_count    = response.data.trials;
                this.user_exam      = response.data.user_exam;
                Fire.$emit('LessonRefresh', this.lesson);
                
                //console.log(response.data.message);
                if (response.data.message == "Don't go on"){
                    Swal.fire({icon: 'error',title: 'Kindly complete the prerequisite module first!',});
                    this.$router.push('/learn/student_area/course/'+this.lesson.course_id)
                }
                
                this.$Progress.finish();
            })
            .catch(()=>{this.$Progress.fail(); toast.fire({icon: 'error', title: 'Lesson not loaded successfully',});});
        },
        playing(){
            console.log(1);
        },
    },
    mounted() { 
        this.getAllInitials();
        Fire.$on('CourseRefresh', course =>{this.course = course;});
        Fire.$on('refresh', response =>{$('#lessonModal').modal('hide');});

    },
}
</script>