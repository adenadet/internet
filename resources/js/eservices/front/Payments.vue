<template>
    <section class="content-header">
        <div class="container-fluid">
            <div class="modal fade" id="paymentModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Make Payment</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <EServiceFormPayment />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Payments</h3>
                            <div class="card-tools">
                                <button class="btn btn-sm btn-primary" @click="addPayment"><i class="fa fa-calendar-plus"></i> Make Payment</button>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Applicant</th>
                                        <th>Service </th>
                                        <th>Amount</th>
                                        <th>Channel</th>
                                        <th>By</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody v-if="payments.data == null || payments == null || payments.data.length == 0">
                                    <tr>
                                        <td colspan="6" class="text-center">You have not made any payments yet</td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr v-for="payment in payments.data" :key="payment.id">
                                        <td>{{payment.created_at | excelDateShort}}</td>
                                        <td>{{payment.patient_id != null && payment.patient != null ? payment.patient.first_name+' '+payment.patient.other_name+' '+payment.patient.last_name:'Deleted User'}}</td>
                                        <td>{{payment.service_id != null && payment.service != null ? payment.service.name : ''}}</td>
                                        <td>{{payment.amount | currency}}</td>
                                        <td>{{payment.channel}} <br /><small>{{payment.details}}</small></td>
                                        <td><span class="tag tag-success">{{payment.employee_id != null && payment.employee != null ? payment.employee.first_name+' '+payment.employee.last_name:'Old Staff'}}</span></td>
                                        <td>
                                            <!--<div class="btn btn-group">
                                                <router-link :to="'/eservices/front_office/payment/'+payment.id"><button class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></button></router-link>
                                                <button class="btn btn-success btn-sm"><i class="fa fa-file-pdf"></i></button>
                                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                            </div>--> 
                                        </td>
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
            payment: {},
            payments: {},
            unpaid_apppointments: {},
            editMode: true,
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('refreshPayment', response => {
            this.refreshPayments(response);
            $('#paymentModal').modal('hide');
        });
    },
    methods: {
        addPayment(){
            this.$Progress.start();
            this.paySpecific = false;
            //this.unpaid_appointments;
            Fire.$emit('UnpaidAppointments', this.unpaid_apppointments);
            $('#paymentModal').modal('show');
            this.$Progress.finish();
        },
        getInitials() {
            axios.get('/api/emr/payments').then(response => {
                //this.refreshPayments(response)
                Fire.$emit('refreshPayment', response);
            })
                .catch(() => {
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Your payments did not loaded successfully',
                    })
                });
        },
        refreshPayments(response) {
            this.payments = response.data.payments;
            this.unpaid_apppointments = response.data.unpaid_appointments;
        }
    },
    props: {}
}
</script>