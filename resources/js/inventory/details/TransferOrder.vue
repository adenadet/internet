<template>
<section>
    <div class="container-fluid">
        <div class="invoice p-3 mb-3">
            <div class="row">
                <div class="col-12">
                    <h4>
                        <i class="fas fa-globe"></i>Transfer Order
                        <small class="float-right">Date: 2/10/2014</small>
                    </h4>
                </div>
            </div>
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    From
                    <address>
                        <strong>Admin, Inc.</strong><br>
                        795 Folsom Ave, Suite 600<br>
                        San Francisco, CA 94107<br>
                        Phone: (804) 123-5432<br>
                        Email: info@almasaeedstudio.com
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">
                    To
                    <address>
                        <strong>John Doe</strong><br>
                        795 Folsom Ave, Suite 600<br>
                        San Francisco, CA 94107<br>
                        Phone: (555) 539-1037<br>
                        Email: john.doe@example.com
                    </address>
                </div>
                <div class="col-sm-4 invoice-col">
                    <b>Invoice #007612</b><br>
                    <br>
                    <b>Order ID:</b> 4F3S8J<br>
                    <b>Payment Due:</b> 2/22/2014<br>
                    <b>Account:</b> 968-34567
                </div>
            </div>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="10%">Serial #</th>
                                <th width="30%">Item</th>
                                <th width="20%">Requested Qty</th>
                                <th width="20%" v-if="transfer_order.status == 1 || transfer_order.status == 3">Approved Qty</th>
                                <th width="20%" v-if="transfer_order.status == 3">Issued Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item,index) in transfer_order.items">
                                <td>{{index | addOne}}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.requested_quantity }}</td>
                                <td v-if="transfer_order.status == 1 || transfer_order.status == 3">{{ item.approved_quantity }}</td>
                                <td v-if="transfer_order.status == 3">{{ item.transfer_quantity }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">&nbsp;</p>
                </div>
                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width:40%">Requested By:</th>
                                <td>{{ transfer_order.creator | FullName }} <br />{{ transfer_order.created_at | excelDate }}</td>
                            </tr>
                            <tr>
                                <th>Approved By:</th>
                                <td>{{ transfer_order.approver | FullName }} <br />{{ transfer_order.approved_at | excelDate }}</td>
                            </tr>
                            <tr>
                                <th>Issued By:</th>
                                <td>{{ transfer_order.issuer | FullName }} <br />{{ transfer_order.transferred_at | excelDate }}</td>
                            </tr>
                        </table>
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
            if (!found) this.TransferData.items.push({ id: item.id, name: item.name, quantity: 1});
            else{
                const index = this.TransferData.items.findIndex(object => {
                    return object.id === item.id;
                });

                this.TransferData.items[index].quantity++; 
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
    props:{
        transfer_order: Object,
    }
}
</script>