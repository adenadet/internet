<template>
    <section class="container-fluid">
        <div class="row">
            <div class="modal fade" id="leaveTypeModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ editMode ? 'Edit Leave Type: '+ leave_type.name : 'Create New Leave Type'}}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <HrmsLeaveFormType :editMode="editMode" :leave_type="leave_type"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Leave Types</h3>
                        <div class="card-tools">
                            <button class="btn btn-sm btn-primary" @click="addNewLeaveType()" type="button"><i class="fa fa-plus mr-1"></i> Add New</button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Number of Days</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody v-if="leave_types.data != null && leave_types != null">
                            <tr v-for="(leave_type, index) in leave_types" :key="leave_type.id">
                                <td>{{ index | addOne }}</td>
                                <td>{{ leave_type.name }}</td>
                                <td>{{ leave_type.no_of_days }}</td>
                                <td>{{ leave_type.start_date }}</td>
                                <td>{{ leave_type.end_date }}</td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td>No Leave Type has been created</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    data(){
        return {
            editMode: false,
            form: new Form({}),
            leave_types: {},
            leave_type: {},
        }
    },
    methods:{
        addNewLeaveType(){
            this.leave_type = {},
            this.editMode = false;
            Fire.$emit('leaveTypeDataFill', {});
            $('#leaveTypeModal').modal('show');
        },
        assignLeaveType(){},
        deleteLeaveType(id){
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
                if(result.value){
                    this.form.delete('/api/hrms/leave_types/'+id)
                    .then(response=>{
                        Swal.fire('Deleted!', 'Leave Type has been deleted.', 'success');
                        Fire.$emit('CatRefresh', response);   
                    })
                    .catch(()=>{
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!',});}
                    );
                }
            });
        },
        editLeaveType(leave_type){
            this.editMode = true;
            this.leave_type = leave_type;
            Fire.$emit('leaveTypeDataFill', leave_type);
            $('#leaveTypeModal').modal('show');
        },
        getAllInitials(page=1){
            alert(page)
            this.$Progress.start();
            axios.get('/api/hrms/leave_types?page='+page+'&search='+this.search).then(response =>{
                this.reset(response);
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Leave Types did not load successfully',});
            });
        },
        reset(response){
            this.leave_types = response.data.leave_types;
            //this.departments = response.data.departments;
            //this.policies = response.data.policies;

            $('#assignLeaveTypeModal').modal('hide');
            $('#leaveTypeModal').modal('hide');
        }
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('reloadLeaveTypes', response =>{this.reset(response);});
        Fire.$on('reloadPage', () =>{this.getAllInitials();});
    }   
}
</script>