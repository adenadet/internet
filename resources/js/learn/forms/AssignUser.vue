<template>
    <div>
        <form @submit.prevent="assignUsers"> 
        <alert-error :form="AssignData"></alert-error> 
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>Start Date</label>
                        <input name="start_date" id="start_date" type="date" data-provide="datepicker" data-date-autoclose="true" class="form-control" placeholder="Start Date" v-model="AssignData.start_date" :class="{'is-invalid' : AssignData.errors.has('start_date') }">
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>End Date</label>
                        <input name="end_date" id="end_date" type="date" data-provide="datepicker" data-date-autoclose="true" class="form-control" placeholder="Start Date" v-model="AssignData.end_date" :class="{'is-invalid' : AssignData.errors.has('end_date') }">
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>Department</label>
                        <select class="form-control" id="department_id" name="department_id" placeholder="Enter Street Desc" v-model="AssignData.department_id" :class="{'is-invalid' : AssignData.errors.has('department_id') }" @change="updateUsers">
                            <option value="">---Select Department---</option>
                            <option value="1000">All Users</option>
                            <option v-for="(dept, index) in departments" :value="index" :key="dept.id">{{dept.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>Users <span><small>You can choose multiple</small></span></label>
                        <select class="form-control" id="user_id" name="user_id[]" multiple v-model="AssignData.user_id" :class="{'is-invalid' : AssignData.errors.has('user_id') }" required>
                            <option value="">--Select Users--</option>
                            <option value="-1">All Department Staff</option>
                            <option v-for="user in users" :value="user.id" :key="user.id">{{user.first_name}} {{user.middle_name}} {{user.last_name}}</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6 col-sm-12">
                    <input v-show="!editMode" type="submit" name="submit" class="submit btn btn-success" value="Submit" />
                    <input v-show="editMode" type="submit" name="submit" class="submit btn btn-success" value="Update" />
                </div>
            </div>
        </form>
    </div>
</template>
<script>
export default {    
    data(){
        return {   
            course:{},
            AssignData: new Form({
                id:'',
                ref_type: '', 
                course_id: '',
                start_date: '',
                end_date: '',
                user_id: [], 
                department_id:'',
                dept_id: '',
            }),
            departments: [],
            route: '',
            users: [],
        }
    },
    methods:{
        assignUsers(){
            alert(this.course.id);
            this.$Progress.start();
            this.AssignData.course_id = this.course.id;
            this.AssignData.ref_type = 'assign_user';
            this.AssignData.post('/api/lms/assign_users')
            .then(response=>{
                Fire.$emit('AssignUsers', response.data.assignees);
                Fire.$emit('CourseUpdate', response.data.course );
                Fire.$emit('CourseRefresh', response.data.course);
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({icon: 'error',title: 'Your form was not sent try again later!',});
            })
        },
        getInitials(){
            axios.get('/api/lms/assign_users').then(response =>{
                this.departments = response.data.departments;
                this.users = response.data.users;
            })
            .catch(()=>{
                toast.fire({
                    icon: 'error',
                    title: 'Departments were not loaded successfully',
                })
            });
        },
        updateList(){
            if (in_array(-1, this.AssignData.user_id)){
                console.log('Yue');

            }
            else{

            }
            console.log(this.AssignData.user_id);
            
        },
        updateUsers(){
            this.AssignData.dept_id = this.departments[this.AssignData.department_id].id;
            if (this.AssignData.department_id != 1000){
                this.AssignData.user_id = [];
                this.users = this.departments[this.AssignData.department_id].users;
            }
            console.log(this.AssignData.department_id); 
        },
         
    },
    mounted() {
        this.getInitials();
        Fire.$on('AssignData', () =>{
            this.AssignData.type = this.aspire;
            this.AssignData.ref_id = this.reference.id;        
            });
        Fire.$on('CourseRefresh', course =>{this.course = course;});
        Fire.$on('ExamDataFill', exam =>{
            this.ExamData.reset();
            this.ExamData.fill(exam)
            //this.examData.course_id = typeof exam.course != 'undefined' ? exam.course.id : this.course.id;
        });
    },
    props: {
        'editMode': Boolean,
        'reference': Object,
        'aspire': String,
        //'course': Object,
    },
}
</script>