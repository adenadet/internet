<template>
<section class="container-fluid">
    <div class="row">
          <div class="col-12">
            <div class="callout callout-info">
              <h5><i class="fas fa-info"></i> Note:</h5>
              This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
            </div>


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> AdminLTE, Inc.
                    <small class="float-right">Date: 2/10/2014</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        From
                        <address>
                            <strong>{{ transfer_order.creator | FullName }}</strong><br>
                            {{ transfer_order.creator.department.name }}<br>
                            Store: {{ transfer_order.to_store.name }}<br>
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        Approved By
                        <address v-if="transfer_order.approver != null">
                            <strong >{{ transfer_order.approver | FullName }}</strong><br />
                            {{ transfer_order.approver.department.name }}<br>
                            Store: {{ transfer_order.from_store.name }}<br>
                        </address>
                        <address v-else>
                            <span class="text-warning">Awaiting Approval</span><br>
                            Store: {{ transfer_order.from_store.name }}<br>
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <b>Request ID: {{ transfer_order.unique_id }}</b><br>
                        <br>
                        <address v-if="transfer_order.fulfiller != null">
                            Fulfilled By:
                            <strong >{{ transfer_order.fulfiller | FullName }}</strong><br />
                            {{ transfer_order.fulfilled_at | excelDate }}<br>
                            Fulfillment ID: {{ transfer_order.fulfillment.unique_id }}<br>
                        </address>
                        <address v-else>
                            Not Yet Fulfilled
                        </address>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Qty</th>
                                    <th>Item</th>
                                    <th>Item Unique ID</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="transfer_order_item in transfer_order_items" :key="transfer_order_item.id">
                                    <td>{{ transfer_order_item.quantity }}</td>
                                    <td>{{ transfer_order_item.item.name }}</td>
                                    <td>{{ transfer_order_item.item_unique_id }}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p class="lead">Payment Methods:</p>
                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                            plugg
                            dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                        </p>
                    </div>
                    <div class="col-6">
                        <p class="lead">Amount Due 2/22/2014</p>

                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">Subtotal:</th>
                                    <td>$250.30</td>
                                </tr>
                                <tr>
                                    <th>Tax (9.3%)</th>
                                    <td>$10.34</td>
                                </tr>
                                <tr>
                                    <th>Shipping:</th>
                                    <td>$5.80</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td>$265.24</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row no-print">
                    <div class="col-12">
                        <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                        <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                            Payment
                        </button>
                        <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                            <i class="fas fa-download"></i> Generate PDF
                        </button>
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
            transfer_order: {},
            transfer_order_items: [],
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('ItemDataFill', item =>{
            this.ItemData.fill(item);
        });
    },
    methods:{
        createItem(){
            this.$Progress.start();
            this.ItemData.post('/api/inventory/transfer_orders/'+this.$route.params.id)
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
            axios.get('/api/inventory/transfer_orders?page='+page)
            .then(response =>{
                this.refreshPage(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Transfer Orders loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Transfer Orders not loaded successfully',
                })
            });
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
    props:{
        editMode: Boolean,
    }
}
</script>