<template>
    <div class="body">
        <div class="table-responsive">
            <table class="table m-b-0">
                <thead class="thead-dark">
                    <tr>
                        
                        <th>Name</th>
                        <th>Unique ID</th>
                        <th>Branch</th>
                        <th>Phone Number</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td>
                            <h6 class="mb-0">{{user.first_name}} {{user.middle_name}} {{user.last_name}}</h6>
                            <span>{{user.email}}</span>
                        </td>
                        <td><span>{{user.unique_id}}</span></td>
                        <td><span v-show="(user.branch_id)">
                            <router-link :to="'/admin_area/branch/'+ user.branch_id"> {{user.branch.name}}</router-link>
                        </span></td>
                        <td>{{user.phone}}</td>
                    </tr>
                </tbody>
            </table>
            <pagination :data="loadMembers" @pagination-change-page="getResults"></pagination>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                users:[],
            }
        },
        methods:{
            getResults(page = 1){
                axios.get('/api/hrms/users?branch_id='+this.branch_id+'&page='+page)
                .then(response =>{
                    this.users = response.data.users;
                    toast.fire({
                        icon: 'success',
                        title: 'Members loaded successfully',
                    });
                })
                .catch(()=>{
                    toast.fire({
                        icon: 'error',
                        title: 'Members not loaded successfully',
                    })
                });
            },
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
        },
        props: {
            'branch_id': integer,
        },
    }
</script>
