<template>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <EServiceFormSearch search_type="consultations" />
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Consultations</h3>
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
                                        <td>{{consultation.patient_id != null && consultation.patient != null ? consultation.patient.first_name+' '+consultation.patient.middle_name+' '+consultation.patient.last_name:'Deleted User'}}</td>
                                        <td>{{consultation.date | excelDate}}</td>
                                        <td>{{consultation.schedule}}</td>
                                        <td><span class="tag tag-success">{{consultation.status == 0 ? 'Unpaid' :(consultation.status == 1 ? 'Paid' :(consultation.status == 2 ? 'Reschedule' :(consultation.status == 3 ? 'Cancelled' : (consultation.status == 8 ? 'Certificate Sent' :'Done'))))}}</span></td>
                                        <td>
                                            <div class="btn btn-group">
                                                <router-link :to="'/eservices/doctor/consultation/'+consultation.id"><button class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></button></router-link>
                                                <a v-if="consultation.status == 4" :href="'/eservices/doctor/consent/'+consultation.id"><button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>
                                            </div> 
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <pagination :data="consultations" @pagination-change-page="getAppointment">
                                <span slot="prev-nav">&lt; Previous </span>
                                <span slot="next-nav">Next &gt;</span>
                            </pagination>
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
        Fire.$on('refreshAppointment', response => {
            this.refreshConsultations(response);
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
        getAppointment(page=1){
            axios.get('/api/emr/consultations/?page='+page)
            .then(response=>{
                this.refreshConsultations(response);   
            });
        },
        getInitials() {
            axios.get('/api/emr/consultations')
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