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
            </div>
        </div>
    </div>
    <div class="modal fade" id="assigneeModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Assign Users</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <LmsFormAssignUsers aspire="u_course" :course="course" :departments="departments" :users="users"/>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="tutorModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Assign Tutors</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <LmsFormAssignUsers aspire="t_course" :course="course" :departments="departments" :users="tutors"/>
                    <!--<AdminFormAssignTutors aspire="u_course" :departments="departments" :reference="course" :tutors="users" />-->
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{course.name}} Detail</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-sm btn-default" title="Edit Course" @click="editCourse(course)"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-sm btn-primary" title="Assign Tutors" @click="addTutors(course.id)"><i class="fas fa-chalkboard-teacher"></i></button>
                    <button type="button" class="btn btn-sm btn-success" title="Assign new User" @click="addAssignees(course.id)"><i class="fas fa-user-plus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="small-box bg-light">
                                    <div class="inner"><h3>{{ typeof course.tutors != 'undefined' && course.tutors != null && course.tutors.length != 0 ? course.tutors.length : 1}}</h3><p>Tutors </p></div>
                                    <div class="icon"><i class="fa fa-chalkboard-teacher"></i></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="small-box bg-light">
                                    <div class="inner"><h3>{{ course.price | currency}}</h3><p>Estimated Cost</p></div>
                                    <div class="icon"><i class="fa fa-wallet"></i></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="small-box bg-light">
                                    <div class="inner"><h3> {{ typeof course.assignees != 'undefined' && course.assignees != null ? course.assignees.length : 0}}</h3><p>Enrollees</p></div>
                                    <div class="icon"><i class="fa fa-users"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h3 class="text-primary"><i class="fas fa-book"></i> {{course.name}}</h3>
                                <p class="text-muted">{{course.description}}</p>
                            </div>
                            <div class="col-6">
                                <div class="text-muted">
                                    <p class="text-sm">Category: <b class="d-block">{{typeof course.category != 'undefined' && course.category != null ? course.category.name : ''}}</b></p>
                                    <p class="text-sm">Sub Category: <b class="d-block">{{typeof course.category != 'undefined' && course.category != null ? course.sub_category.name : ''}}</b></p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted">
                                    <p class="text-sm">Certificates: <b class="d-block">{{course.certificate_id > 0 ? 'Yes' : 'No'}}</b></p>
                                    <p class="text-sm">Final Quiz: <b class="d-block">{{course.exam_type_id > 0 ? 'Yes' : 'No'}}</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h3 class="card-title">Tutors</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-sm btn-primary" @click="addTutors(course)"><i class="fas fa-chalkboard-teacher"></i>Add Tutors</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="col-12">
                                        <ul class="list-inline">
                                            <li class="list-inline-item" v-for="user in course.tutors" :key="user.id">
                                                <img v-show="user.tutor.id != -1" :title="user.tutor.first_name+' '+user.tutor.last_name" :alt="user.tutor.first_name+' '+user.tutor.last_name" style="width:50px;" class="table-avatar img-fluid img-circle" :src="user.tutor.image ? '/img/profile/'+user.tutor.image : '/img/profile/default.png'">
                                                <span></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h3 class="card-title">Assigned To</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-sm btn-success" @click="addAssignees(course)"><i class="fas fa-user-plus"></i>Add Assignee</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="col-12">
                                        <ul class="list-inline">
                                            <li class="list-inline-item" v-for="user in course.assignees" :key="user.id">
                                                <img v-show="user.user.id != -1" :title="user.user.first_name+' '+user.user.last_name" :alt="user.user.first_name+' '+user.user.last_name" style="width:50px;" class="table-avatar img-fluid img-circle" :src="user.user.image ? '/img/profile/'+user.user.image : '/img/profile/default.png'">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h3 class="card-title">Modules</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-sm btn-success"><i class="fas fa-plus"></i>Add Module</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="col-12">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Content</th>
                                                    <th>Resources</th>
                                                    <th>Quiz</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="lesson in lessons" :key="lesson.id">
                                                    <td>{{lesson.name}}</td>
                                                    <td :title="lesson.content">{{lesson.content | readMore(25, '...')}}</td>
                                                    <td>
                                                        <button v-show="lesson.video !== null"  type="button" class="btn btn-sm btn-outline-success" @click="viewResource(lesson.video, 'video')">
                                                            <i class="fa fa-video" style="color:green;"></i>
                                                        </button>
                                                        <button type="button" v-show="lesson.file_type == 'pdf'" class="btn btn-sm btn-outline-primary" @click="viewResource(lesson.file, 'pdf')"><i class="fa fa-file-pdf" style="color:red;"></i></button>
                                                        <button type="button" v-show="lesson.file_type == 'doc'" class="btn btn-sm btn-outline-primary" @click="viewResource(lesson.file, 'doc')"><i class="fa fa-file" style="color:blue;" :title="lesson.file"></i></button>
                                                    </td>
                                                    <td>Has Quiz</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <router-link :to="'/learn/admin_area/lesson/'+lesson.id" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></router-link> 
                                                            <button class="btn btn-sm btn-danger" v-on:click="deleteLesson(lesson.id)"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            </div>
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
            departments: [],
            editMode: false,
            exam_types: [],
            form: new Form({}),
            lessons: {},
            sub_categories:[],
            tutors: [],
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
        addAssignees(course){
            this.editMode = false;
            this.course = course;
            Fire.$emit('AssignUserDataFill', this.course);
            $('#assigneeModal').modal('show');
            this.$Progress.finish();
        },
        addTutors(course){
            this.editMode = false;
            //this.course = course;
            Fire.$emit('assignLoad', course);
            //Fire.$emit('CourseDataFill', {});
            $('#tutorModal').modal('show');
            this.$Progress.finish();
        },
        courseReload(response){
            this.categories         = response.data.categories;
            this.certificate_types  = response.data.certificate_types;
            this.course             = response.data.course;
            this.departments        = response.data.departments;
            this.exam_types         = response.data.exam_types;
            this.lessons            = response.data.course.lessons;
            this.tutors             = response.data.tutors;
            this.users              = response.data.users;
            Fire.$emit('CourseRefresh', this.course);
            Fire.$emit('AssignUsers', this.course.assignees);
            Fire.$emit('LecturerFill', this.users);
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
            axios.get('/api/lms/courses/'+this.$route.params.id)
            .then(response =>{
                this.courseReload(response);
                console.log(response.data.course);
                this.$Progress.finish();
                toast.fire({icon: 'success', title: 'Course was loaded successfully',});
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Course was not loaded successfully',})
            });
        },
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('CourseUpdate', course=>{
            this.course = course;
        });
        Fire.$on('reload', response =>{
            this.courseReload(response);
            $('#assigneeModal').modal('hide');
            $('#courseModal').modal('hide');
            $('#tutorModal').modal('hide');
        });        
    }
}
</script>