<template>
<section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Categories</h3>
                    <div class="card-tools">
                        <button class="btn btn-primary btn-sm">Add New</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table>
                                <thead>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Parent Category</th>
                                    <th>&nbsp;</th>
                                </thead>
                                <tbody>
                                    <tr v-for="category in categories.data" :key="category.id">
                                        <td>{{ category.name }}</td>
                                        <td>{{ category.type != null ? category.type.name: 'N/A' }}</td>
                                        <td>{{ category.parent != null ? category.parent.name : 'N/A' }}</td>
                                        <td>
                                            <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                            <div class="dropdown-menu">
                                                <router-link class="btn btn-block dropdown-item" :to="'/admin/branches/'+branch.id"><i class="fa fa-eye mr-1 text-primary"></i> View </router-link>
                                                <button class="btn btn-block dropdown-item" @click="deleteBranch(1)"><i class="fa fa-trash mr-1 text-danger"></i> Delete Loan Request</button>
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
    </div>
</section>
</template>
<script>
export default {
    data(){
        return  {
            editMode: false,
            categories: {},
        }
    },
    mounted() {
        Fire.$on('ItemDataFill', item =>{
            this.ItemData.fill(item);
        });
    },
    methods:{
        createItem(){
            this.$Progress.start();
            this.ItemData.post('/api/inventory/items')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Item has been created',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(()=>{
                Swal.fire({
                    icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: 'Please try again later!'
                });
                this.$Progress.fail();
            });  
        },
        getInitials(page=1){
            this.$Progress.start();
            axios.get('/api/inventory/items?page='+page)
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
            this.items = response.data.items;
        },
        updateItem(){
            this.$Progress.start();
            this.ItemData.put('/api/inventory/items/'+this.ItemData.id)
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Item has been updated',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(()=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please try again later!'
                });
                this.$Progress.fail();
            });              
        },
    },
}
</script>