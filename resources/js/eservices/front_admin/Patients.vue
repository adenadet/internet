<template>
<section class="content-header">
    <div class="container-fluid">
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Applicants</h3>
                        <div class="card-tools">
                            <button class="btn btn-sm btn-success" @click="addApplicant"><i class="fa fa-user-plus"></i> Create Applicant</button>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Reg. Date</th>
                                    <th>Applicant</th>
                                    <th>Date of Birth</th>
                                    <th>Sex</th>
                                    <th>Nationality</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody v-if="applicants.data == null || applicants == null">
                                <tr>
                                    <td colspan="6" class="text-center">You have not made any applicants yet</td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(applicant, index) in applicants.data" :key="applicant.id">
                                    <td>{{applicant.created_at | excelDate}} </td>
                                    <td>{{applicant.first_name+' '+applicant.middle_name+' '+applicant.last_name}}</td>
                                    <td>{{applicant.dob | excelDate}}</td>
                                    <td>{{applicant.sex}}</td>
                                    <td>{{applicant.nationality ? applicant.nationality.name : 'Not Defined'}}</td>
                                    <td>
                                        <div class="btn btn-group">
                                            <button class="btn btn-primary btn-sm" @click="editApplicant(applicant)" title="Edit Applicant"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                        </div> 
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <pagination :data="applicants" @pagination-change-page="getApplicant">
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
        applicants: {},
        appointments: {},
        editMode: true,
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
        $('#paymentModal').modal('hide');
        $('#applicantModal').modal('hide');
        $('#appointmentModal').modal('hide');
    });
    Fire.$on('refresh', response => {
        this.refreshAppointments(response);
        $('#paymentModal').modal('hide');
        $('#patientModal').modal('hide');
        $('#appointmentModal').modal('hide');
    });
    Fire.$on('refreshPayment', response => {
        this.refreshAppointments(response);
        $('#paymentModal').modal('hide');
    });
    Fire.$on('searchInstance', ()=>{
        let query = this.$parent.search;
        axios.get('/api/emr/patients/search?q='+query)
        .then((response ) => {this.applicants = response.data.applicants;})
        .catch(()=>{});
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
    editApplicant(applicant){
        this.$Progress.start();
        this.editMode = true;
        this.applicant = applicant;
        Fire.$emit('ApplicantDataFill', applicant);
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
    getApplicant(page=1){
        axios.get('/api/emr/patients?page='+page)
        .then(response=>{
            this.refreshAppointments(response); 
        });
    },
    getInitials() {
        axios.get('/api/emr/patients')
        .then(response => {this.refreshAppointments(response)})
        .catch(() => {
            this.$Progress.fail();
            toast.fire({icon: 'error', title: 'Your appointments did not loaded successfully',})
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
        this.applicants = response.data.applicants;
    }
},
props: {}
}
</script>