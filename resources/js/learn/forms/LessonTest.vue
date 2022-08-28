<template>
<form @submit.prevent="editMode ? updateLesson() : createLesson()"  enctype="multipart/form-data">
    
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Course</label>
                <div type="text" class="form-control disabled">{{typeof lesson.course != 'undefined'?  lesson.course.name: course.name}}</div>
                <input type="hidden" name="course_id" id="course_id" v-model="formData.course_id" />
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name *" v-model="formData.name" required>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Lesson Type</label>
                <select class="form-control" id="lesson_type_id" name="lesson_type_id" placeholder="Youtube Video Link" v-model="formData.lesson_type_id">
                    <option value="">---Select Lesson Type---</option>
                    <option value="0">No Quiz</option>
                    <option value="1">Has Quiz</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Youtube Video</label>
                <input type="text" class="form-control" id="video" name="video" placeholder="Youtube Video Link" v-model="formData.video">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Upload Files</label>
                <input id="attachments" type="file" multiple="multiple" class="form-control" @change="fileChange">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <wysiwyg v-model="formData.content" />
        </div>
        <div class="col-md-4 col-sm-12">
            <button class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
</template>

<script>
import axios from 'axios'
//import _ from 'lodash'

export default {
    data() {
        return {
            course: {},
            errors: null,
            file: '',
            formData: {
                id:'', 
                lesson_type_id: '', 
                name:'', 
                course_id:'', 
                video: null, 
                file: '', 
                file_type: '', 
                content:'',
                },
            }
        },
    methods: {
        fileChange(e){
            console.log(e.target.files[0]);
            this.file = e.target.files[0];
            },
        createLesson() {
            //e.preventDefault();
            //let currentObj = this;

            const config = {
                headers: { 'content-type': 'multipart/form-data' }
                }

            //let formData = new FormData();
            this.formData.append('file', this.file);

            axios.post('/formSubmit', this.formData, config)
            .then(function (response) {
                console.log('Reached here');
                currentObj.success = response.data.success;
                })
            .catch(function (error) {
                currentObj.output = error;
                });
            },
        updateLesson(id) {
            //e.preventDefault();
            let currentObj = this;

            const config = {
                headers: { 'content-type': 'multipart/form-data' }
                }

            //let formData = new FormData();
            this.formData.append('file', this.file);

            axios.put('/formSubmit', this.formData, config)
            .then(function (response) {
                currentObj.success = response.data.success;
                })
            .catch(function (error) {
                currentObj.output = error;
                });
            },
        },
        //-- WHENEVER THE FILE IS CHOSEN - IT'S ATTACHED TO this.avatar BY ref="file" -->    
    mounted() {
        Fire.$on('CourseRefresh', course =>{this.course = course; console.log("Course Updated")});
        Fire.$on('LessonDataFill', lesson =>{
            //this.formData.reset();
            //this.formData.fill(lesson)
            this.formData.course_id = typeof lesson.course != 'undefined' ? lesson.course.id : this.course.id;
        });
    },
    props: {
        'editMode': Boolean,
        'lesson': Object,
    },
    }


</script>