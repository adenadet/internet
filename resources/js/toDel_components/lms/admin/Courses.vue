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
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Courses</h3>
                    <div class="card-tools"><button type="button" class="btn btn-sm btn-primary" data-card-widget="collapse" @click="addCourse">Add New</button></div>
                    <!-- /.card-tools -->
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
                                    <td>{{course.category_id !== null ? course.category.name : ''}}</td>
                                    <td>{{course.sub_category_id !== null? course.sub_category.name: ''}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-success" @click="seeCourse(course)"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-sm btn-primary" @click="editCourse(course)"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger" @click="deleteCourse(course.id)"><i class="fa fa-trash"></i></button>
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
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Courses Details: {{course.name}}</h3></div>
                <div class="body"><LmsDetailCourse :course="course" /></div>
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
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    })
                .then((result) => {
                    //Send Delete request
                    if(result.value){
                        this.form.delete('/api/lms/courses/'+id)
                        .then(response=>{
                        Swal.fire('Deleted!', 'Category has been deleted.', 'success');
                        Fire.$emit('CatRefresh', response);   
                        })
                        .catch(()=>{
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                        });
                    }
                });
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
                axios.get('/api/lms/courses').then(response =>{
                    this.refresh(response);
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
            refresh(response){
                this.categories = response.data.categories;
                this.certificate_types = response.data.certificate_types;
                this.courses = response.data.courses;
                this.course = this.courses.data[0];
                Fire.$emit('AssignUsers', this.course.assignees);
                this.departments = response.data.departments;
                this.exam_types = response.data.exam_types;
                this.users = response.data.users;
                Fire.$emit('LecturerFill', this.users);
                Fire.$emit('CourseRefresh', this.course);
            },
            seeCourse(course){
                this.$Progress.start();
                this.course = course;
                //Fire.$emit('CourseRefresh', course)
                Fire.$emit('AssignUsers', course.assignees);
                Fire.$emit('CourseRefresh', this.course);
                this.$Progress.finish();
            },
        },
        mounted() {
            this.getAllInitials();
            Fire.$on('courseRefresh', response =>{
                this.refresh(response);
                this.course = response.data.course;
                });
            Fire.$on('CourseUpdate', course=>{
                this.course = course;
                });
            Fire.$on('GetCourse', response =>{
                this.refresh(response);
                $('#courseModal').modal('hide');
                });
        }
    }
</script>