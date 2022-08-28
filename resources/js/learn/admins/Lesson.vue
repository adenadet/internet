<template>
<div class="row clearfix">
    <div class="modal fade" id="lessonModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-show="editMode">Edit Lesson: {{lesson.name}}</h4>
                    <h4 class="modal-title" v-show="!editMode">New Lesson</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <LmsFormLesson :lesson="lesson" :course="course" :editMode="editMode" />
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lesson Details</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" title="Collapse"><i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" title="Remove"><i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <h3 class="text-primary">Student's View</h3>
                        <StudentLessonDetail :lesson="lesson" />
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                        <h3 class="text-primary"><i class="fas fa-paint-brush"></i> Reports</h3>
                        <p class="text-muted"></p>
                        <br>
                        <div class="text-muted">
                            <p class="text-sm">Created By: <b class="d-block">{{lesson.creator.first_name+' '+lesson.creator.last_name}}</b></p>
                            <p class="text-sm">Created On: <b class="d-block">{{lesson.created_at | ExcelDate}}</b></p>
                            <p class="text-sm">Exam: <b class="d-block">{{((lesson.exam !== null)&&(typeof (lesson.exam) !== 'undefined' )) ? 'Yes' : 'No'}}</b></p>
                        </div>
                        <h5 class="mt-5 text-muted">Lesson files</h5>
                        <ul class="list-unstyled">
                            <li v-show="lesson.video !== null"><a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-video"></i> Functional-requirements.docx</a></li>
                            <li v-show="lesson.file !== null"><a target="_blank" :href="lesson.file" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i> </a></li>
                        </ul>
                        <div class="text-center mt-5 mb-3">
                            <a href="#" class="btn btn-sm btn-primary">Add files</a>
                            <button class="btn btn-sm btn-warning" @click="editLesson">Edit Module</button>
                        </div>
                    </div>
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
            categories:[],
            certificate_types:[],
            course:{},
            courses:{},
            editMode: false,
            exam_types: [],
            form: new Form({}),
            lesson: {},
            lessons: {},
            sub_categories:[],
            users:[],
        }
    },
    methods:{
        editLesson(){
            this.$Progress.start();
            alert("Working");
            this.editMode = true;
            Fire.$emit('LessonDataFill', this.lesson);
            $('#lessonModal').modal('show');
            this.$Progress.finish();
        },
        editCourse(course){
            this.$Progress.start();
            this.editMode = true;
            this.course = course;
            Fire.$emit('CourseDataFill', course);
            $('#courseModal').modal('show');
            this.$Progress.finish();
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/lms/lessons/'+this.$route.params.id).then(response =>{
                this.lesson = response.data.lesson;
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Lesson was loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Lesson was not loaded successfully',
                })
            });
        },
        getCourses(page=1){
            axios.get('/api/lms/courses?page='+page)
            .then(response=>{
                this.courses = response.data.courses;   
            });
        },
        seeCourse(course){
            this.$Progress.start();
            this.course = course;
            this.$Progress.finish();
        },
    },
    mounted() {
        this.getAllInitials();
    }
}
</script>
