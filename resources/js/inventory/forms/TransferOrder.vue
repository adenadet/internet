<template>
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="initials-tab" data-toggle="pill" href="#initials" role="tab" aria-controls="initials" aria-selected="true">Initialize</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="items-tab" data-toggle="pill" href="#items" role="tab" aria-controls="items" aria-selected="false">Items</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="confirm-tab" data-toggle="pill" href="#confirm" role="tab" aria-controls="confirm" aria-selected="false">Review</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade show active" id="initials" role="tabpanel" aria-labelledby="initials-tab">
                                <div class="col-md-8 offset-md-2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Name:</label>
                                                <input type="text" class="form-control" id="to_store_id" name="to_store_id" v-model="TransferData.name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Request To:</label>
                                                <select class="form-control" id="to_store_id" name="to_store_id" v-model="TransferData.to_store_id">
                                                    <option value="">--Select Store</option>
                                                    <option v-for="store in available_stores" :value="store.id">{{ store.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Request For:</label>
                                                <select class="form-control" id="from_store_id" name="from_store_id" v-model="TransferData.from_store_id">
                                                    <option value="">--Select Store</option>
                                                    <option v-for="store in my_stores" :value="store.id">{{ store.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Description:</label>
                                                <wysiwyg rows="5" id="description" name="description" v-model="TransferData.description" />
                                            </div>
                                        </div>
                                        <div class="col-md-12"><button class="btn btn-sm btn-primary" @click="moveTab()">Next</button></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="items" role="tabpanel" aria-labelledby="items-tab">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Search for Item</h3>
                                            </div>
                                            <div class="card-body">
                                                <form>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Name</label>
                                                                <input type="text" class="form-control" id="name" name="name" v-model="ItemData.name" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Type</label>
                                                                <select class="form-control" id="item_type_id" name="item_type_id" v-model="ItemData.item_type_id">
                                                                    <option value=''>--Select Item Type--</option>
                                                                    <option v-for="item_type in types" :value="item_type.id">{{ item_type.name }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Category</label>
                                                                <select class="form-control" id="category_id" name="category_id" v-model="ItemData.category_id">
                                                                    <option value=''>--Select Category--</option>
                                                                    <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-sm btn-primary" type="button" @click.prevent="searchItems()">Search</button>
                                                </form>
                                            </div>
                                            <div class="card-body">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item" v-for="item in search_results" :key="item.id">
                                                        <button class="nav-link btn btn-block btn-sm" @click="addItem(item)">
                                                        {{ item.name }} <span class="float-right badge bg-primary"><i class="fa fa-plus"></i></span>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">List of Items</h3>
                                            </div>
                                            <div class="card-body p-0">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 10px">#</th>
                                                            <th>Item</th>
                                                            <th>Quantity</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, index) in TransferData.items">
                                                            <td>{{ index | addOne }}</td>
                                                            <td>{{ item.name }}</td>
                                                            <td><input type="number" class="form-control" v-model="TransferData.items[index].requested_quantity"/></td>
                                                            <td><button class="btn btn-sm btn-danger" @click="itemPop(item)"><i class="fa fa-trash"></i></button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="card-footer">
                                                <button type="button" class="btn btn-sm btn-primary float-right" @click="submit()">Complete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="confirm" role="tabpanel" aria-labelledby="confirm-tab">
                                <InventoryDetailTransferOrder :transfer_order="TransferData" />
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
    data() {
        return {
            available_stores: [],
            types: [],
            categories: [],
            editMode: false,
            form: new Form({}),
            ItemData: new Form({
                name: '', 
                item_type_id: '',
                category_id: '', 
                quantity: '', 
                minimum_level: '', 
                current_cost_price: '', 
            }),
            my_stores: [],
            search_results: [],
            transfer_order: {},
            TransferData: new Form({
                description: '',
                from_store_id: '',
                items: [],
                name: '',
                to_store_id : '',    
            }),
            transfer_orders: {},
            types: [],
            
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('transferRequestReload', response => {
            this.refreshPage(response)
        });
    },
    methods: {
        addItem(item){
            const { length } = this.TransferData.items;
            const id = length + 1;
            const found = this.TransferData.items.some(el => el.id === item.id);
            if (!found) this.TransferData.items.push({ id: item.id, name: item.name, requested_quantity: 1});
            else{
                const index = this.TransferData.items.findIndex(object => {
                    return object.id === item.id;
                });

                this.TransferData.items[index].requested_quantity++; 
            }
        },
        closeModals() {
            $('#storeModal').modal('hide');
        },
        deleteStore(id) {
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
                if (result.value) {
                    this.form.delete('/api/inventory/transfer_orders/' + id)
                        .then(response => {
                            Fire.$emit('storeReload', response);
                            Swal.fire('Deleted!', 'Category has been deleted.', 'success');
                        })
                        .catch(() => {
                            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>' });
                        });
                }
            });
        },
        getInitials(page = 1) {
            this.$Progress.start();
            axios.get('/api/inventory/transfer_orders/initials')
            .then(response => {
                this.refreshPage(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Transfer Requests loaded successfully',
                });
            })
            .catch(() => {
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Transfer Requests not loaded successfully',
                })
            });
        },
        itemPop(item){
            const index = this.TransferData.items.findIndex(object => {
                return object.id === item.id;
            });
            this.TransferData.items.splice(index, 1)
        },
        refreshPage(response) {
            this.available_stores = response.data.stores;
            this.categories = response.data.categories;
            this.my_stores = response.data.my_stores;
            this.types = response.data.types;
            this.closeModals();
        },
        searchItems(){
            this.ItemData.post('/api/inventory/items/search')
            .then(response =>{
                this.search_results = response.data.search_results;
                this.$Progress.finish();
            })
            .catch(()=>{
                Swal.fire({
                    icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: 'Please try again later!'
                });
                this.$Progress.fail();
            });
        },
    },
}
</script>