<template>
<div>
<form>
    <alert-error :form="AppointmentData"></alert-error> 
    <div class="row">
        <div v-if="creator == 'self'" class="col-sm-12">
            <div class="form-group">
                <label>Applicant *</label>
                <input type="text" required class="form-control" id="patient_id" name="patient_id" placeholder="First Name *" v-model="AppointmentData.patient_id" :class="{'is-invalid' : AppointmentData.errors.has('patient_id') }">
                <has-error :form="AppointmentData" field="patient_id"></has-error> 
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>Applicant *</label>
                <input type="text" required class="form-control" id="first_name" name="first_name" placeholder="First Name *" v-model="AppointmentData.first_name" :class="{'is-invalid' : AppointmentData.errors.has('first_name') }">
                <has-error :form="AppointmentData" field="first_name"></has-error> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9 col-sm-12">
            <div class="form-group">
                <label>Service *</label>
                <select class="form-control" id="service_id" name="service_id" placeholder="Enter State / County *" required v-model="AppointmentData.service_id" :class="{'is-invalid' : AppointmentData.errors.has('service_id') }">
                    <option value="">--Select Service--</option>
                    <option v-for="service in services" v-bind:key="service.id" :value="service.id" >{{service.name+' @ N'+service.price}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
                <label>Date</label>
                <input type="date" class="form-control" id="date" name="date" placeholder="Choose Convinent Date" v-model="AppointmentData.date" :class="{'is-invalid' : AppointmentData.errors.has('date') }" @change="noWeekend" onfocus="this.min=new Date().toISOString().split('T')[0]">
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Time Slot *</label>
                <select type="text" class="form-control" id="time_slot" name="time_slot"  v-model="AppointmentData.time_slot" :class="{'is-invalid' : AppointmentData.errors.has('time_slot') }">
                    <option value="">--Select Preffered Time Slot--</option>
                    <option v-for="time_slot in time_slots" :key="time_slot.id" :value="time_slot.time">{{time_slot.time}}</option>
                </select>
            </div>
        </div>
        <input type="hidden" name="id" id="id" v-model="AppointmentData.id">
    </div>
    <button @click.prevent="editMode ? updateAppointment() : createAppointment()" type="submit" name="submit" class="submit btn btn-success">Submit</button>
</form>
</div>
</template>
<script>
export default {
    data(){
        return  {
            editMode: true, 
            AppointmentData: new Form({
                patient_id: '', 
                service_id:'', 
                date:'', 
                time_slot:'',
                id: '', 
            }),
            time_slots: [],
            today: "",
        }
    },
    mounted() {
        this.setDate();
        Fire.$on('AppointmentDataFill', user =>{
            this.AppointmentData.fill(user);
        });
        Fire.$on('AfterCreation', ()=>{
            //axios.get("api/profile").then(({ data }) => (this.AppointmentData.fill(data)));
        });
    },
    methods:{
        createUser(){

            },
        updateAppointmentData(){
            this.$Progress.start();
            this.AppointmentData.post('/api/ums/bios')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Profile details has been updated',
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
        noWeekend(){
            this.$Progress.start();//alert(this.AppointmentData.date);
            var day = new Date(this.AppointmentData.date).getUTCDay();
            if([6,0].includes(day)){
                alert('Weekends are not allowed');
                this.AppointmentData.date == '';
                //e.target.setCustomValidity('week-end not allowed')
            } 
            else {
                axios.get('/api/emr/schedulers/'+this.AppointmentData.date).then(response =>{
                    this.time_slots = response.data.time_slots;
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                });
                //e.target.setCustomValidity('')
            }
        },
        setDate(){
            this.today = new Date(Date.now()).toLocaleString();
        }
    },
    props:{
        services: Array,
        creator: String,
        users: Array, 
    }
}
</script>