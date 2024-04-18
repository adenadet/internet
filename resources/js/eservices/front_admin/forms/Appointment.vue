<template>
<section class="row clearfix">
    <div class="col-md-12">
        <form @submit.prevent="editMode ? updateAppointment() : createAppointment() ">
            <alert-error :form="appointmentData"></alert-error> 
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="form-group" v-if="!editMode">
                        <label>Applicant</label>
                        <model-list-select class="form-control" :list="patients" v-model="appointmentData.patient_id" option-value="id" :custom-text="codeAndNameAndDesc" placeholder="Select Applicant" />
                        <select class="form-control" id="patient_id" name="patient_id" v-model="appointmentData.patient_id" required>
                            <option value="">--Select Applicants--</option>
                            <option v-for="patient in patients" :key="patient.id" :value="patient.id">{{patient.last_name+', '+patient.first_name+' '+patient.middle_name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label>Service</label>
                        <select class="form-control" id="service_id" name="service_id" v-model="appointmentData.service_id" required>
                            <option value="">--Select Service--</option>
                            <option v-for="service in services" :key="service.id" :value="service.id">{{service.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>Date</label>
                        <input class="form-control" type="date" name="date" id="date" v-model="appointmentData.date" @change="searchSchedule()"/>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>Schedule</label>
                        <select class="form-control" id="schedule" name="schedule" v-model="appointmentData.schedule" required>
                            <option value=''>--Select Available Time--</option>
                            <option v-for="(schedule, index) in schedules" :key="index" :value="schedule.schedule">{{schedule.schedule}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
        </form>
    </div>
</section>
</template>
<script>
export default {
    data(){
        return  {
            appointmentData: new Form({
                patient_id: "",
                schedule: "",
                service_id: "",
                date: "",
                id: "",
            }),
            schedules: [],
        }
    },
    mounted() {
        Fire.$on('AppointmentDataFill', appointment =>{
            if (appointment != null){
                this.appointmentData.patient_id = appointment.patient_id;
                this.appointmentData.schedule = appointment.schedule;
                this.appointmentData.service_id = appointment.service_id;
                this.appointmentData.date = appointment.date;
                this.appointmentData.id = appointment.id;
            }
        });
    },
    methods:{
        codeAndNameAndDesc(item){return `${item.user.last_name}, ${item.user.first_name} ${item.user.middle_name}`},
        createAppointment(){
            this.$Progress.start();
            this.appointmentData.post('/api/emr/appointments')
            .then(response => {
                this.$Progress.finish();
                Fire.$emit('refreshAppointment', response);
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
        },
        getAllInitials(){
            axios.get('/api/emr/appointments/initials')
            .then(response =>{
                this.schedules = response.data.schedules;
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Schedules not loaded successfully',
                })
            });
        },
        updateAppointment(){
            this.$Progress.start();
            this.appointmentData.put('/api/emr/appointments/'+this.appointmentData.id)
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('refresh', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Appointment details has been modified',
                    showConfirmButton: false,
                    timer: 1500
                    });
                
                })
            .catch(()=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please try again later!'
                    });
                this.$Progress.fail();
            });          
        },
        searchSchedule(){
            if (this.appointmentData.service_id == ""){
                alert("Please select the service type");
                this.appointmentData.date = "";
                return;
            }
            axios.get('/api/schedules?service_id='+this.appointmentData.service_id+'&date='+this.appointmentData.date)
            .then(response =>{
                this.schedules = response.data.schedules;
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Schedules not loaded successfully',
                })
            });
        },
    },
    props:{
        editMode: Boolean,
        services: Array,
        patients: Array,
        appointment: Object,
    }
}
</script>