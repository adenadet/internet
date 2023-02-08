<template>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="body">
<form @submit.prevent="uploadFiles"  enctype="multipart/form-data">
    <alert-error :form="lessonData"></alert-error> 
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Course</label>
                <div type="text" class="form-control disabled">{{typeof lesson.course != 'undefined'?  lesson.course.name: course.name}}</div>
                <input type="hidden" name="course_id" id="course_id" v-model="lessonData.course_id" />
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name *" v-model="lessonData.name" required>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Lesson Type</label>
                <select class="form-control" id="lesson_type_id" name="lesson_type_id" placeholder="Youtube Video Link" v-model="lessonData.lesson_type_id">
                    <option value="">---Select Lesson Type---</option>
                    <option value="0">No Quiz</option>
                    <option value="1">Has Quiz</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Youtube Video</label>
                <input type="text" class="form-control" id="video" name="video" placeholder="Youtube Video Link" v-model="lessonData.video">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Upload File</label>
                <input type="file" class="form-control" id="video" name="video" placeholder="Upload a PDF. PPT or DOC file" v-on:change="uploadFile"/> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <wysiwyg v-model="lessonData.content" />
        </div>
        <div class="col-md-4 col-sm-12">
            <input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
        </div>
    </div>
</form>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    
    data(){
        return {   
            course:{}, 
            lessonData: new Form({
                id:'', 
                lesson_type_id: '', 
                name:'', 
                course_id:'', 
                video: '', 
                file: '', 
                file_type: '', 
                content:'',
            }),
        }
    },
    methods:{
        createLesson(){
            this.$Progress.start();
            this.lessonData.post('/api/lms/lessons')
            .then(response=>{
                Swal.fire({icon: 'success', title: response.data.message,});
                Fire.$emit('courseRefresh', response)
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
        updateLesson(){
            this.$Progress.start();
            this.lessonData.put('/api/lms/lessons/'+this.lessonData.id)
            .then(response=>{
                Swal.fire({icon: 'success', title: response.data.message,});
                Fire.$emit('courseRefresh', response)
                this.$Progress.finish();
                this.lessonData.reset();
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({icon: 'error', title: 'Your form was not sent try again later!',});
            });
        }, 
        uploadFile(e){
            //console.log(e.target.files[0]);
            this.file = e.target.files[0];
        },
        uploadFiles(e) {
            e.preventDefault();
            
            const json = JSON.stringify({
                id: this.lessonData.id, 
                lesson_type_id: this.lessonData.lesson_type_id, 
                name: this.lessonData.name, 
                course_id: this.lessonData.course_id, 
                video: this.lessonData.video, 
                content: this.lessonData.content,
            });
            console.log(json);

            let currentObj = this;
            
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            let formData = new FormData();
            formData.append('file', this.file);
            formData.append('data', json);

            axios.post('/api/lms/lessons/fileUpload', formData, config)
            .then(function (response) {
                //Fire.$emit('refresh', response);
                Fire.$emit('CourseRefresh', response.data.course);
                Swal.fire({icon: 'success', title: response.data.success,});   
            })
            .catch(function (error) {
                currentObj.output = error;
            });
        },
    },
    mounted() {
        Fire.$on('CourseRefresh', course =>{this.course = course; console.log("Course Updated")});
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