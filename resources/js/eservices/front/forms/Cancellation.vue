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
    <div class="card-header bg-navy">Cancel An Appointment</div>
    <div class="card-body">
        <form>
            <alert-error :form="CancellationData"></alert-error> 
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <div class="form-group">
                        <label>Tracking ID</label>
                        <input class="form-control" type="text" name="tracking_id" id="tracking_id" placeholder="SNH-0000-0000-0000" v-model="CancellationData.tracking_id" @change="searchAppointment()"/>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="form-group">
                        <label>Appointment Details</label>
                        <div class="form-control" type="" name="date" id="date"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Bank *</label>
                        <select class="form-control" id="bank" name="bank" required v-model="CancellationData.bank" :class="{'is-invalid' : CancellationData.errors.has('bank') }">
                            <option value=''>---Select Bank---</option>
                            <option v-for="bank in banks" :key="bank.id" :value="bank.id">{{ bank.name }}</option>
                        </select>
                        <has-error :form="CancellationData" field="bank"></has-error> 
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Account Name*</label>
                        <input type="" class="form-control" id="account_name" name="account_name" :min="today" required v-model="CancellationData.account_name" :class="{'is-invalid' : CancellationData.errors.has('account_name') }" @change="searchSchedule()" />
                        <has-error :form="CancellationData" field="account_name"></has-error> 
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Account Number*</label>
                        <input type="text" class="form-control" id="account_number" name="account_number" required v-model="CancellationData.account_number" :class="{'is-invalid' : CancellationData.errors.has('account_number') }" @change="searchSchedule()" />
                        <has-error :form="CancellationData" field="account_number"></has-error> 
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label>Reason for Cancellation*</label>
                        <wysiwyg rows="5" id="uk_address" name="uk_address" placeholder="Enter Reason for cancellation *" required v-model="CancellationData.uk_address" :class="{'is-invalid' : CancellationData.errors.has('uk_address') }"></wysiwyg>
                    </div>
                </div>
                <input type="hidden" name="id" id="id" v-model="CancellationData.id">
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label class="form-check-label">I have read and accepted the <a href="#" @click.prevent="viewTerms()">Terms and conditions</a> of St. Nicholas Hospital as well as the United Kingdom Home office.</label>
                        <input class="form-check-input ml-2" type="checkbox" name="terms" id="terms" v-model="terms">
                        
                    </div>
                </div>
            </div>
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
            banks: [],
            terms: 0,
            today: '',
            PUBLIC_KEY: "pk_live_9e3c92567f7ad310ae7c28e248b8edb67ca2661a",
            amount: 0,
            nations: [],
            schedules: [],
            services: [], 
            CancellationData: new Form({
                tracking_id: '', 
                appointment_id:'', 
                bank_id:'', 
                account_name: '',
                account_number: '',
                amount: '',
            }),
        }
    },
    mounted() {
        this.getInitials();
    },
    methods:{
        closeModal(){
            $('#termsModal').modal('hide');
        },
        createApplicant(){
            this.$Progress.start();
            this.CancellationData.post('/api/scheduler')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('refreshAppointment', response);
                this.CancellationData.reset();
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
        refreshScheduler(response){
            this.services = response.data.services;
            this.nations = response.data.nations;
        },
        processAppointment(response){
            if (response.message == "Approved"){
                alert("Payment was successful");
                this.CancellationData.payment_method = "Paystack";
                this.CancellationData.payment_reference= response.reference;
                this.CancellationData.payment_transaction = response.transaction;

                this.createApplicant();
            }
            else{
                alert("Payment has to be made to confirm booking");
            }
        },
        processBooking(){
            console.log(response);
            this.CancellationData.payment_method = "Holding";
        },
        searchAppointment(){
            if (this.CancellationData.tracking_id.length01234 >= 18){
                alert("Processing");
                //search for the tracking id

            }
        },
        searchSchedule(){
            if (this.isWeekend(this.CancellationData.preferred_date)){
                alert("Weekend not available for selection");
                this.CancellationData.date = "";
                return;
            }
            axios.get('/api/schedules?service_id='+this.CancellationData.service_id+'&date='+this.CancellationData.preferred_date)
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
            var dob = new Date(this.CancellationData.dob);
            var month_diff = Date.now() - dob.getTime();  
            var age_dt = new Date(month_diff);   
            var year = age_dt.getUTCFullYear();  
            var age = Math.abs(year - 1970);  
            
            if (age >= 11){this.CancellationData.amount = 60000;}
            else {this.CancellationData.amount = 30000;}
        },
        updateProfilePic(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file['size'] < 2000000){
                reader.onloadend = (e) => {
                    this.CancellationData.image = reader.result
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