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
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Appointment Detail</h3>
        <div class="card-tools">
            <button v-if="appointment.status == 0" type="button" class="btn btn-sm btn-success" title="Make Payment" @click="makePayment(appointment)"><i class="fas fa-credit-card"></i></button>
            <button v-else-if="appointment.status == 1"  type="button" class="btn btn-sm btn-primary" title="Process"><i class="fas fa-check"></i></button>
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
                                <span class="info-box-number text-center text-muted mb-0">{{appointment.status == 0 ? 'Unpaid' : (appointment == 9 ? 'Cancelled' : 'Paid')}}</span>
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
                        <div class="post" v-if="appointment.radiologist != null && apointment.radiologist_id != null">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" :src="appointment.radiologist != null ? '/img/profile/'+appointment.radiologist.image : '/img/profile/default.png'" alt="user image">
                                <span class="username"><a href="#">{{appointment.radiologist != null ? appointment.radiologist.first_name+' '+appointment.radiologist.last_name : 'Radiologist Undefined'}}</a>
                                </span>
                                <span class="description">Posted: {{appointment.radiologist_at | excelDate}}</span>
                            </div>
                            <p>{{appointment.radiologist_remark}}</p>
                        </div>

                        <div class="post clearfix" v-if="appointment.medical_officer != null && appointment.doctor_id != null">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" :src="appointment.medical_officer != null && appointment.medical_officer.image != null ? '/img/profile/'+appointment.medical_officer.image : '/img/profile/default.png'" alt="user image">
                                <span class="username"><a href="#">{{appointment.medical_officer != null ? appointment.medical_officer.first_name+' '+appointment.medical_officer.last_name : 'Radiologist Undefined'}}</a>
                                </span>
                                <span class="description">Posted: {{appointment.medical_officer_at | excelDate}}</span>
                            </div>
                            <p>{{appointment.medical_officer_remark}}</p>
                        </div>

                        <div class="post clearfix" v-if="appointment.front_office != null && apointment.front_office_id != null">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" :src="appointment.front_office != null ? '/img/profile/'+appointment.front_office.image : '/img/profile/default.png'" alt="user image">
                                <span class="username"><a href="#">{{appointment.front_office != null ? appointment.front_office.first_name+' '+appointment.front_office.last_name : 'Radiologist Undefined'}}</a>
                                </span>
                                <span class="description">Posted: {{appointment.arrived_at | excelDate}}</span>
                            </div>
                            <p>{{appointment.front_office_remark}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1" v-else>
                <img class="img-fluid" src="/img/loading/1.gif"/>
            </div>
            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2" v-if="appointment.patient != null">
                <h4 class="text-primary"><i class="fas fa-user"></i> {{appointment.patient.first_name+' '+appointment.patient.other_name+' '+appointment.patient.last_name}}</h4>
                <div class="text-muted">
                    <p class="text-sm">Sex | Age: <b class="d-block">{{appointment.patient.sex}} | {{appointment.patient.dob | age}} years</b></p>
                    <p class="text-sm">Registered at: <b class="d-block">{{appointment.patient.created_at | excelDate}}</b></p>
                    <p class="text-sm">Nationality: <b class="d-block">{{appointment.patient.nationality != null && appointment.patient.nationality_id != null ? appointment.patient.nationality.name : 'None Given'}}</b></p>
                    <p class="text-sm">Passport: <b class="d-block">{{appointment.patient.passport_no != null ? appointment.patient.passport_no :'Request Passport' }}</b>
                    </p>
                </div>

                <h5 class="mt-5 text-muted">Project files</h5>
                <ul class="list-unstyled">
                    <li>
                    <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-word"></i> Functional-requirements.docx</a>
                    </li>
                    <li>
                    <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i> UAT.pdf</a>
                    </li>
                    <li>
                    <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-envelope"></i> Email-from-flatbal.mln</a>
                    </li>
                    <li>
                    <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-image "></i> Logo.png</a>
                    </li>
                    <li>
                    <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-word"></i> Contract-10_12_2014.docx</a>
                    </li>
                </ul>
                <div class="text-center mt-5 mb-3">
                    <a href="#" class="btn btn-sm btn-primary">Add files</a>
                    <a href="#" class="btn btn-sm btn-warning">Report contact</a>
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
            editMode: true,
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
        addAppointment(){
            this.$Progress.start();
            this.editMode = false;
            this.appointment = {};
            Fire.$emit('AppointmentDataFill', {});
            $('#appointmentModal').modal('show');
            this.$Progress.finish();
        },
        getInitials() {
            axios.get('/api/emr/appointments/'+this.$route.params.id)
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
        },
    },
}
</script>