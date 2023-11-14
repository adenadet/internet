<template>
<section class="container-fluid">
    <div class="modal fade" id="storeModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ editMode ? 'Edit Store' : 'Create New Store'}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal()"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <InventoryFormStore :editMode="editMode"/>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Stores</h3>
                    <div class="card-tools">
                        <button class="btn btn-primary btn-sm" @click="addStore()">Add New</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-hover ">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Branch</th>
                                        <th>Department</th>
                                        <th>Status</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="store in stores.data" :key="store.id">
                                        <td>{{ store.name }}</td>
                                        <td>{{ store.branch != null ? store.branch.name: 'N/A' }}</td>
                                        <td>{{ store.department != null ? store.department.name: 'N/A' }}</td>
                                        <td>{{ store.status != 1 ? 'Inactive' : 'Active' }}</td>
                                        <td>
                                            <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                            <div class="dropdown-menu">
                                                <router-link class="btn btn-block dropdown-item" :to="'./stores/'+store.id"><i class="fa fa-eye mr-1"></i> View </router-link>
                                                <button class="btn btn-block dropdown-item" @click="updateStore(store)"><i class="fa fa-edit mr-1 text-primary"></i> Edit </button>
                                                <button class="btn btn-block dropdown-item" @click="deleteStore(store.id)"><i class="fa fa-trash mr-1 text-danger"></i> Deactivate</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <pagination :data="stores" @pagination-change-page="getInitials">
                        <span slot="prev-nav">&lt; Previous </span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
            </div>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data(){
        return  {
            editMode: false,
            form: new Form({}),
            store: {},
            stores: {},
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('storeReload', response =>{
            this.refreshPage(response)    
        });
    },
    methods:{
        addStore(){
            this.$Progress.start();
            this.editMode = false;
            Fire.$emit('StoreDataFill', {});
            $('#storeModal').modal('show');  
            this.$Progress.finish();
        },
        closeModals(){
            $('#storeModal').modal('hide');
        },
        deleteStore(id){
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
                    this.form.delete('/api/inventory/stores/'+id)
                    .then(response=>{
                        Fire.$emit('storeReload', response);  
                        Swal.fire('Deleted!', 'Category has been deleted.', 'success');
                    })
                    .catch(()=>{
                    Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });
        },
        getInitials(page=1){
            this.$Progress.start();
            axios.get('/api/inventory/stores?page='+page)
            .then(response =>{
                this.refreshPage(response);
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
        refreshPage(response){
            this.stores = response.data.stores;
            this.closeModals();
        },
        updateStore(store){
            this.$Progress.start();
            this.editMode = true;
            Fire.$emit('StoreDataFill', store);
            $('#storeModal').modal('show');
            this.$Progress.finish();         
        },
    },
}
</script>