<template>
<section>
    <div class="row">
        <div class="col-12">
            <EServiceFormSearch />
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Appointments</h3>
                    <div class="card-tools">
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
                                <td><span class="tag tag-success">Awaiting Xray</span></td>
                                <td>
                                    <div class="btn btn-group">
                                        <button class="btn btn-primary btn-sm" @click="confirmAppointment(appointment.id)"><i class="fa fa-x-ray"></i></button>
                                    </div> 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <pagination :data="appointments" @pagination-change-page="getInitials">
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
            $('#paymentModal').modal('hide');
            $('#patientModal').modal('hide');
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
        confirmAppointment(id){
            Swal.fire({
                title: 'Are you sure the Xray has been done?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, it has been done!'
                })
            .then((result) => {
                //Send Delete request
                if(result.value){
                    this.form.put('/api/emr/appointments/xray/'+id)
                    .then(response=>{
                    Swal.fire('Confirmed!', 'The Xray has been confirmed.', 'success');
                    this.refreshAppointments(response);   
                    })
                    .catch(()=>{
                    Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });
        },
        getInitials(page=1){
            axios.get('/api/emr/appointments/xray?page='+page)
            .then(response => {this.refreshAppointments(response)})
            .catch(() => {
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Your appointments did not loaded successfully',})
            });
        },
        refreshAppointments(response) {
            this.appointments = response.data.appointments;
        },
    },
    props: {}
}
</script>