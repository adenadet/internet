<template>
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Notices</h3>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table m-b-0">
                            <thead>
                                <tr>
                                    <th>Topic</th>
                                    <th>Content</th>
                                    <th>Creator</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="notice in notices.data" :key="notice.id">
                                    <td>{{notice.topic}}</td>
                                    <td :title="notice.content">{{notice.content | readMore(25, '...')}}</td>
                                    <td>{{notice.user_id !== null && notice.creator != null ? notice.creator.first_name+' '+notice.creator.last_name : 'Undefined User'}}</td>
                                    <td>{{notice.start_date | excelDate}}</td>
                                    <td>{{notice.end_date | excelDate}}</td>
                                    <td><div class="btn-group"><router-link :to="'/notices/'+notice.id" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></router-link></div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <pagination :data="notices" @pagination-change-page="getNotices">
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
        return {notices: {},}
    },
    methods:{
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/notices').then(response =>{
                this.refresh(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Notices were loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Departments were not loaded successfully',
                })
            });
        },
        getNotices(page=1){
            axios.get('/api/ums/notices?page='+page)
            .then(response=>{
                this.notices = response.data.notices;   
            });
        },
        refresh(response){
            this.notices = response.data.notices;
            console.log('Working');
        },
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('DepartmentRefresh', response =>{
            this.refresh(response);
            $('#DepartmentModal').modal('hide');
        });
        Fire.$on('DepartmentUpdate', Department=>{
            this.Department = Department;
        });
        Fire.$on('GetDepartment', response =>{
            this.refresh(response);
            $('#DepartmentModal').modal('hide');
        });
    }
}
</script>