<template>
<section class="container-fluid">
    <div class="modal fade" id="itemModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-show="editMode">Edit Item: {{item.name}}</h4>
                    <h4 class="modal-title" v-show="!editMode">New Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModals()"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <InventoryFormItem :editMode="editMode" />
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Items</h3>
                    <div class="card-tools">
                        <button class="btn btn-primary btn-sm" @click="addItem">Add New Item</button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Item Type</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Minimum Level</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in items.data" :key="item.id">
                                <td>{{ item.name }}</td>
                                <td>{{ item.item_type.name }}</td>
                                <td>{{ item.category.name }}</td>
                                <td>{{ item.quantity }}</td>
                                <td>{{ item.minimum_level }}</td>
                                <td>{{ item.current_cost_price | currency }}</td>
                                <td>{{ item.status == 1 ? 'Active' : 'Inactive' }}</td>
                                <td>
                                    <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                    <div class="dropdown-menu">
                                        <button class="btn btn-block dropdown-item" @click="editItem(item)"><i class="fa fa-edit mr-1"></i> Edit </button>
                                        <router-link class="btn btn-block dropdown-item" :to="'./items/'+item.id"><i class="fa fa-boxes mr-1"></i> View</router-link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <pagination :data="items" @pagination-change-page="getInitials">
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
            items: {},
            item: {},
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('itemReload', response =>{
            this.refreshPage(response)    
        });
    },
    methods:{
        addItem(){
            this.$Progress.start();
            this.editMode = false;
            this.item = {};
            Fire.$emit('ItemDataFill', {});
            $('#itemModal').modal('show');
            this.$Progress.finish();  
        },
        closeModals(){
            $('#itemModal').modal('hide');
        },
        editItem(item){
            this.$Progress.start();
            this.editMode = true;
            this.item = item;
            Fire.$emit('ItemDataFill', item);
            $('#itemModal').modal('show');
            this.$Progress.finish();  
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
            this.closeModals();
        },
    },
}
</script>