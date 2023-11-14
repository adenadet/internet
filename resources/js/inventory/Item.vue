<template>
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Item Details</h3>
                    </div>
                    <div class="card-body">
                        Put the details of the Item Here
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                Name <span class="float-right badge">{{ item.name }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                Item Type <span class="float-right badge bg-info">{{ item.item_type != null ? item.item_type.name : 'N/A' }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                Category <span class="float-right badge bg-success">{{ item.category != null ? item.category.name : 'N/A' }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                Quantity <span class="float-right badge bg-danger">{{ item.quantity }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                Minimum Reorder Level <span class="float-right badge bg-danger">{{ item.minimum_level }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                Current Cost Price <span class="float-right badge bg-danger">{{ item.current_cost_price | currency }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                Status <span class="float-right badge bg-danger">{{ item.status == 1 ? 'Active' : 'Inactive' }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Recent Movements</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Identification</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="transfer_order in transfer_orders" :key="transfer_order.id">
                                        <td>{{ transfer_order.created_at | excelShortDate }}</td>
                                        <td>{{ transfer_order.unique_id }}</td>
                                        <td>{{ transfer_order.from_store.name }}</td>
                                        <td>{{ transfer_order.to_store.name }}</td>
                                        <td>{{ transfer_order.quantity }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Store Levels</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Store Name</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="location in locations" :key="location.id">
                                        <td>{{ location.store.name }}</td>
                                        <td>{{ location.quantity }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>All Procurements Orders</h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="purchase_order in purchase_orders.data" :key="purchase_order.id">
                                        <td>{{ purchase_order.name }}</td>
                                        <td>{{ purchase_order.type.name }}</td>
                                        <td>{{ purchase_order.category.name }}</td>
                                        <td>{{ purchase_order.quantity }}</td>
                                        <td>{{ purchase_order.minimum_level }}</td>
                                        <td>{{ purchase_order.current_cost_price | currency }}</td>
                                        <td>{{ purchase_order.status == 1 ? 'Active' : 'Inactive' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
    </div>
</section>
</template>
<script>
export default {
    data(){
        return  {
            editMode: false,
            item: {},
            items: {},
            purchase_orders: {},
            transfer_orders: {},
            locations: {},
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('ItemDataFill', item =>{
            this.ItemData.fill(item);
        });
    },
    methods:{
        getInitials(page=1){
            this.$Progress.start();
            axios.get('/api/inventory/items/'+this.$route.params.id)
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
            this.item = response.data.item;
            this.transfer_orders = response.data.transfer_orders;
            this.locations = response.data.locations;
            this.purchase_orders = response.data.purchase_orders;
        },
    },
}
</script>