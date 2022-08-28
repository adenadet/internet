<template>
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Branchs</h3>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table m-b-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Practice Manager</th>
                                    <th>Consultant in Charge</th>
                                    <th>Head of Nurse </th>
                                    <th>Number</th>
                                    <th>Description</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="branch in branches.data" :key="branch.id">
                                    <td>{{branch.name}}</td>
                                    <td>{{branch.pm_id !== null ? branch.practice_manager.first_name+' '+branch.practice_manager.last_name : ''}}</td>
                                    <td>{{branch.cinc_id !== null ? branch.chief_consultant.first_name+' '+branch.chief_consultant.last_name : ''}}</td>
                                    <td>{{branch.hon_id !== null ? branch.head_nurse.first_name+' '+branch.head_nurse.last_name : ''}}</td>
                                    <td>{{branch.users.length}}</td>
                                    <td :title="branch.address">{{branch.address}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <router-link :to="'/branches/'+branch.id" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></router-link>
                                        </div>          
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <pagination :data="branches" @pagination-change-page="getBranchs">
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
            branches: {},
        }
    },
    methods:{
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/ums/branches').then(response =>{
                this.refresh(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Branchs were loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Branchs were not loaded successfully',
                })
            });
        },
        getBranchs(page=1){
            axios.get('/api/ums/branches?page='+page)
            .then(response=>{
                this.branches = response.data.branches;   
            });
        },
        refresh(response){
            this.branches = response.data.branches;
            this.users = response.data.users;
            //Fire.$emit('LecturerFill', this.users);
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