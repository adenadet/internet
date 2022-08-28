<template>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="body">
<form @submit.prevent="editMode ? updateLesson() : createLesson()"  enctype="multipart/form-data">
    <alert-error :form="lessonData"></alert-error> 
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Course Name</label>
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
                <input type="file" class="form-control" id="file" name="file" placeholder="Upload a PDF. PPT or DOC file" v-on:change="uploadFile"/> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <wysiwyg v-model="lessonData.content" @change="test()" />
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
            file: '',
            filename: '',
            lessonData: new Form({
                course_id:'', 
                content:'',
                file: '',
                id:'', 
                lesson_type_id: '', 
                name:'', 
                video: '', 
            }),
        }
    },
    methods:{
        createLesson(){
            this.$Progress.start();
            //e.preventDefault();
            const json = JSON.stringify({
                course_id: this.lessonData.course_id,
                content: this.lessonData.content,
                id: this.lessonData.id ?? 0, 
                lesson_type_id: this.lessonData.lesson_type_id, 
                name: this.lessonData.name, 
                video: this.lessonData.video, 
            });
            console.log(json);

            let currentObj = this;
            const config = {
                headers: {
                'content-type': 'multipart/form-data',
                }
            };
            // form data
            let formData = new FormData();
            formData.append('file', this.file);
            formData.append('data', json );

            console.log(formData);
            
            axios.post('/api/lms/lessons', formData, config)
            .then(function (response) {
                currentObj.success = response.data.success;
                currentObj.filename = "";
                Fire.$emit('reloadPolicy', response);
                var message = editMode ? 'Module was successfully updated!' : 'Module was successfully added!';
                Swal.fire({
                    icon: 'success',
                    title: message,
                });
            })
            .catch(function (error) {currentObj.output = error;});
        },
        grabVideo(event){
            this.lessonData.video = event.target.files[0];
        },
        uploadFile(e){
            this.filename = "Selected File: " + e.target.files[0].name;
            this.file = e.target.files[0];
            console.log(this.file)
        },
        uploadFiles() {
            //e.preventDefault();
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
            
            const config = {headers: { 'content-type': 'multipart/form-data' }}

            let formData = new FormData();
            formData.append('data', json);
            formData.append('file', this.file);
            
            axios.post('/api/lms/lessons/fileUpload', formData, config)
            .then(function (response) {
                //Fire.$emit('refresh', response);
                Fire.$emit('CourseRefresh', response.data.course);
                Fire.$emit('LessonRefresh', response.data.lesson);
                Swal.fire({icon: 'success', title: response.data.success,});   
            })
            .catch(function (error) {
                currentObj.output = error;
            });
        },
        updateLesson(){
            this.$Progress.start();
            //e.preventDefault();
            const json = JSON.stringify({
                course_id: this.lessonData.course_id,
                content: this.lessonData.content,
                id: this.lessonData.id ?? 0, 
                lesson_type_id: this.lessonData.lesson_type_id, 
                name: this.lessonData.name, 
                video: this.lessonData.video, 
            });
            console.log(json);

            let currentObj = this;
            const config = {
                headers: {
                'content-type': 'multipart/form-data',
                }
            };
            // form data
            let formData = new FormData();
            formData.append('file', this.file);
            formData.append('data', json );

            console.log(formData);
            
            axios.post('/api/lms/lessons/modify', formData, config)
            .then(function (response) {
                currentObj.success = response.data.success;
                currentObj.filename = "";
                Fire.$emit('reloadPolicy', response);
                var message = editMode ? 'Module was successfully updated!' : 'Module was successfully added!';
                Swal.fire({
                    icon: 'success',
                    title: message,
                });
            })
            .catch(function (error) {currentObj.output = error;});
        },
    },
    mounted() {
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