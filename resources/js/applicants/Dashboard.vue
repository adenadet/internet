<template>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-12">
                <div class="small-box bg-info">
                    <div class="inner"><h3>{{appointments.total}}</h3><p>Upcoming Appointments</p></div>
                    <div class="icon"><i class="fa fa-calendar-day"></i></div>
                    <a href="/applicants/appointments" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="small-box bg-success">
                    <div class="inner"><h3>{{tickets.total}}</h3><p>Tickets</p></div>
                    <div class="icon"><i class="fa fa-tags"></i></div>
                    <a href="/applicants/tickets" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="small-box bg-warning">
                    <div class="inner"><h3>{{wallet.balance | currency}}</h3><p>Wallet Balance</p></div>
                    <div class="icon"><i class="fa fa-wallet"></i></div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <section class="col-lg-7 connectedSortable">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-calendar-week mr-1"></i>
                            Appointments
                        </h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Service</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody v-if="appointments.data == null || appointments == null">
                                <tr>
                                    <td colspan="6" class="text-center">You have not made any appointments yet</td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(appointment, index) in appointments.data" :key="appointment.id">
                                    <td>{{index | addOne}}</td>
                                    <td>{{appointment.service_id != null && appointment.service != null ? appointment.service.name : ''}}</td>
                                    <td>{{appointment.date | excelDate}}</td>
                                    <td>{{appointment.schedule}}</td>
                                    <td><span class="tag tag-success">{{appointment.status == 0 ? 'Unpaid' :(appointment.status == 1 ? 'Paid' :(appointment.status == 2 ? 'Reschedule' :(appointment.status == 3 ? 'Cancelled' : (appointment.status == 8 ? 'Certificate Sent' :'Done'))))}}</span></td>
                                    <td>
                                        <div class="btn btn-group">
                                            <router-link :to="'/applicants/appointment/'+appointment.id"><button class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></button></router-link>
                                            <button class="btn btn-success btn-sm"><i class="fa fa-file-pdf"></i></button>
                                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                        </div> 
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <section class="col-lg-5 connectedSortable">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-calendar-week mr-1"></i>
                            Payments
                        </h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead><tr><th></th><th>Service</th><th>Date</th><th>Time</th><th>Status</th><th></th></tr></thead>
                            <tbody>
                                <tr v-if="payments.data == null || payments == null">
                                    <td colspan="6" class="text-center">You have not made any payments yet</td>
                                </tr>
                                <tr v-for="(payment, index) in payments.data" :key="payment.id">
                                    <td>{{index | addOne}}</td>
                                    <td>{{payment.service.name}}</td>
                                    <td>{{payment.date | excelDate}}</td>
                                    <td></td>
                                    <td><span class="tag tag-success">Approved</span></td>
                                    <td><router-link class="btn btn-success btn-sm" :to="'/applicants/payment/'+payment.id"><i class="fa fa-eye"></i></router-link></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data() {
        return {
            wallet: {},
            appointment: {},
            appointments: {},
            payments: {},
            services: [],
            editMode: true,
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('refreshDashboard', response => {
            this.refreshDashboard(response);
        });
    },
    methods: {
        getInitials() {
            axios.get('/api/dashboard/applicant').then(response => {
                Fire.$emit('refreshDashboard', response);
            })
                .catch(() => {
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Your appointments did not loaded successfully',
                    })
                });
        },
        newAppointment(){
            this.$Progress.start();
            this.editMode = false;
            this.appointment = {};
            Fire.$emit('AppointmentDataFill', {});
            $('#appointmentModal').modal('show');
            this.$Progress.finish();
        },
        refreshDashboard(response) {
            this.appointments = response.data.appointments;
            this.payments = response.data.payments;
            this.services = response.data.services;
            this.tickets = response.data.tickets;
            this.wallet = response.data.wallet;
        }
    },
    props: {}
}
</script>