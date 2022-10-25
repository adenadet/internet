<template>
    <section class="content-header">
        <div class="container-fluid">
            <div class="modal fade" id="consultationModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-show="editMode">Edit Consultation</h4>
                            <h4 class="modal-title" v-show="!editMode">New Consultation</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <!-- :consultation="consultation" / -->
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
                            <ApplicantFormPatient :nations="nations" :editMode="editMode" :applicant="applicant" /> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Consultations</h3>
                            <div class="card-tools">
                                <button class="btn btn-sm btn-success" @click="addApplicant"><i class="fa fa-user-plus"></i> Create Applicant</button>
                                <button class="btn btn-sm btn-primary" @click="addConsultation"><i class="fa fa-calendar-plus"></i> Book Consultation</button>
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
                                <tbody v-if="consultations.data == null || consultations == null">
                                    <tr>
                                        <td colspan="6" class="text-center">You have not made any consultations yet</td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr v-for="(consultation, index) in consultations.data" :key="consultation.id">
                                        <td>{{index | addOne}}</td>
                                        <td>{{consultation.service_id != null && consultation.service != null ? consultation.service.name : ''}}</td>
                                        <td>{{consultation.patient_id != null && consultation.patient != null ? consultation.patient.first_name+' '+consultation.patient.other_name+' '+consultation.patient.last_name:'Deleted User'}}</td>
                                        <td>{{consultation.date | excelDate}}</td>
                                        <td>{{consultation.schedule}}</td>
                                        <td><span class="tag tag-success">{{consultation.status == 0 ? 'Unpaid' :(consultation.status == 1 ? 'Paid' :(consultation.status == 2 ? 'Reschedule' :(consultation.status == 3 ? 'Cancelled' : (consultation.status == 8 ? 'Certificate Sent' :'Done'))))}}</span></td>
                                        <td>
                                            <div class="btn btn-group">
                                                <router-link :to="'/eservices/doctor/consultation/'+consultation.id"><button class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></button></router-link>
                                                <button v-show="consultation.status == 0" class="btn btn-success btn-sm" @click="makePayment(consultation)"><i class="fa fa-credit-card"></i></button>
                                                <button v-show="consultation.status == 1" class="btn btn-success btn-sm"><i class="fa fa-file-pdf"></i></button>
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
            applicant: {},
            consultation: {},
            consultations: {},
            editMode: true,
            nations: [],
            user: {},
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('refreshConsultation', response => {
            this.refreshConsultations(response);
        });
        Fire.$on('refreshPayment', response => {
            this.refreshConsultations(response);
            $('#paymentModal').modal('hide');
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
        addConsultation(){
            this.$Progress.start();
            this.editMode = false;
            this.consultation = {};
            Fire.$emit('ConsultationDataFill', {});
            $('#consultationModal').modal('show');
            this.$Progress.finish();
        },
        getInitials() {
            axios.get('/api/emr/appointments')
            .then(response => {
                this.refreshConsultations(response)
                //Fire.$emit('refreshConsultation', response);
            })
            .catch(() => {
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Your consultations did not loaded successfully',
                })
            });
        },
        makePayment(consultation){
            this.$Progress.start();
            this.paySpecific = true;
            Fire.$emit('PaymentDataFill', consultation);
            $('#paymentModal').modal('show');
            this.$Progress.finish();
        },
        refreshConsultations(response) {
            this.consultations = response.data.appointments;
            this.nations = response.data.nations;
        }
    },
    props: {}
}
</script>