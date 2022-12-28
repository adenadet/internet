<template>
    <div class="row clearfix">
        <div class="modal fade" id="addNewModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                <FormGuarantee :guarantee="guarantee" :users="users"></FormGuarantee>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>All Guarantor Requests</h2> 
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table m-b-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Unique ID</th>
                                    <th>Members</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="branch in branches" :key="branch.id" :value="branch.id">
                                    <td><router-link :to="'/admin_area/branch/'+branch.id" ><span>{{branch.name}}</span></router-link></td>
                                    <td><span>{{branch.unique_id}}</span></td>
                                    <td><span>{{branch.current}}</span></td>
                                    <td><span>{{branch.location}}</span></td>
                                    <td>
                                        <span class="badge badge-warning" v-show="branch.status == 1">Active</span>
                                        <span class="badge badge-warning" v-show="branch.status == 2">Non-active</span>
                                        <span class="badge badge-success" v-show="branch.status == 3">Deactivated</span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                        <button class="btn btn-sm btn-primary" v-on:click="editbranch(branch)">Edit</button>
                                        <button class="btn btn-sm btn-danger" v-on:click="rejectbranch(branch.id)">Delete</button>
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
</template>


<script>
export default {
    data(){
        return {
            branches:{},
        }
    },
    methods:{
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/coop/branches').then(response =>{
                this.branches = response.data.branches;
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Branches not loaded successfully',
                })
            });
        },
        refresh(){
            $('#addNewModal').modal('hide');
            this.getAllInitials();
        },
    },
    mounted() {
        this.getAllInitials();   
        Fire.$on('editRepayment', repayment =>{
                this.editRepayment(repayment);
            });  
        Fire.$on('Refresh', () =>{
                this.refresh();   
            }); 
        },
}
</script>
