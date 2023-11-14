<template>
<section>
    <div class="row">
        <div class="col-md-12">
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> St. Nicholas Hospital
                    <small class="float-right">Date: {{ appointment.payment.date }}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>{{ appointment.patient.first_name }} {{ appointment.patient.last_name }}</strong><br>
                    Phone: {{ appointment.patient.phone }}<br>
                    Email: {{ appointment.patient.email }}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong>St. Nicholas Hospital</strong><br>
                    57, Campbell Street,<br>
                    Lagos Island, Lagos, Nigeria<br>
                    Phone: (555) 539-1037<br>
                    Email: info@saintnicholashospital.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Invoice #007612</b><br>
                  <br>
                  <b>Service:</b> {{ appointment.service.name }}<br />
                  <b>Tack ID:</b> <br>
                  <b>Payment Due:</b> 2/22/2014<br>
                  <b>Account:</b> 968-34567
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Qty</th>
                            <th>Service</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Payment for {{ appointment.service.name }} for  {{ appointment.patient.first_name }} {{ appointment.patient.last_name }}</td>
                            <td>{{ appointment.payment.amount | currency}}</td>
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.row -->

              <div class="row">
                <div class="col-6">
                    <p class="lead">Payment Details:</p>
                    
                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                        {{ appointment.payment.channel }} <br />
                        {{ appointment.payment.details }}
                    </p>
                </div>
                <div class="col-6">
                    <p class="lead">Payment Date {{ appointment.payment.created_at | excelDate }}</p>
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
            user: {},
        }
    },
    mounted() {
        Fire.$on('refreshPayment', response => {
            this.refreshAppointments(response);
            this.closeModals();
        });
    },
    methods: {
        addApplicant(){
            this.$Progress.start();
            this.editMode = false;
            //this.applicant = {};
            Fire.$emit('ApplicantDataFill', {});
            $('#applicantModal').modal('show');
            this.$Progress.finish();
        },
    },
    props: {appointment: Object}
}
</script>