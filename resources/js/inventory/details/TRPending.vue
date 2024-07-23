<template>
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ list_type }} Requests</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Requesting Store</th>
                                    <th>Issuing Store</th>
                                    <th>Status</th>
                                    <th>Requesting Approval</th>
                                    <th>Issuing Approval</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(request, index) in transfer_requests.data" :key="request.id">
                                    <td>{{ index |addOne }}</td>
                                    <td>{{ request.requesting_store != null ? request.requesting_store.name : 'Old Store' }}</td>
                                    <td>{{ request.issuing_store != null ? request.issuing_store.name : 'Old Store' }}</td>
                                    <td>{{ request.status == 0 ? 'Draft' : (request.status == 1 ? 'Unapproved' :(request.status == 2 ? 'Unconfirmed' : (request.status == 3 ? 'Confirmed' :(request.status == 4 ? 'Issued' :'Cancelled / Invalid Status'))))  }}</td>
                                    <td>{{ request.requesting_store != null ? request.requesting_store.name : 'Old Store' }}</td>
                                    <td>{{ request.requesting_store != null ? request.requesting_store.name : 'Old Store' }}</td>
                                    <td></td>
                                </tr> 
                            </tbody>
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
        list_type: String,
        transfer_order: Object,
    }
}
</script>