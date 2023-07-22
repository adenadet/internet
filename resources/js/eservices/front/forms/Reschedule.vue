<template>
<div class="card card-primary ">
    <div class="modal fade" id="termsModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header"><h4 class="modal-title">Terms and Conditions</h4><button type="button" class="close"  @click="closeModal"><span aria-hidden="true">&times;</span></button></div>
                <div class="modal-body">
                    <EServiceDetailPolicy />
                </div>
            </div>
        </div>
    </div>
    <div class="card-header bg-navy">Reschedule An Appointment</div>
    <div class="card-body">
        <form>
            <alert-error :form="RescheduleData"></alert-error> 
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <div class="form-group">
                        <label>Tracking ID</label>
                        <input class="form-control" type="text" name="tracking_id" id="tracking_id" placeholder="SNH-0000-0000-0000" v-model="RescheduleData.tracking_id" @change="searchAppointment()"/>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="form-group">
                        <label>Appointment Details</label>
                        <div class="form-control" type="text" disabled name="details" id="details">{{ RescheduleData.details }}</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Preferred Date*</label>
                        <input type="date" class="form-control" id="preferred_date" name="preferred_date" :min="today" required v-model="RescheduleData.preferred_date" :class="{'is-invalid' : RescheduleData.errors.has('preferred_date') }" @change="searchSchedule()" />
                        <has-error :form="RescheduleData" field="preferred_date"></has-error> 
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Preferred Time *</label>
                        <select class="form-control" id="preferred_time" name="preferred_time" required v-model="RescheduleData.preferred_time" :class="{'is-invalid' : RescheduleData.errors.has('preferred_time') }">
                            <option value=''>---Select Preferred Timing---</option>
                            <option v-for="reschedule in schedules" :value="reschedule.schedule">{{reschedule.schedule}}</option>
                        </select>
                        <has-error :form="RescheduleData" field="preferred_time"></has-error> 
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label>Reason for Rescheduling*</label>
                        <wysiwyg rows="5" id="uk_address" name="uk_address" placeholder="Enter Address *" required v-model="RescheduleData.uk_address" :class="{'is-invalid' : RescheduleData.errors.has('uk_address') }"></wysiwyg>
                    </div>
                </div>
                <input type="hidden" name="id" id="id" v-model="RescheduleData.id">
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label class="form-check-label">I have read and accepted the <a href="#" @click.prevent="viewTerms()">Terms and conditions</a> of St. Nicholas Hospital as well as the United Kingdom Home office.</label>
                        <input class="form-check-input ml-2" type="checkbox" name="terms" id="terms" v-model="terms">
                        
                    </div>
                </div>
            </div>
            <paystack style="margin-auto;" class="btn btn-primary" type="button" :amount="this.RescheduleData.amount * 100" :email="RescheduleData.email" :paystackkey="PUBLIC_KEY" :callback="processAppointment" :close="close" :reference="genRef()" :embed="false" :disabled="terms == 0 || RescheduleData.preferred_date == '' || RescheduleData.email == '' || RescheduleData.full_name == ''">PAY NGN {{this.RescheduleData.amount}} Online</paystack>
        </form>
    </div>
    <div class="card-footer">
        Kindly note that terms 
    </div>
</div>
</template>
<script>
import paystack from 'vue-paystack';
export default {
    components: {
        paystack
    },
    data(){
        return  {
            appointment: {},
            terms: 0,
            today: '',
            PUBLIC_KEY:"pk_live_9e3c92567f7ad310ae7c28e248b8edb67ca2661a",
            amount: 0,
            nations: [],
            schedules: [],
            services: [], 
            RescheduleData: new Form({
                tracking_id: '', 
                appointment_id:'',
                email: 'adenadet01@gmail.com',
                amount: '15000',
                preferred_date:'', 
                preferred_time: '',
                amount: '',
                full_name: '',
                payment_method:'',
                payment_reference: '',
                payment_transaction: '',
                details: '',
            }),
        }
    },
    mounted() {
        this.getInitials();
            
        Fire.$on('RescheduleDataFill', user =>{
            this.RescheduleData.fill(user);
        });
        Fire.$on('AfterCreation', ()=>{
            
        });
    },
    methods:{
        callback: function(response){
            console.log(response)
        },
        closeModal(){
            $('#termsModal').modal('hide');
        },
        close: function(){
            console.log("Payment closed")
        },
        createApplicant(){
            this.$Progress.start();
            this.RescheduleData.put('/api/scheduler/'+this.RescheduleData.tracking_id)
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('refreshAppointment', response);
                this.RescheduleData.reset();
                Swal.fire({icon: 'success', title: 'The Profile details has been created', showConfirmButton: false, timer: 1500});
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
        genRef(){
            return "Task_"+ new Date().valueOf();
        },
        getInitials(){
            axios.get('/api/scheduler')
            .then(response => {;
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; 
                var yyyy = today.getFullYear();
                if(dd<10){dd='0'+dd;} 
                if(mm<10){mm='0'+mm;} 
                today = yyyy+'-'+mm+'-'+dd;
            this.today = today;
            this.refreshScheduler(response)
            })
            .catch(() => {
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Your appointments did not loaded successfully',})
            });
        },
        isWeekend(date){
            var cast = new Date(date)
            console.log(cast);
            console.log(cast.getDay() === 6 || cast.getDay() === 0);
            return cast.getDay() === 6 || cast.getDay() === 0;
        },
        processAppointment(response){
            if (response.message == "Approved"){
                alert("Payment was successful");
                this.RescheduleData.payment_method = "Paystack";
                this.RescheduleData.payment_reference= response.reference;
                this.RescheduleData.payment_transaction = response.transaction;

                this.createApplicant();
            }
            else{
                alert("Payment has to be made to confirm booking");
            }
        },
        processBooking(){
            console.log(response);
            this.RescheduleData.payment_method = "Holding";
        },
        refreshScheduler(response){
            this.services = response.data.services;
            this.nations = response.data.nations;
        },
        searchAppointment(){
            this.$Progress.start();
            if (this.RescheduleData.tracking_id.length >= 18){
                axios.get('/api/scheduler/'+this.RescheduleData.tracking_id)
                .then(response =>{
                    this.appointment = response.data.appointment;
                    if (this.appointment == null){
                        toast.fire({icon: 'error',title: 'No Appointment with this Tracking ID found',})
                    }
                    else{
                        this.RescheduleData.details = this.appointment.patient.first_name+' '+this.appointment.patient.last_name+' | '+this.appointment.service.name+' scheduled for '+this.appointment.date;
                        this.RescheduleData.full_name = this.appointment.patient.first_name+' '+this.appointment.patient.last_name;
                        this.RescheduleData.email = Math.random().toString(36).substring(2,3)+this.appointment.patient.email
                        var dob = new Date(this.appointment.patient.dob);
                        var month_diff = Date.now() - dob.getTime();  
                        var age_dt = new Date(month_diff);   
                        var year = age_dt.getUTCFullYear();  
                        var age = Math.abs(year - 1970);  
            
                        if (age >= 11){this.RescheduleData.amount = 15000;}
                        else {this.RescheduleData.amount = 7500;}
                    }
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'No Appointment with this Tracking ID found',
                    })
                });
            }
        },
        searchSchedule(){
            if (this.isWeekend(this.RescheduleData.preferred_date)){
                alert("Weekend not available for selection");
                this.RescheduleData.preferred_date = "";
                return;
            }
            axios.get('/api/schedules?service_id='+3+'&date='+this.RescheduleData.preferred_date)
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
        updateAmount(){
            var dob = new Date(this.RescheduleData.dob);
            var month_diff = Date.now() - dob.getTime();  
            var age_dt = new Date(month_diff);   
            var year = age_dt.getUTCFullYear();  
            var age = Math.abs(year - 1970);  
            
            if (age >= 11){this.RescheduleData.amount = 60000;}
            else {this.RescheduleData.amount = 30000;}
        },
        updateProfilePic(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file['size'] < 2000000){
                reader.onloadend = (e) => {
                    this.RescheduleData.image = reader.result
                    }
                reader.readAsDataURL(file)
            }
            else{
                Swal.fire({
                    type: 'error',
                    title: 'File is too large'
                })
            }
        },
        viewTerms(){
            $('#termsModal').modal('show');
        }
    },
    props:{
    }
}
</script>