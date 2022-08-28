<template>
    <div>
        <form @submit.prevent="editMode ? updateExam() : createExam()"> 
        <alert-error :form="ExamData"></alert-error> 
            <div class="row">
                <!-- Get Address -->
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label>Exam Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name *" v-model="ExamData.name" :class="{'is-invalid' : ExamData.errors.has('name') }" required />
                    </div>
                </div>
            </div>
            <div v-if="!editMode" class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>Course</label>
                        <select v-show="!editMode" class="form-control" id="course_id" name="course_id" placeholder="Enter Street Desc" v-model="ExamData.course_id" :class="{'is-invalid' : ExamData.errors.has('course_id') }" @change="changeLesson">
                            <option value="">---Select Course---</option>
                            <option v-for="(course, index) in courses" :key="course.id" :value="index">{{course.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>Lesson</label>
                        <select class="form-control" id="lesson_id" name="lesson_id" placeholder="Enter Street Desc" v-model="ExamData.lesson_id" :class="{'is-invalid' : ExamData.errors.has('lesson_id') }" >
                            <option value=''>---No Lesson---</option>
                            <option v-for="lesson in lessons" :key="lesson.id" :value="lesson.id">{{lesson.name}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div v-if="editMode" class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>Course</label>
                        <input type="text" id="course" name="course" class="form-control" placeholder="" :value="sent_course.name" disabled />
                        <input type="hidden" name="course_id"  v-model="ExamData.course_id" />
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>Lesson</label>
                        <input type="text" id="lesson" name="lesson" class="form-control" placeholder="" :value="sent_lesson.name" disabled />
                        <input type="hidden" name="course_id"  v-model="ExamData.lesson_id" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>No of Questions</label>
                        <input type="text" id="question" name="question" class="form-control" placeholder="Enter Number of QUestions To Answer" v-model="ExamData.question" :class="{'is-invalid' : ExamData.errors.has('question') }" required />
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>Pass Mark</label>
                        <input type="text" id="pass_mark" name="pass_mark" class="form-control" placeholder="Enter Pass Mark *" v-model="ExamData.pass_mark" :class="{'is-invalid' : ExamData.errors.has('pass_mark') }" required />
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea rows="5" class="form-control" id="description" name="description" placeholder="Enter Description " v-model="ExamData.description" :class="{'is-invalid' : ExamData.errors.has('description') }"></textarea>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <input v-show="!editMode" type="submit" name="submit" class="submit btn btn-success" value="Submit" />
                    <input v-show="editMode" type="submit" name="submit" class="submit btn btn-success" value="Update" />
                </div>
            </div>
        </form>
    </div>
</template>
<script>
export default {    
    data(){
        return {   
            course:{},
            ExamData: new Form({id:'', name:'', courseID: '', course_id:'', lesson_id:'', pass_mark: '', question: '', description:'',}),
            lessons:[],
        }
    },
    methods:{
        createExam(){
            this.$Progress.start();
            this.ExamData.post('/api/lms/exams')
            .then(response=>{
                Swal.fire({icon: 'success', title: response.data.message});
                Fire.$emit('refresh', response)
                this.$Progress.finish();
                this.ExamData.reset();
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({icon: 'error',title: 'Your form was not sent try again later!',});
            })
        },
        changeLesson(){
            this.prev_cat = false;this.ExamData.lesson_id = '';this.lessons = this.courses[this.ExamData.course_id].lessons;
        },
        createLessons(){
            this.$Progress.start();
            this.lessonData.post('/api/lms/lessons')
            .then(response=>{Swal.fire({icon: 'success', title: response.data.message,});this.$Progress.finish();this.lessonData.reset();})
            .catch(()=>{this.$Progress.fail();Swal.fire({icon: 'error',title: 'Your form was not sent try again later!',});});
        },
        grabVideo(event){this.lessonData.video = event.target.files[0];},
        handleDoc(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file['size'] > 2000000){Swal.fire({type: 'error', title: 'File is too large! File is of size '+file['size']}); return null;}
            else{reader.onloadend = (e) => {this.lessonData.doc = reader.result};reader.readAsDataURL(file);}
        },
        updateExam(){
            this.$Progress.start();
            this.ExamData.put('/api/lms/exams/'+this.ExamData.id)
            .then(response=>{Swal.fire({icon: 'success', title: response.data.message,});Fire.$emit('refresh', response);this.$Progress.finish();this.ExamData.reset();})
            .catch(()=>{this.$Progress.fail();Swal.fire({icon: 'error', title: 'Your form was not sent try again later!',});});
        },   
    },
    mounted() {
        Fire.$on('CourseRefresh', course =>{this.course = course;});
        Fire.$on('ExamDataFill', exam =>{this.ExamData.reset();this.ExamData.fill(exam);console.log(this.editMode);});
    },
    props: {
        'editMode': Boolean,
        'sent_lesson': Object,
        'sent_course': Object,
        'courses': Array,
    },
}
</script>