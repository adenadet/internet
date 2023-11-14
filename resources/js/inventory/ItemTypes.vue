<template>
<section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Type</h3>
                    <div class="card-tools">
                        <button class="btn btn-primary btn-sm" @click="addItemType()">Add New</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table>
                                <thead>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>&nbsp;</th>
                                </thead>
                                <tbody>
                                    <tr v-for="item_type in item_types.data" :key="item_type.id">
                                        <td>{{ item_type.name }}</td>
                                        <td><div v-html="item_type.description"></div></td>
                                        <td>
                                            <button type="button" class="btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                            <div class="dropdown-menu">
                                                <button class="btn btn-block dropdown-item" @click="updateItemType(item_type)"><i class="fa fa-edit mr-1 text-primary"></i> Edit </button>
                                                <button class="btn btn-block dropdown-item" @click="deleteItemType(item_type.id)"><i class="fa fa-trash mr-1 text-danger"></i> Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <pagination :data="item_types" @pagination-change-page="getInitials">
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
            item_type: {},
            item_types: {},
        }
    },
    mounted() {
        Fire.$on('ItemDataFill', item =>{
            this.ItemData.fill(item);
        });
    },
    methods:{
        addItemType(){
            this.$Progress.start();
            this.editMode = false;
            Fire.$emit('ItemTypeDataFill', {});
            $('#itemTypeModal').modal('show');  
            this.$Progress.finish();
        },
        getInitials(page=1){
            this.$Progress.start();
            axios.get('/api/inventory/item_types?page='+page)
            .then(response =>{
                this.refreshPage(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Item Types loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Item Types not loaded successfully',
                })
            });
        },
        refreshPage(response){
            this.items = response.data.items;
        },
        updateItemType(item_type){
            this.$Progress.start();
            this.editMode = true;
            Fire.$emit('ItemTypeDataFill', item_type);
            $('#itemTypeModal').modal('show');  
            this.$Progress.finish();
        },
    },
}
</script>