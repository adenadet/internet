<template>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="callout callout-info no-print">
                    <h5><i class="fas fa-info"></i> Note:</h5>
                    This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
                </div>
                <div class="invoice p-3 mb-3">
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <img class="img-fluid" width="50px" height="auto" src="/dist/img/snh_logo.png" /> St. Nicholas Hospital
                                <small class="float-right">Date: {{payment.created_at | excelDate}}</small>
                            </h4>
                        </div>
                    </div>
                    <div class="row invoice-info">
                        <div class="col-sm-3 invoice-col">
                            To
                            <address v-if="payment.patient != null">
                                <strong>{{payment.patient != null ? payment.patient.first_name+' '+payment.patient.last_name: ''}}</strong><br />
                                {{payment.patient != null ? payment.patient.street+', '+payment.patient.street2: ''}}<br/>
                                {{payment.patient != null ? payment.patient.city+', '+payment.patient.state.name: ''}}<br>
                                Phone: {{payment.patient != null ? payment.patient.phone: ''}}<br/>
                                Email: {{payment.patient != null ? payment.patient.email: ''}}
                            </address>
                        </div>
                        <div class="col-sm-3 invoice-col">
                            From
                            <address>
                                <strong>St. Nicholas Hospital</strong><br>
                                57, Campbell Street,<br>
                                Lagos Island, Lagos, Nigeria<br>
                                Phone: (555) 539-1037<br>
                                Email: info@saintnicholashospital.com
                            </address>
                        </div>
                        <div class="col-sm-3 invoice-col">
                            <b>Invoice #007612</b><br>
                            <br>
                            <b>Order ID:</b> 4F3S8J<br>
                            <b>Payment Status:</b> Paid<br>
                            <b>Payment Date:</b> {{payment.created_at | excelDate}}<br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Qty</th>
                                        <th>Product</th>
                                        <th>Serial #</th>
                                        <th>Description</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>{{payment.service != null ? payment.service.name : 'Service Not Defined'}}</td>
                                        <td>455-981-221</td>
                                        <td>El snort testosterone trophy driving gloves handsome</td>
                                        <td>&#x20A6; {{payment.service != null ? payment.service.price : '0.00' | currency}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <!--<p class="lead">Payment Methods:</p>
                            <img src="/dist/img/credit/visa.png" alt="Visa">
                            <img src="/dist/img/credit/mastercard.png" alt="Mastercard">
                            <img src="/dist/img/credit/american-express.png" alt="American Express">
                            <img src="/dist/img/credit/paypal2.png" alt="Paypal">-->
                        </div>
                        <div class="col-6">
                            <p class="lead"></p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr><th style="width:50%">Subtotal:</th><td>&#x20A6; {{payment.service != null ? payment.service.price : '0.00' | currency}}</td></tr>
                                    <tr><th>Tax (0.0%)</th><td>&#x20A6; {{0 | currency}}</td></tr>
                                    <tr><th>Total:</th><td>&#x20A6; {{payment.service != null ? payment.service.price : '0.00' | currency}}</td></tr>
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
    </div>
</section>  
</template>
<script>
export default {
    data(){
        return {
            payment: {},
        }
    },
    methods:{
        getAllInitials(){
            axios.get('/api/emr/payments/'+this.$route.params.id).then(response =>{
                this.payment = response.data.payment;
                toast.fire({icon: 'success',title: 'Payment loaded successfully',});
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Payment not loaded successfully',
                })
            });
        },
        makePayment(payment){
            this.$Progress.start();
            this.paySpecific = true;
            Fire.$emit('PaymentDataFill', this.payment);
            $('#paymentModal').modal('show');
            this.$Progress.finish();
        },
    },
    mounted() {
        this.getAllInitials();
    },
} 
</script>