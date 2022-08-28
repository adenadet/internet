<template>
    <form-wizard>
        <template v-slot="">
            
            <tab v-for="question in questions" :key="question.id" :name="'Step '+question.id" :info="'Test'+question.id" :selected="false">
                <question-frame :question="question" />
            </tab>
            
            <tab name="Step 1" info="Introduction" :selected="false">
                Test 1
            </tab>
            <tab name="Step 2" info="More Details" :selected="false">
                Test 2
            </tab>
            <tab name="Step 3" info="Finishing Up" :selected="false">
                Test 3
            </tab>
        </template>
    </form-wizard>
</template>
<script>
import FormWizard from 'vue-step-wizard';
import TabContent from 'vue-step-wizard';
import QuestionFrame from './QuestionFrame.vue';
export default {
    components: { QuestionFrame },
    data(){
        return {   
            formData:{}, course:{}, 
            ExamTakenData: new Form({id:'', name:'', course_id:'', video: null, pdf: null, doc: null, content:null,}),
            questions: [],
        }
    },
    methods:{
        createLesson(){
            this.$Progress.start();
            this.lessonData.post('api/lms/lessons')
            .then(response=>{
                Swal.fire({icon: 'success', title: response.data.message,});
                Fire.$emit('refresh', response)
                this.$Progress.finish();
                //this.lessonData.reset();
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({icon: 'error',title: 'Your form was not sent try again later!',});
            })
        },
        createLessons(){
            this.$Progress.start();
            this.lessonData.post('/api/lms/lessons')
            .then(response=>{
                Swal.fire({icon: 'success', title: response.data.message,});
                this.$Progress.finish();
                this.lessonData.reset();
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({icon: 'error',title: 'Your form was not sent try again later!',});
            });
        },
        grabVideo(event){
            this.lessonData.video = event.target.files[0];
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/lms/std_exams/'+this.$route.params.id)
            .then(response =>{
                this.exam = response.data.exam;
                this.questions = response.data.questions;
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Exams loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Exams not loaded successfully',
                })
            });
        },
        handleDoc(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            
            //if ((file['type'] != 'application/pdf') ){Swal.fire({icon: 'error', title: 'File is not a PDF! <br />File is of type '+file['type']}); return null;}
            if (file['size'] > 2000000){Swal.fire({type: 'error', title: 'File is too large! File is of size '+file['size']}); return null;}
            else{
                reader.onloadend = (e) => {this.lessonData.doc = reader.result}
                reader.readAsDataURL(file)
            }
            
        },
        handlePDF(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            
            if ((file['type'] != 'application/pdf') ){Swal.fire({icon: 'error', title: 'File is not a PDF! <br />File is of type '+file['type']}); return null;}
            if (file['size'] > 2000000){Swal.fire({type: 'error', title: 'File is too large! File is of size '+file['size']}); return null;}
            else{
                reader.onloadend = (e) => {this.lessonData.pdf = reader.result}
                reader.readAsDataURL(file)
            }
            
        },
        handleVideo(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            
            if ((file['type'] != 'video/mp4') && (file['type'] != 'video/mov')){Swal.fire({icon: 'error', title: 'File is not a video! <br />File is of type '+file['type']}); return null;}
            if (file['size'] > 200000000){Swal.fire({type: 'error', title: 'File is too large! File is of size '+file['size']}); return null;}
            else{
                reader.onloadend = (e) => {this.lessonData.video = reader.result}
                reader.readAsDataURL(file)
            }
        }, 
        updateLesson(){
            this.$Progress.start();
            this.lessonData.put('/api/lms/lessons/'+this.lessonData.id)
            .then(response=>{
                Swal.fire({icon: 'success', title: response.data.message,});
                Fire.$emit('refresh', response)
                this.$Progress.finish();
                this.lessonData.reset();
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({icon: 'error', title: 'Your form was not sent try again later!',});
            });
        },   
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('CourseRefresh', course =>{this.course = course;});
        Fire.$on('LessonDataFill', lesson =>{
            this.lessonData.reset();
            this.lessonData.fill(lesson)
            this.lessonData.course_id = typeof lesson.course != 'undefined' ? lesson.course.id : this.course.id;
        });
    },
    props: {
        'editMode': Boolean,
        'lesson': Object,
    },
}
</script>