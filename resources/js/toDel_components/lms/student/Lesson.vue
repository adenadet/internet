<template>
    <div class="card">
        <h3>{{lesson.name}}</h3>
        <div class="col-md-8 offset-md-2" style="text-align:center" v-if="((lesson.video !== null) && (typeof lesson !== 'undefined') &&(typeof lesson.video !== 'undefined'))">
            <youtube :video-id="lesson.video" ref="youtube" @playing="playing"></youtube>
        </div>
        <div class="col-md-8 offset-md-2" style="max-height: 500px; overflow: scroll;" v-if="lesson.file-type != null">
            <VuePdfReader :url="lesson.file" v-if="lesson.file_type == 'pdf'"/>  
        </div>
        <div class="col-md-8 offset-md-2">{{lesson.content}}
        </div>
        <div class="card-footer">
            <div class="text-right" v-if="(lesson.exam_id != null && typeof lesson.exam != 'undefined')">
                <a v-if="parseInt(lesson.exam.trials) - parseInt(trial_count) > 0" :href="'/student_area/exam/'+lesson.exam.id"><button type="button" class="btn btn-sm btn-success">Complete Exam</button></a> 
                <button v-else type="button" class="btn btn-default" @click="completeLesson(lesson.id)">Next >></button>
                {{parseInt(lesson.exam.trials) - parseInt(trial_count)}} trials left  
            </div>
            <div class="text-right" v-else>
                <button type="button" class="btn btn-lg btn-success" @click="completeLesson(lesson.id)">Complete</button>
            </div>
        </div>
        <div class="col-md-8 offset-md-2">
            
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
        }
    },
    methods:{
        completeLesson(id){
            this.$Progress.start();  
            console.log("Working Fine");
            axios.get('/api/lms/std_lessons/complete/'+id)
            .then(response =>{
                Swal.fire({icon: response.data.icon, title: response.data.message,});
                console.log(response.data.message)
                if(response.data.icon == 'success'){this.$router.push('/student_area/course/'+this.lesson.course_id);}
                else if(response.data.icon == 'warning'){this.$router.push('/student_area/exam/'+this.lesson.exam.id);}
            })
            .catch(()=>{

            });
            this.$Progress.finish();
        },
        deleteCourseUser(id){},
        editLesson(lesson){},
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/lms/std_lessons/'+this.$route.params.id).then(response =>{
                this.lesson = response.data.lesson;
                this.course = response.data.course;
                this.message = response.data.message;
                this.trial_count = response.data.trial_count;
                //console.log(response.data.message);
                if (response.data.message == "Don't go on"){
                    Swal.fire({icon: 'error',title: 'Kindly complete the prerequisite module first!',});
                    this.$router.push('/student_area/course/'+this.lesson.course_id)
                }
                else if ((this.lesson !== 'undefined')&&(this.lesson.video !== null)&&(typeof this.lesson.video !== 'undefined')) {
                    this.playerOptions.sources = [{
                        type: "video/mp4", 
                        src: this.lesson.video,
                    }];
                    toast.fire({icon: 'success', title: 'Lesson loaded successfully',});
                }
                this.$Progress.finish();
                
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Lesson not loaded successfully',});
            });
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