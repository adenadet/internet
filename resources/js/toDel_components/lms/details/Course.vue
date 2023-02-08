<template>
    <div>
        <div class="invoice p-3 mb-3">
            <div class="modal fade" id="assigneeModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Assign Users</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <LmsFormAssignUser aspire="u_course" :reference="course"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row invoice-info">
                <div class="col-sm-12 invoice-col">
                    <b>{{course ? course.name: ''}}</b><br>
                    <br>
                    <p>{{course.description}}</p>
                    <b>Category:</b> {{((course.category_id !== null) &&(typeof course.category !== 'undefined'))? course.category.name : 'Undefined'}}<br>
                    <b>Sub Category:</b> {{((course.sub_category_id !== null)&&(typeof course.sub_category !== 'undefined')) ? course.sub_category.name : 'Undefined'}}<br>
                    <b>Price:</b> &#x20a6; {{course.price | currency}}
                </div>
                <div class="col-sm-12">
                    <ul class="list-inline">
                        <li class="list-inline-item" v-for="user in assignees" :key="user.id">
                            <img v-show="user.user.id != -1" :title="user.user.first_name+' '+user.user.last_name" :alt="user.user.first_name+' '+user.user.last_name" style="width:50px;" class="table-avatar img-fluid img-circle" :src="user.user.image ? '/img/profile/'+user.user.image : '/img/profile/default.png'">
                        </li>
                        <li class="list-inline-item"><button class="btn btn-sm btn-success" title="Add New Examinees" @click="addCourseAssignee(course)"><i class="fa fa-user-plus"></i></button></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Modules</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Assigned To</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Tutor(s)</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                    <LmsDetailCourseLessons :lessons="course.lessons" :course="course" />
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                    <LmsDetailCourseAssignedTo :assignees="course.assignees" />
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                                    {{course.description}}
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                                    <div class="row">
                                        <LmsDetailContact  v-for="user in course.tutors" :key="user.id" :user="user.tutor"/>
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
            assignees: [],
            form: new Form({}),
            subCategory: {},
            editMode: true,
        }
    },
    methods:{
        addCourseAssignee(course){
            this.course = course;
            Fire.$emit('AssignData');
            $('#assigneeModal').modal('show');
        },
        addCourseTutor(){
            this.subCategory = {};
            this.editMode = true;
            Fire.$emit('editSubCategory', subCategory);
            $('#subCategoryModal').modal('show');
            },
        deleteCourseUser(id){
            Swal.fire({
                title: 'Are you sure?', text: "You won't be able to revert this!",
                icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33', confirmButtonText: 'Yes, delete it!'
                })
            .then((result) => {
                if(result.value){
                    this.form.delete('/api/lms/sub_categories/'+id)
                    .then(response =>{
                        Swal.fire('Deleted!', 'Category has been deleted.', 'success');
                        Fire.$emit('CatRefresh', response);   
                    })
                    .catch(()=>{
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                        });
                    }
                });  
            },
        editCourseUser(sub_category){
            this.subCategory = sub_category;
            this.editMode = true;
            Fire.$emit('editSubCategory', sub_category);
            $('#subCategoryModal').modal('show');
            },
        },
    mounted() { 
        //Fire.$emit('courseRefresh', response);
        Fire.$on('AssignUsers', assignees => {
            $('#assigneeModal').modal('hide');
            this.assignees = assignees;
        });
        Fire.$on('refresh', response =>{$('#lessonModal').modal('hide');});
        
    },
    props: {
        'category_name': String,
        'categories': Array,
        'course': Object,
        'sub_categories': Array,
    },
}
</script>