<template>
<section class="content-header">
    <div class="container-fluid">
        <div class="modal fade" id="appointmentModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-show="editMode">Edit Appointment</h4>
                        <h4 class="modal-title" v-show="!editMode">New Appointment</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <ApplicantAppointmentForm :appointment="appointment" :services="services"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card col-12">
                    <div class="card-header">
                        <h3 class="card-title">All Appointments</h3>
                        <div class="card-tools">
                            <button class="btn btn-sm btn-primary" @click="newAppointment"><i class="fa fa-calendar-plus"></i> Book
                                Appointment</button>
                        </div>
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
            </div>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data() {
        return {
            appointment: {},
            appointments: {},
            services: [],
            editMode: true,
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('refreshAppointment', response => {
            this.refreshAppointments(response);
        });
    },
    methods: {
        getInitials() {
            axios.get('/api/emr/appointments/initials').then(response => {
                Fire.$emit('refreshAppointment', response);
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
        refreshAppointments(response) {
            this.appointments = response.data.appointments;
            this.services = response.data.services;
        }
    },
    props: {}
}
</script>