<template>
<div class="body">
<form @submit.prevent="aspire == 'u_course' ? assignUsers() : assignTutors()">
    <alert-error :form="assignUserData"></alert-error> 
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label>Course Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name *" v-model="assignUserData.course_name" disabled required>
                <input type="hidden" id="course_id" name="course_id" v-model="assignUserData.course_id" />
            </div>
        </div>
    </div>
    <div class="row" v-if="aspire == 'u_course'">
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label>Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" v-model="assignUserData.start_date" required>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label>End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" v-model="assignUserData.end_date" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div v-show="aspire == 'u_course'" class="col-md-12 col-sm-12">
            <div class="form-group">
                <label>Departments</label>
                <select class="form-control" id="department_id" name="department_id" v-model="assignUserData.department_id" required @change="setDeptUser">
                    <option value="">--Select Department--</option>
                    <option value=-1>All Department</option>
                    <option v-for="(department, index) in departments" :key="department.id" :value="index">{{department.name}}</option>
                </select>
            </div>
        </div>
        <div class="row" v-if="assignUserData.department_id == '-1'">
            <div class="col-sm-3" v-for="user in users" :key="user.id">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="users[]" v-model="assignUserData.users" :value="user.id" :checked="assignUserData.users.includes(user.id)">
                    <label class="form-check-label">{{user.unique_id}} | {{user.first_name}} {{user.last_name}}</label>
                </div>
            </div>
        </div>
        <div class="row" v-else>
            <div class="col-sm-3" v-for="user in dept_users" :key="user.id">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="users[]" id="users[]" v-model="assignUserData.users" :value="user.id" :checked="assignUserData.users.includes(user.id)">
                    <label class="form-check-label">{{user.unique_id}} | {{user.first_name}} {{user.last_name}}</label>
                </div>
            </div>
        </div>
    </div>
    <input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
</form>
</div>
</template>
<script>
export default {
    created(){
        Fire.$on('assignLoad', course =>{this.reloadData(course);});
    },
    data(){
        return {
            assignUserData: new Form({
                'course_id': '',
                'course_name': '',
                'department_id': -1,
                'users': [],
            }),
            dept_users: {},
        }
    },
    methods:{
        assignUsers(){
            this.$Progress.start();
            this.assignUserData.post('/api/lms/course/assign')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Course has been updated',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(()=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please try again later!'
                });
                this.$Progress.fail();
            });
        },
        reloadData(course){
            this.assignUserData.course_id   = course.id; 
            this.assignUserData.course_name = course.name; 
            this.assignUserData.users = [];
            for (let i = 0; i < course.assignees.length; i++) {this.assignUserData.users.push(course.assignees[i].id);}    
        },
        setDeptUser(){
            //this.prev_cat = false;
            this.dept_users = this.departments[this.assignUserData.department_id].users;
            this.sub_categories = this.categories[this.courseData.category_id].sub_categories;
        },
    },
    mounted() {
        Fire.$on('AssignUserDataFill', course =>{
            this.reloadData(course);
        });
        Fire.$on('CourseUpdate', course=>{
            this.course = course;
        });
    },
    props:{
        'course': Object,
        'departments': Array,
        'users': Array,
        'aspire': String,
    },
}
</script>