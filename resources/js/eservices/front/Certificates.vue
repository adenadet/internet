<template>
<section class="content-header">
    <div class="container-fluid">
        <EServiceFormSearch />
        
        <div class="row">
            <div class="col-12">
                <div class="card card-success">
                    <div class="card-header"><h3 class="card-title">Certificates</h3></div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Applicant</th>
                                    <th>Date</th>
                                    <th>Front Officer</th>
                                    <th>Consultant</th>
                                    <th>Radiologist</th>
                                    <th>Issued By</th>
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
                                    <td>{{appointment.patient_id != null && appointment.patient != null ? appointment.patient.first_name+' '+appointment.patient.middle_name+' '+appointment.patient.last_name:'Deleted User'}} <br /><small>{{appointment.service_id != null && appointment.service != null ? appointment.service.name : ''}}</small></td>
                                    <td>{{appointment.date | excelDate}} <br /><small>{{appointment.schedule}}</small></td>
                                    <td>{{appointment.front_officer != null ? appointment.front_officer.first_name+' '+appointment.front_officer.last_name: 'Not yet attended to'}}</td>
                                    <td>{{appointment.medical_officer != null ? appointment.medical_officer.first_name+' '+appointment.medical_officer.last_name: 'Not yet seen by consultant'}}</td>
                                    <td>{{appointment.radiologist != null ? appointment.radiologist.first_name+' '+appointment.radiologist.last_name : 'No Xray was done'}}</td>
                                    <td>{{appointment.issuing_officer != null ? 'Dr. '+appointment.issuing_officer.first_name+' '+appointment.issuing_officer.last_name : 'Not Yet Issued'}}</td>
                                    <td><span class="tag tag-success">{{appointment.status == 0 ? 'Unpaid' :(appointment.status == 1 ? 'Paid' :(appointment.status == 2 ? 'Reschedule' :(appointment.status == 3 ? 'Cancelled' : (appointment.status == 8 ? 'Completed' : (appointment.status == 10 ? 'Certificate Sent' :'Done')))))}}</span></td>
                                    <td>
                                        <div class="btn btn-group">
                                            <router-link :to="'/eservices/front_office/appointment/'+appointment.id"><button class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></button></router-link>
                                            <a :href="'/certificates/'+appointment.id" target="_blank"><button class="btn btn-success btn-sm"><i class="fa fa-certificate"></i></button></a>
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
    </div>
</section>
</template>
<script>
export default {
    data() {
        return {
            appointments:{},
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('refreshAppointment', response => {
            this.refreshAppointment(response);
        });
    },
    methods: {
        getInitials() {
            axios.get('/api/emr/appointments/certificates')
            .then(response => {this.refreshAppointment(response)})
            .catch(() => {
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'List of Certificates did not loaded successfully',})
            });
        },
        getAppointment(page=1){
            axios.get('/api/emr/appointments/certificates?page='+page)
            .then(response=>{
                this.appointments = response.data.appointments;   
            });
        },
        refreshAppointment(response) {
            this.appointments = response.data.appointments;
            //this.services = response.data.services;
            //this.nations = response.data.nations;
            //this.patients = response.data.patients;
        }
    },
    props: {}
}
</script>