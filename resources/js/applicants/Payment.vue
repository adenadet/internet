<template>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="callout callout-info">
                    <h5><i class="fas fa-info"></i> Note:</h5>
                    This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
                </div>
                <div class="invoice p-3 mb-3">
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <i class="fas fa-globe"></i> St. Nicholas Hospital
                                <small class="float-right">Date: {{payment.date}}</small>
                            </h4>
                        </div>
                    </div>
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            To
                            <address v-if="payment.patient != null">
                                <strong>{{payment.patient != null ? payment.patient.first_name+' '+payment.patient.last_name: ''}}</strong><br />
                                {{payment.patient != null ? payment.patient.street+', '+payment.patient.street2: ''}}<br/>
                                {{payment.patient != null ? payment.patient.city+', '+payment.patient.state_id: ''}}<br>
                                San Francisco, CA 94107<br/>
                                Phone: {{payment.patient != null ? payment.patient.phone: ''}}<br/>
                                Email: {{payment.patient != null ? payment.patient.email: ''}}
                            </address>
                        </div>
                        <div class="col-sm-4 invoice-col">
                            From
                            <address>
                                <strong>St. Nicholas Hospital</strong><br>
                                57, Campbell Street,<br>
                                Lagos Island, Lagos, Nigeria<br>
                                Phone: (555) 539-1037<br>
                                Email: info@saintnicholashospital.com
                            </address>
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <b>Invoice #007612</b><br>
                            <br>
                            <b>Order ID:</b> 4F3S8J<br>
                            <b>Payment Date:</b> {{payment.date}}<br>
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
                                        <td>&#x20A6; {{payment.service != null ? payment.service.amount | currency : '0.00'}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p class="lead">Payment Methods:</p>
                            <img src="/dist/img/credit/visa.png" alt="Visa">
                            <img src="/dist/img/credit/mastercard.png" alt="Mastercard">
                            <img src="/dist/img/credit/american-express.png" alt="American Express">
                            <img src="/dist/img/credit/paypal2.png" alt="Paypal">

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
                                    <tr><th style="width:50%">Subtotal:</th><td>$250.30</td></tr>
                                    <tr><th>Tax (9.3%)</th><td>$10.34</td></tr>
                                    <tr><th>Shipping:</th><td>$5.80</td></tr>
                                    <tr><th>Total:</th><td>$265.24</td></tr>
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
            Fire.$emit('PaymentDataFill', payment);
            $('#paymentModal').modal('show');
            this.$Progress.finish();
        },
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('preliminaryAdd', message =>{
            this.messages.push(message);
        }); 
    },
} 
</script>