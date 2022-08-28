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
                    <LmsFormLesson :lesson="lesson" :course="course" :editMode="editMode"/>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="examModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-show="editMode">Edit Exam: {{lesson.name}}</h4>
                    <h4 class="modal-title" v-show="!editMode">New Exam</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <LmsFormExam :sent_lesson="lesson" :sent_course="course" :editMode="editMode"/>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12" v-show="lesson != '' && typeof (lesson) != 'undefined' && lesson.created_at != null && lesson != null">
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
                            <p class="text-sm">Created By: <b class="d-block">{{lesson.creator != null ? lesson.creator.first_name+' '+lesson.creator.last_name: 'Unkonown User'}}</b></p>
                            <p class="text-sm">Created On: <b class="d-block">{{lesson.created_at | ExcelDate}}</b></p>
                            <p class="text-sm">Exam: <b class="d-block">{{((lesson.exam !== null)&&(typeof (lesson.exam) !== 'undefined' )) ? 'Yes' : 'No'}}</b></p>
                        </div>
                        <h5 class="mt-5 text-muted">Lesson files</h5>
                        <ul class="list-unstyled">
                            <li v-show="lesson.video !== null"><a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-video"></i> Functional-requirements.docx</a></li>
                            <li v-show="lesson.file !== null"><a target="_blank" :href="lesson.file" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i> </a></li>
                        </ul>
                        <div class="text-center mt-5 mb-3">
                            <router-link :to="'/learn/tutor_area/exam/'+this.lesson.exam.id" v-if="lesson.exam != null" class="btn btn-sm btn-success">View Exam</router-link>
                            <button v-else-if="lesson.exam == null" class="btn btn-sm btn-default" @click="addExam">Add Exam</button>
                            <button class="btn btn-sm btn-warning" @click="editLesson">Edit Module</button>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
    <div class="col-12" v-show="lesson == '' || typeof (lesson)== 'undefined' || lesson.created_at == null || lesson == null">
        Loading....
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
        addExam(){
            this.editMode = false;
            this.$Progress.start();
            Fire.$emit('LessonDataFill', this.lesson);
            $('#examModal').modal('show');
            this.$Progress.finish();
        },
        editLesson(){
            this.$Progress.start();
            this.editMode = true;
            $('#lessonModal').modal('show');
            Fire.$emit('LessonDataFill', this.lesson);
            this.$Progress.finish();
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/lms/lessons/'+this.$route.params.id).then(response =>{
                this.lesson = response.data.lesson;
                this.course = response.data.lesson.course;
                this.$Progress.finish();
                toast.fire({icon: 'success', title: 'Lesson was loaded successfully',});
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Lesson was not loaded successfully',});
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
        updateExam(){
            this.editMode = true;
            this.course = this.course != null ? this.course : this.lesson.course;
            this.$Progress.start();
            Fire.$emit('LessonDataFill', this.lesson);
            $('#examModal').modal('show');
            this.$Progress.finish();
        }
    },
    mounted() {
        this.getAllInitials();

        Fire.$on('LessonRefresh', lesson =>{
            this.lesson = lesson;
            $('#lessonModal').modal('hide');
        });
    }
}
</script>
