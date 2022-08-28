<template>
    <div class="row clearfix">
        <div class="modal fade" id="userModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-show="editMode">Edit User: {{user.unique_id}}</h4>
                        <h4 class="modal-title" v-show="!editMode">New User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <FormBioData :areas="areas" :branches="branches" :departments="departments" :editMode="editMode" :states="states" :user="user"/>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <section class="col-md-12 content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Contacts</h1>
                    </div>
                    <div class="col-sm-6">
                    <button class="btn btn-sm btn-primary float-sm-right" @click="addUser()">Add New User <i class="fa fa-user-add"></i></button>
                    </div>
                </div>
            </div>
        </section>
        <div class="col-lg-3 col-md-4 col-sm-6 d-flex align-items-stretch" v-for="user in users.data" :key="user.id">
            <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0">&nbsp;</div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-7">
                            <h2 class="lead"><b>{{user.first_name}} {{user.middle_name}} {{user.last_name}}</b></h2>
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span> Email: {{user.email}}</li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Dept: {{((typeof user.department != 'undefined') && (user.department !== null))? user.department.name: ''}}</li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: {{user.phone}}</li>
                            </ul>
                        </div>
                        <div class="col-5 text-center">
                            <img :src="(user.image) ? '/img/profile/'+user.image : '/img/profile/default.png'" alt="" class="img-circle img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-right">
                        <button class="btn btn-sm btn-primary" @click="editUser(user)" title="Edit Staff"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger" @click="deleteUser(user.id)" title="Delete Staff"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12">
            <pagination :data="users" @pagination-change-page="getUser">
                <span slot="prev-nav">&lt; Previous </span>
                <span slot="next-nav">Next &gt;</span>
            </pagination>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                areas:[],
                branches:[],
                departments:[],
                editMode: false,
                savings:{},
                states:[],
                user:{},
                users:{},
                form: new Form({}),
            }
        },
        methods:{
            addUser(){
                this.editMode = false;
                this.user = {};
                Fire.$emit('BioDataFill', this.user);
                $('#userModal').modal('show');

                this.$Progress.finish();
            },
            deleteUser(id){
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
                        this.form.delete('/api/hrms/users/'+id)
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
            editUser(user){
                this.$Progress.start();
                this.editMode = true;
                this.user = user;
                Fire.$emit('BioDataFill', user);
                $('#userModal').modal('show');

                this.$Progress.finish();
            },
            setUserRole(user){
                this.$Progress.start();
                this.user = user;
                Fire.$emit('UserRoleDataFill', user.role);
                $('#roleModal').modal('show');

                this.$Progress.finish();
            },
            getAllInitials(){
                this.$Progress.start();
                axios.get('/api/hrms/users').then(response =>{
                    this.areas = response.data.areas;
                    this.branches = response.data.branches;
                    this.departments = response.data.departments;
                    this.states = response.data.states;
                    this.users = response.data.users;
                    
                    this.$Progress.finish();
                    toast.fire({
                        icon: 'success',
                        title: 'Users loaded successfully',
                    });
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Users not loaded successfully',
                    })
                });
            },
            getUser(page=1){
                axios.get('/api/hrms/users?page='+page)
                .then(response=>{
                    this.users = response.data.users;   
                });
            },
        },
        mounted() {
            this.getAllInitials();
            Fire.$on('searchInstance', ()=>{
                let query = this.$parent.search;
                axios.get('/api/hrms/users/search?q='+query)
                .then((response ) => {
                    this.users = response.data.users;
                })
                .catch(()=>{

                });
            });
        }
    }
</script>