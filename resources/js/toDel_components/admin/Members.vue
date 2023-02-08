<template>
    <div class="row clearfix">
        <div class="modal fade" id="addNewModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content"></div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>All Members</h2> 
                </div>
                <BranchMembers :branch="branch_id"></BranchMembers>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        data(){
            return {
                users:[],
                branch_id: 3,
            }
        },
        methods:{
            getAllInitials(){
                axios.get('/api/hrms/users')
                .then(response =>{
                    this.users = response.data.users;
                    
                    toast.fire({
                        icon: 'success',
                        title: 'Members loaded successfully',
                    });
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Members not loaded successfully',
                    })
                });
            },
        },
        mounted() {
            this.getAllInitials();
        }
    }
</script>
