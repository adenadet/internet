<template>
    <section class="content-header">
            <div class="modal fade" id="appointmentModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-show="editMode">Edit Appointment</h4>
                            <h4 class="modal-title" v-show="!editMode">New Appointment</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <EServiceFormAppointment :editMode="editMode" :appointment="appointment" :patients="patients" :services="services"/>
                        </div>
                    </div>
                </div>
            </div>
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
            <div class="modal fade" id="applicantModal">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Create Patient</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <EServiceFormPatient :editMode="editMode" :nations="nations" :applicant="applicant" /> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="receiptModal">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Appointment Receipt</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModals()"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <EServicePayment :appointment="appointment" /> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <EServiceFormSearch />
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Appointments</h3>
                            <div class="card-tools">
                                <button class="btn btn-sm btn-success" @click="addApplicant"><i class="fa fa-user-plus"></i> Create Applicant</button>
                                <button class="btn btn-sm btn-primary" @click="addAppointment"><i class="fa fa-calendar-plus"></i> Book Appointment</button>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Service</th>
                                        <th>Applicant</th>
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
                                        <td>{{appointment.patient_id != null && appointment.patient != null ? appointment.patient.first_name+' '+appointment.patient.middle_name+' '+appointment.patient.last_name:'Deleted User'}}</td>
                                        <td>{{appointment.date | excelDate}}</td>
                                        <td>{{appointment.schedule}}</td>
                                        <td><span class="tag tag-success">{{appointment.status == 0 ? 'Unpaid' :(appointment.status == 1 ? 'Paid' :(appointment.status == 2 ? 'Reschedule' :(appointment.status == 3 ? 'Cancelled' : (appointment.status == 8 ? 'Certificate Sent' :'Done'))))}}</span></td>
                                        <td>
                                            <button class="nav-link btn btn-sm btn-default" data-toggle="dropdown" type="button">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                                <router-link :to="'/eservices/front_admin/appointment/'+appointment.id"><button class="dropdown-item btn btn-block btn-sm"><i class="fa fa-eye mr-1 text-primary"></i> View Appointment</button></router-link>
                                                <button v-show="appointment.status == 0" class="dropdown-item btn btn-block btn-sm" @click="makePayment(appointment)"><i class="fa fa-credit-card mr-1 text-success"></i> Make Payment</button>
                                                <button v-show="appointment.status == 1" class="dropdown-item btn btn-block btn-sm" @click="viewPayment(appointment)"><i class="fa fa-file-pdf mr-1 text-success"></i> View Receipt</button>
                                                <button v-show="appointment.status <= 1 || appointment.status == null" class="dropdown-item btn btn-default btn-sm" @click="rescheduleAppointment(appointment)"><i class="fa fa-calendar mr-1"></i> Reschedule Appointment</button>
                                                <button v-show="appointment.status == 1" class="dropdown-item btn btn-block btn-sm" @click="resendAppointment(appointment.id)"><i class="fa fa-envelope mr-1 text-warning"></i> Resend Confirmation</button>
                                                <button v-show="appointment.status == 0" class="dropdown-item btn btn-block btn-sm" @click="deleteAppointment(appointment.id)"><i class="fa fa-trash mr-1 text-danger"></i> Delete Appointment</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <pagination :data="appointments" @pagination-change-page="getAppointment">
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
            applicant: {},
            appointment: {},
            appointments: {},
            editMode: true,
            form: new Form({}),
            nations: [],
            patients: [],
            services: [],
            user: {},
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('refreshAppointment', response => {
            this.refreshAppointments(response);
            this.closeModals();
        });
        Fire.$on('refresh', response => {
            this.refreshAppointments(response);
            this.closeModals();
        });
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
        addAppointment(){
            this.$Progress.start();
            this.editMode = false;
            this.appointment = {};
            Fire.$emit('AppointmentDataFill', {});
            $('#appointmentModal').modal('show');
            this.$Progress.finish();
        },
        deleteAppointment(id){
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
                //Send Delete request
                if(result.value){
                    this.form.delete('/api/emr/appointments/'+id)
                    .then(response=>{
                    Swal.fire('Deleted!', 'Appointment has been deleted.', 'success');
                    this.refreshAppointments(response);   
                    })
                    .catch(()=>{
                    Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });
        },
        closeModals(){
            $('#appointmentModal').modal('hide');
            $('#patientModal').modal('hide');
            $('#applicantModal').modal('hide');
            $('#receiptModal').modal('hide');
        },
        getInitials(page = 1) {
            axios.get('/api/emr/appointments?page='+page)
            .then(response => {this.refreshAppointments(response)})
            .catch(() => {
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Your appointments did not loaded successfully',})
            });
        },
        getAppointment(page=1){
            axios.get('/api/emr/appointments?page='+page)
            .then(response=>{
                this.appointments = response.data.appointments;   
            });
        },
        makePayment(appointment){
            this.$Progress.start();
            this.paySpecific = true;
            Fire.$emit('PaymentDataFill', appointment);
            $('#paymentModal').modal('show');
            this.$Progress.finish();
        },
        refreshAppointments(response) {
            this.appointments = response.data.appointments;
            this.services = response.data.services;
            this.nations = response.data.nations;
            this.patients = response.data.patients;
        },
        rescheduleAppointment(appointment) {
            this.$Progress.start();
            this.editMode = true;
            this.appointment = appointment;
            Fire.$emit('AppointmentDataFill', this.appointment);
            $('#appointmentModal').modal('show');
            this.$Progress.finish();
        },
        resendAppointment(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "The candidate would get a mail with the confirmation letter",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, resend confirmation!'
                })
            .then((result) => {
                //Send Delete request
                if(result.value){
                    this.form.get('/api/emr/registrations/resend/'+id)
                    .then(response=>{
                        //if (response.data.status == 'error')
                        Swal.fire(response.data.status, response.data.message, response.data.status);
                        //this.refreshAppointments(response);   
                    })
                    .catch(()=>{
                    Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });
        },
        viewPayment(appointment){
            this.appointment = appointment;
            $('#receiptModal').modal('show');
            this.$Progress.finish();
        },
    },
    props: {}
}
</script>