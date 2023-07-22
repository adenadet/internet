<template>
<section class="content-header">
    <div class="container-fluid">
        <section class="card card-primary">
            <div class="card-header">Report Query</div>
            <div class="card-body">
                <div class="col-md-12">
                    <form @submit.prevent="searchAppointment()">
                        <alert-error :form="reportData"></alert-error> 
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Report Type</label>
                                    <select class="form-control" id="report_type" name="report_type" v-model="reportData.report_type" required>
                                        <option value="">--Select Type of Detailed Report--</option>
                                        <option value="started">All Started Appointments</option>
                                        <option value="completed">All Completed Appointments</option>
                                        <option value="all">All Appointments</option>
                                        <option value="missed">Missed Appointments</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Date:</label>
                                    <input type="date" class="form-control" id="date" name="date" v-model="reportData.date" required/>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-search mr-1"></i>Search</button>
                    </form>
                </div>
            </div>
        </section>
        <div class="row">
            <div class="col-12">
                <div class="card card-success">
                    <div class="card-header"><h3 class="card-title">Report</h3></div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Date</th>
                                    <th>Applicant</th>
                                    <th>Consultant</th>
                                    <th>Radiologist</th>
                                    <th>Laboratory</th>
                                    <th>Issuing Officer</th>
                                    <th>Decision</th>
                                    <th>Certificate Type</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody v-if="appointments == null">
                                <tr><td colspan="6" class="text-center">You have not made any appointments yet</td></tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(appointment, index) in appointments" :key="index">
                                    <td>{{index | addOne}}</td>
                                    <td>{{appointment.date | excelDate}}</td>
                                    <td>{{appointment.patient_id != null && appointment.patient != null ? appointment.patient.first_name+' '+appointment.patient.middle_name+' '+appointment.patient.last_name:'Deleted User'}} <br /><small>{{appointment.unique_id}}</small></td>
                                    <td>{{appointment.medical_officer != null ? appointment.medical_officer.first_name+' '+appointment.medical_officer.last_name: 'Not yet seen by consultant'}}</td>
                                    <td>{{appointment.radiologist != null ? appointment.radiologist.first_name+' '+appointment.radiologist.last_name : 'No Xray was done'}}</td>
                                    <td>{{appointment.laboratory != null ? appointment.laboratory.first_name+' '+appointment.laboratory.last_name : 'No Sputum Test was done'}}</td>
                                    <td>{{appointment.issuing_officer != null ? 'Dr. '+appointment.issuing_officer.first_name+' '+appointment.issuing_officer.last_name : 'Not Yet Issued'}}</td>
                                    <td>{{appointment.decision}}</td>
                                    <td><span class="tag tag-success">{{appointment.issue_action == 'certificate' ? 'Certificate' :(appointment.issue_action == 'cert+ref' ? 'Certificate & Referral' :(appointment.issue_action == 'referral' ? 'Referral Only' :(appointment.issue_action == null ? 'Error/Not yet Issued' : 'Something Strange')))}}</span></td>
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
            appointments:[],
            reportData: new Form({
                report_type: "",
                date: "",
            }),
        }
    },
    mounted() {
        //this.getInitials();
        Fire.$on('refreshReport', response => {
            this.refreshReport(response);
        });
    },
    methods: {
        refreshAppointment(response) {
            this.appointments = response.data.appointments;
        },
        searchAppointment(){
            this.$Progress.start();
            this.reportData.post('/api/emr/admin/detailed_report')
            .then(response => {
                this.appointments = response.data.appointments;
                //this.refreshAppointment(response);
                this.$Progress.finish();
            })
            .close(()=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please try again later!'
                    });
                this.$Progress.fail();
            });
        }
    },

}
</script>