<template>
<div class="container-fluid">
    <div class="row clearfix">
        <div class="modal fade" id="BranchModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-show="editMode">Edit Branch: {{branch.name}}</h4>
                        <h4 class="modal-title" v-show="!editMode">New Branch</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <BranchForm :editMode="editMode" :branch="branch" :users="users" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Branches</h3>
                    <div class="card-tools"><button type="button" class="btn btn-sm btn-primary" data-card-widget="collapse" @click="addBranch">Add New</button></div>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table m-b-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Practice Manager</th>
                                    <th>Consultant In Charge</th>
                                    <th>Head of Nurse </th>
                                    <th>Number</th>
                                    <th>Address</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="branch in branches.data" :key="branch.id">
                                    <td>{{branch.name}}</td>
                                    <td>{{branch.pm_id !== null && branch.practice_manager != null ? branch.practice_manager.first_name+' '+branch.practice_manager.last_name : ''}}</td>
                                    <td>{{branch.cinc_id !== null && branch.chief_consultant != null ? branch.chief_consultant.first_name+' '+branch.chief_consultant.last_name : ''}}</td>
                                    <td>{{branch.hon_id !== null && branch.head_nurse != null ? branch.head_nurse.first_name+' '+branch.head_nurse.last_name : ''}}</td>
                                    <td>{{branch.users.length}}</td>
                                    <td :title="branch.address">{{branch.address}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <router-link :to="'/branches/'+branch.id" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></router-link>
                                            <button class="btn btn-sm btn-primary" @click="editBranch(branch)"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger" @click="deleteBranch(branch.id)"><i class="fa fa-trash"></i></button>
                                        </div>          
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <pagination :data="branches" @pagination-change-page="getbranches">
                        <span slot="prev-nav">&lt; Previous </span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
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
            editMode: false,
            branch: {},
            branches: {},
            dept_users: [],
            form: new Form({}),
            users: [],   
        }
    },
    methods:{
        addBranch(){
            this.$Progress.start();
            this.editMode = false;
            this.Branch = {};
            Fire.$emit('BranchDataFill', {});
            $('#BranchModal').modal('show');
            this.$Progress.finish();
        },
        deleteBranch(id){
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
                    this.form.delete('/api/ums/branches/'+id)
                    .then(response=>{
                        Swal.fire('Deleted!', 'Branch has been deleted.', 'success');
                        this.branches = response.data.branches
                        Fire.$emit('BranchRefresh', response);   
                    })
                    .catch(()=>{
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });
        },
        editBranch(branch){
            this.$Progress.start();
            this.editMode = true;
            this.branch = branch;
            Fire.$emit('BranchDataFill', branch);
            $('#BranchModal').modal('show');
            this.$Progress.finish();
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/ums/branches').then(response =>{
                this.refresh(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'branches were loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'branches were not loaded successfully',
                })
            });
        },
        getbranches(page=1){
            axios.get('/api/ums/branches?page='+page)
            .then(response=>{
                this.branches = response.data.branches;   
            });
        },
        refresh(response){
            this.branches = response.data.branches;
            this.users = response.data.users;
        },
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('BranchRefresh', response =>{
            this.refresh(response);
            $('#BranchModal').modal('hide');
        });
    }
}
</script>