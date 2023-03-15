<template>
<section class="content">
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
                <h4 class="modal-title" v-html="editMode ? 'Edit Patient' : 'Create Patient'"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <EServiceFormPatient :editMode="editMode" :nations="nations" :applicant="applicant" /> 
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="arrivalModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" v-html="'Confirm Arrival'"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <EServiceFormArrival /> 
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Appointment Detail</h3>
        <div class="card-tools">
            <button v-if="appointment.payment == null" type="button" class="btn btn-sm btn-success" title="Make Payment" @click="makePayment(appointment)"><i class="fas fa-credit-card"></i></button>
            <!--<button v-else-if="appointment.front_officer == null" @click="to_doctor(appointment)" type="button" class="btn btn-sm btn-primary" title="Process"><i class="fas fa-check"></i></button-->
            <button v-if="appointment.date == today" @click="to_doctor(appointment)" type="button" class="btn btn-sm btn-primary" title="Process"><i class="fas fa-check"></i></button>
            <button v-else @click="to_doctor(appointment)" type="button" class="btn btn-sm btn-primary" title="Process"><i class="fas fa-check"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1" v-if="appointment != null && appointment.service != null">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Estimated Cost</span>
                                <span class="info-box-number text-center text-muted mb-0">{{appointment.service.price}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light bg-primary">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Status</span>
                                <span class="info-box-number text-center text-muted mb-0">{{appointment.payment == null ? 'Unpaid' : (appointment == 9 ? 'Cancelled' : 'Paid')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Estimated duration</span>
                                <span class="info-box-number text-center text-muted mb-0">{{appointment.service.duration != null ? appointment.service.duration+' mins': 'Not Defined'}} </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h4>Recent Activity</h4>
                        <!--<div class="post" v-if="appointment.radiologist != null && appointment.radiologist_id != null">
                            <h6><b>Radiologist</b></h6>
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" :src="appointment.radiologist != null ? '/img/profile/'+appointment.radiologist.image : '/img/profile/default.png'" :title="appointment.radiologist.first_name+' '+appointment.radiologist.last_name">
                                <span class="username"><a href="#">{{appointment.radiologist != null ? appointment.radiologist.first_name+' '+appointment.radiologist.last_name : 'Radiologist Undefined'}}</a>
                                </span>
                                <span class="description">Posted: {{appointment.radiologist_at | excelDate}}</span>
                            </div>
                            <p>{{appointment.appointment.summary}}</p>
                            <p>{{appointment.radiologist_remark}}</p>
                        </div>-->

                        <div class="post clearfix" v-if="appointment.medical_officer != null && appointment.doctor_id != null">
                            <h6><b>Medical Officer</b></h6>
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" :src="appointment.medical_officer != null && appointment.medical_officer.image != null ? '/img/profile/'+appointment.medical_officer.image : '/img/profile/default.png'" alt="user image">
                                <span class="username"><a href="#">{{appointment.medical_officer != null ? appointment.medical_officer.first_name+' '+appointment.medical_officer.last_name : 'Radiologist Undefined'}}</a>
                                </span>
                                <span class="description">Posted: {{appointment.medical_officer_at | excelDate}}</span>
                            </div>
                            <p>{{appointment.medical_officer_remark}}</p>
                        </div>

                        <div class="post clearfix" v-if="appointment.front_office_id != null">
                            <h6><b>Front Officer</b></h6>
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" :src="appointment.front_officer != null ? '/img/profile/'+appointment.front_officer.image : '/img/profile/default.png'" :title="appointment.front_officer != null ? appointment.front_officer.first_name+' '+appointment.front_officer.last_name : 'Undefined Officer'">
                                <span class="username"><a href="#">{{appointment.front_officer != null ? appointment.front_officer.first_name+' '+appointment.front_officer.last_name : 'Undefined Officer'}}</a>
                                </span>
                                <span class="description">Posted: {{appointment.arrived_at | excelDate}}</span>
                            </div>
                            <p v-html="appointment.front_office_remark"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1" v-else>
                <img class="img-fluid" src="/img/loading/1.gif"/>
            </div>
            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2 card">
                <div class="card-header">
                    <h6 class="card-title"><i class="fas fa-user"></i> Applicant Detail</h6>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-primary" title="Edit Details" @click="editApplicant(appointment.patient)"><i class="fas fa-edit"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-muted">
                        <img :src="(appointment.patient != null && appointment.patient.image != null) ? '/img/applicants/'+appointment.patient.image : '/img/profile/default.png'" class="img-fluid" :title="appointment.patient.last_name+' '+appointment.patient.first_name+' '+appointment.patient.middle_name" />
                        <p class="text-sm">Surname | First Name Other Name: <b class="d-block">{{appointment.patient.last_name}} | {{appointment.patient.first_name}} {{appointment.patient.middle_name}}</b></p>
                        <p class="text-sm">Sex | Age: <b class="d-block">{{appointment.patient.sex}} | {{appointment.patient.dob | age}} years</b></p>
                        <p class="text-sm">Nationality: <b class="d-block">{{appointment.patient.nationality != null && appointment.patient.nationality_id != null ? appointment.patient.nationality.name : 'None Given'}}</b></p>
                        <p class="text-sm">Passport No. | Visa Type: <b class="d-block">{{appointment.patient.passport_no != null ? appointment.patient.passport_no :'Request Passport' }} | {{appointment.patient.visa_type != null ? appointment.patient.visa_type :'Request Visa Type' }}</b></p>
                        <p class="text-sm">Registered at: <b class="d-block">{{appointment.patient.created_at | excelDate}}</b></p>  
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
    data() {
        return {
            applicant: {},
            appointment: {},
            appointments: {},
            editMode: true,
            nations: [],
            report: {},
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('refreshAppointment', response => {
            this.refreshAppointment(response);
        });
        Fire.$on('refreshPayment', response => {
            this.refreshAppointment(response);
            $('#paymentModal').modal('hide');
        });
    },
    methods: {
        editApplicant(patient){
            this.$Progress.start();
            this.editMode = true;
            this.applicant = patient;
            Fire.$emit('ApplicantDataFill', patient);
            $('#applicantModal').modal('show');
            this.$Progress.finish();
        },
        getInitials() {
            axios.get('/api/emr/appointments/'+this.$route.params.id)
            .then(response => {
                Fire.$emit('refreshAppointment', response);
            })
            .catch(() => {
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Your appointments did not loaded successfully',})
            });
        },
        addPayment(){
            this.$Progress.start();
            this.paySpecific = false;
            //this.unpaid_appointments;
            Fire.$emit('PaymentDataFill', {});
            Fire.$emit('UnpaidAppointments', this.unpaid_apppointments);
            $('#paymentModal').modal('show');
            this.$Progress.finish();
        },
        makePayment(appointment){
            this.$Progress.start();
            this.paySpecific = true;
            Fire.$emit('PaymentDataFill', appointment);
            $('#paymentModal').modal('show');
            this.$Progress.finish();
        },
        refreshAppointment(response) {
            this.appointment = response.data.appointment;
            this.nations = response.data.nations;
            this.report = response.data.appointment.report;

            $('#applicantModal').modal('hide');
            $('#appointmentModal').modal('hide');
            $('#arrivalModal').modal('hide');
        },
        to_doctor(appointment){
            this.$Progress.start();
            //this.editMode = false;
            this.appointment = appointment;
            Fire.$emit('ArrivalDataFill', appointment);
            $('#arrivalModal').modal('show');
            this.$Progress.finish();
        },
        /*toDoctor(id){
            axios.get('/api/emr/appointments/to_doctor/'+this.$route.params.id)
            .then(response => {
                Fire.$emit('refreshAppointment', response);
            })
            .catch(() => {
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Your appointments did not loaded successfully',
                })
            });
        },*/
    },
}
</script>