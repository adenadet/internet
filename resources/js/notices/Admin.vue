<template>
<div class="col-12">
    <div class="modal fade" id="noticeModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ editMode ? 'Edit Notice: '+ notice.topic : 'Create New Notice'}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <NoticeForm :departments="departments" :editMode="editMode" :notice="notice"/>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List of All Notices</h3>
            <div class="card-tools"><button type="button" class="btn btn-sm btn-success" @click="createNotice">Add New</button></div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table m-b-0 col-md-12">
                <thead class="thead-dark">
                    <tr>
                        <th>Topic</th>
                        <th>Content</th>
                        <th>Created By</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="notice in notices.data" :key="notice.id">
                        <td><h6 class="mb-0">{{notice.topic}}</h6></td>
                        <td :title="notice.content">{{notice.content | readMore(25, '...')}}</td>
                        <td>{{typeof notice.creator != 'undefined' && notice.creator != null ? notice.creator.first_name+' '+notice.creator.last_name: 0 }}</td>
                        <td>{{notice.start_date | excelDate }}</td>
                        <td>{{notice.end_date | excelDate }}</td>
                        <td>
                            <div class="btn btn-group">
                                <router-link class="btn btn-primary" title="Read Notice" :to="'/notices/'+notice.id"><i class="fa fa-eye"></i></router-link>
                                <button class="btn btn-success" title="Edit Notice" @click="editNotice(notice)"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-danger"  title="Delete Notice" @click="deleteNotice(notice.id)"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <pagination :data="notices" @pagination-change-page="getUser">
                <span slot="prev-nav">&lt; Previous </span>
                <span slot="next-nav">Next &gt;</span>
            </pagination>
        </div>
    </div>    
</div>
</template>
<script>
export default {
    data(){
        return {
            categories: {},
            departments: [],
            editMode: false,
            form: new Form({}),
            notice: {},
            notices: {},
        }
    },
    methods:{
        createNotice(){
            this.editMode = false;
            this.notice = {};
            Fire.$emit('noticeDataFill', this.notice);
            $('#noticeModal').modal('show');
        },
        deleteNotice(id){
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
                    this.form.delete('/api/notices/'+id)
                    .then(response=>{
                    Swal.fire('Deleted!', 'Notice has been deleted.', 'success');
                    Fire.$emit('CatRefresh', response);   
                    })
                    .catch(()=>{Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!',});});
                }
            }); 
        },
        editNotice(notice){
            this.editMode = true;
            this.notice = notice;
            Fire.$emit('noticeDataFill', notice);
            $('#noticeModal').modal('show');
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/notices').then(response =>{
                this.reset(response);
                this.$Progress.finish();
                toast.fire({icon: 'success', title: 'Notice loaded successfully',});
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Notice not loaded successfully',});
            });
        },
        getUser(page=1){
            axios.get('/api/notices?page='+page)
            .then(response=>{this.notices = response.data.notices;});
        },
        reset(response){
            this.categories = response.data.categories;
            this.departments = response.data.departments;
            this.notices = response.data.notices;

            $('#assignModal').modal('hide');
            $('#noticeModal').modal('hide');
        }
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('reloadNotice', response =>{this.reset(response); console.log("Updated")});
    }   
}
</script>