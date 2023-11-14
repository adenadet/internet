<template>
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Transfer Requests</h3>
                        <div class="card-tools">
                            <button class="btn btn-primary btn-sm" @click="addRequest()">Add New</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-hover ">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Status</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="transfer_order in transfer_orders.data" :key="transfer_order.id">
                                            <td>{{ transfer_order.name }} <span class="text-muted">{{
                                                transfer_order.unique_id }}</span></td>
                                            <td>{{ transfer_order.from_store != null ? transfer_order.from_store.name :
                                                'Deactivated Store' }}</td>
                                            <td>{{ transfer_order.to_store != null ? transfer_order.to_store.name :
                                                'Deactivated Store' }}</td>
                                            <td>{{ transfer_order.status != 1 ? 'Inactive' : 'Active' }}</td>
                                            <td>
                                                <button type="button" class="btn btn-light" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false"><i
                                                        class="fas fa-ellipsis-v"></i></button>
                                                <div class="dropdown-menu">
                                                    <router-link class="btn btn-block dropdown-item"
                                                        :to="'./transfer_orders/' + transfer_order.id"><i
                                                            class="fa fa-eye mr-1"></i> View </router-link>
                                                    <button class="btn btn-block dropdown-item"
                                                        @click="updateTransferOrder(transfer_order)"><i
                                                            class="fa fa-edit mr-1 text-primary"></i> Edit </button>
                                                    <button class="btn btn-block dropdown-item"
                                                        @click="deleteTransferOrder(transfer_order.id)"><i
                                                            class="fa fa-trash mr-1 text-danger"></i> Deactivate</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <pagination :data="transfer_orders" @pagination-change-page="getInitials">
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
    data() {
        return {
            editMode: false,
            form: new Form({}),
            transfer_order: {},
            transfer_orders: {},
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('transferRequestReload', response => {
            this.refreshPage(response)
        });
    },
    methods: {
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
            axios.get('/api/inventory/transfer_orders?page=' + page)
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
        refreshPage(response) {
            this.stores = response.data.stores;
            this.closeModals();
        },
    },
}
</script>