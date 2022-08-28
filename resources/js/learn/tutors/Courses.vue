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
                    <!--<LmsFormCourse :categories="categories" :course="course" :sub_categories="sub_categories" :editMode="editMode" :exam_types="exam_types" :certificate_types="certificate_types" :tutors="users" /> -->
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Courses</h3>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table m-b-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="course in courses.data" :key="course.id">
                                <td>{{course.name}}</td>
                                <td :title="course.description">{{course.description | readMore(25, '...')}}</td>
                                <td>{{course.category_id !== null ? (course.category != null ? course.category.name: course.category_id) : ''}}</td>
                                <td>{{course.sub_category_id !== null? course.sub_category.name: ''}}</td>
                                <td>
                                    <div class="btn-group">
                                        <router-link :to="'/learn/tutor_area/course/'+course.id" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></router-link>
                                    </div>          
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <pagination :data="courses" @pagination-change-page="getCourses">
                    <span slot="prev-nav">&lt; Previous </span>
                    <span slot="next-nav">Next &gt;</span>
                </pagination>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        data(){
            return {
                certificate_types:[],
                course:{},
                courses:{},
                categories:[],
                editMode: false,
                exam_types: [],
                form: new Form({}),
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
            deleteCourse(id){

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
                axios.get('/api/lms/tut_courses').then(response =>{
                    this.categories = response.data.categories;
                    //this.certificate_types = response.data.certificate_types;
                    this.courses = response.data.courses;
                    //this.course = this.courses.data[0];
                    //Fire.$emit('CourseRefresh', this.course);
                    //Fire.$emit('AssignUsers', this.course.assignees);
                    //this.departments = response.data.departments;
                    //this.exam_types = response.data.exam_types;
                    //this.users = response.data.users;
                    //Fire.$emit('LecturerFill', this.users);
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