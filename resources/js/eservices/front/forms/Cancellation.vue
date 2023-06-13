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
                        <has-error :form="CancellationData" field="tracking_id"></has-error> 
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="form-group">
                        <label>Appointment Details</label>
                        <div class="form-control" type="text" disabled name="details" id="details">{{ CancellationData.details }}</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Bank *</label>
                        <select class="form-control" id="bank_id" name="bank_id" required v-model="CancellationData.bank_id" :class="{'is-invalid' : CancellationData.errors.has('bank_id') }">
                            <option value=''>---Select Bank---</option>
                            <option v-for="bank in banks" :key="bank.id" :value="bank.id">{{ bank.bank_name }}</option>
                        </select>
                        <has-error :form="CancellationData" field="bank_id"></has-error> 
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
                        <wysiwyg rows="5" id="reason" name="reason" placeholder="Enter Reason for cancellation *" required v-model="CancellationData.reason" :class="{'is-invalid' : CancellationData.errors.has('reason') }"></wysiwyg>
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
            <button @click.prevent="cancelAppointment()" type="submit" name="submit" class="submit btn btn-primary" :disabled="terms == 0 || CancellationData.tracking_id == '' || CancellationData.bank_id == '' || CancellationData.account_name == '' || CancellationData.account_number == ''">Cancel Appointment</button>

        </form>
    </div>
    <div class="card-footer">
        Kindly note that terms 
    </div>
</div>
</template>
<script>
export default {

    data(){
        return  {
            appointment: {},
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
                details: '',
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
        cancelAppointment(){
            Swal.fire({
                title: 'Are you sure?',
                text: "A 50% charge would apply and you would not be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel the appointment!'
            })
            .then((result) => {
                this.$Progress.start();
                this.CancellationData.post('/api/emr/cancellations')
                .then(response =>{
                    this.$Progress.finish();
                    Fire.$emit('refreshAppointment', response);
                    this.CancellationData.reset();
                    Swal.fire({icon: 'success', title: 'The appointment has been cancelled successfully', showConfirmButton: false, timer: 1500});
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
            });  
        },
        getInitials(){
            axios.get('/api/emr/cancellations')
            .then(response => {;
                this.banks = response.data.banks;
            })
            .catch(() => {
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Your appointments did not loaded successfully',})
            });
        },
        searchAppointment(){
            this.$Progress.start();
            if (this.CancellationData.tracking_id.length >= 18){
                axios.get('/api/scheduler/'+this.CancellationData.tracking_id)
                .then(response =>{
                    this.appointment = response.data.appointment;
                    if (this.appointment == null){
                        toast.fire({icon: 'error',title: 'No Appointment with this Tracking ID found',})
                    }
                    else{
                        this.CancellationData.details = this.appointment.patient.first_name+' '+this.appointment.patient.last_name+' | '+this.appointment.service.name+' scheduled for '+this.appointment.date;
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
        viewTerms(){
            $('#termsModal').modal('show');
        }
    },
    props:{
    }
}
</script>