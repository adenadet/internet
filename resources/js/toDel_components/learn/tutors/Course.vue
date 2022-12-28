<template>
<div class="row clearfix">
    <div class="modal fade" id="courseModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-show="editMode">Edit Course: {{course.name}}</h4>
                    <h4 class="modal-title" v-show="!editMode">New Course</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <LmsFormCourse :categories="categories" :course="course" :sub_categories="sub_categories" :editMode="editMode" :exam_types="exam_types" :certificate_types="certificate_types" :tutors="users" />
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{course.name}} Detail</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-sm btn-success" title="Assign new User" @click="assignUsers(course.id)"><i class="fas fa-user-plus"></i></button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="small-box bg-light">
                                <div class="inner">
                                    <h3>150</h3>
                                    <p>New Orders</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-shopping-bag"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="small-box bg-light">
                                <div class="inner">
                                    <h3>{{ 2300 | currency}}</h3>
                                    <p>Estimated Cost</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-wallet"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="small-box bg-light">
                                <div class="inner">
                                    <h3>{{ course.assignees.length}}</h3>
                                    <p>Enrollees</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h3 class="text-primary"><i class="fas fa-books"></i> {{course.name}}</h3>
                            <p class="text-muted">{{course.description}}</p>
                            <div class="text-muted">
                                <p class="text-sm">Category: <b class="d-block">{{course.category.name}}</b></p>
                                <p class="text-sm">Sub Category: <b class="d-block">{{course.sub_category.name}}</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12"><TutorLessons :lessons="lessons" /></div>
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
                lessons: {},
                sub_categories:[],
                users:[],   
            }
        },
        methods:{
            addCourse(){
                this.$Progress.start();
                this.editMode = false;
                this.course = {};
                Fire.$emit('CourseDataFill', {});
                $('#courseModal').modal('show');
                this.$Progress.finish();
            },
            assignUser(id){

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
                axios.get('/api/lms/tut_courses/'+this.$route.params.id).then(response =>{
                    this.categories = response.data.categories;
                    this.certificate_types = response.data.certificate_types;
                    this.courses = response.data.courses;
                    this.course = this.courses.data[0];
                    this.lessons = this.course.lessons;
                    Fire.$emit('CourseRefresh', this.course);
                    Fire.$emit('AssignUsers', this.course.assignees);
                    this.departments = response.data.departments;
                    this.exam_types = response.data.exam_types;
                    this.users = response.data.users;
                    Fire.$emit('LecturerFill', this.users);
                    this.$Progress.finish();
                    toast.fire({
                        icon: 'success',
                        title: 'Courses were loaded successfully',
                    });
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Courses were not loaded successfully',
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