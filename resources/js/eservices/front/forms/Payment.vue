<template>
<div class="card">
    <form role="form">
        <alert-error :form="PaymentData"></alert-error> 
        <div class="card-body">
            <div class="form-group">
                <label for="exampleInputPassword1">Appointment Detail</label>
                <div v-show="paySpecific"  disabled type="text" class="form-control" id="patient" name="patient" :class="{'is-invalid' : PaymentData.errors.has('appointment_id') }">
                    {{appointment != null && appointment.patient != null ? appointment.patient.first_name+' '+appointment.patient.last_name+' on '+appointment.date+'@ '+appointment.schedule+' | '+appointment.service.name: 'Unknown Applicant'}}
                </div>
                <input type="hidden" name="appointment_id" id="appointment_id" v-model="PaymentData.appointment_id" />
                
                <select v-show="!paySpecific" class="form-control" id="appointment" name="appointment" @change="selectedAppointment"  :class="{'is-invalid' : PaymentData.errors.has('appointment_id') }">
                    <option value="">-- Select Appointment to Pay For--</option>
                    <option v-for="(appointment, index) in appointments" :key="appointment.id" :value="index">{{appointment != null && appointment.patient != null ? appointment.patient.first_name+' '+appointment.patient.last_name+' on '+appointment.date+'@ '+appointment.schedule+' | '+appointment.service.name: 'Unknown Applicant'}}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Patient</label>
                <div class="form-control" id="patient" name="patient" disabled :class="{'is-invalid' : PaymentData.errors.has('patient_id') }">
                    {{appointment != null && appointment.patient != null ? appointment.patient.first_name+' '+appointment.patient.other_name+' '+appointment.patient.last_name : 'Unknown Applicant'}}
                </div>
                <input type="hidden" name="patient_id" id="patient_id" v-model="PaymentData.patient_id" />
                
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Services</label>
                <div class="form-control" id="service" name="service" disabled :class="{'is-invalid' : PaymentData.errors.has('service_id') }">
                    {{appointment != null && appointment.service != null ? appointment.service.name: 'No Service Chosen'}}
                </div>
                <input type="hidden" name="service_id" id="service_id" v-model="PaymentData.service_id" />
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Payment Type</label>
                <select class="form-control" id="channel" name="channel" required  v-model="PaymentData.channel">
                    <option value="">--Select Payment Type---</option>
                    <option value="POS">POS</option>
                    <option value="Cash">Cash</option>
                    <option value="Transfer">Transfer</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" placeholder="Amount Paid"  v-model="PaymentData.amount">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Details</label>
                <textarea rows=5 class="form-control" id="details" name="details" placeholder="POS/Transfer ID"  v-model="PaymentData.details">
                </textarea>
            </div>
            <!--
            <div class="form-group">
                <label for="exampleInputFile">File input</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                    <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                    </div>
                </div>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>-->
        </div>
        
        <div class="card-footer">
            <button @click.prevent="makePayment" type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
</template>
<script>
export default {
    data(){
        return  {
            appointment: {},
            appointment_id: 0,
            appointments: {},
            paySpecific: false,
            PaymentData: new Form({
                patient_id:'', 
                service_id:'', 
                appointment_id:'',
                channel: '',
                amount: '0.00', 
            }),
        }
    },
    mounted() {
        Fire.$on('PaymentDataFill', appointment =>{
            this.paySpecific = true;
            this.refreshHolder(appointment);    
        });
        Fire.$on('UnpaidAppointments', appointments => {
            this.paySpecific - false;
            this.appointments = appointments;
        })
        Fire.$on('AfterCreation', ()=>{
            //axios.get("api/profile").then(({ data }) => (this.PaymentData.fill(data)));
        });
    },
    methods:{
        makePayment(){
            this.$Progress.start();
            this.PaymentData.post('/api/emr/payments')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('refreshPayment', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Payment has been made',
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
        refreshHolder(appointment){
            this.appointment = appointment;
            this.PaymentData.patient_id = appointment.patient_id;
            this.PaymentData.service_id = appointment.service_id;
            this.PaymentData.appointment_id = appointment.id;
        },
        selectedAppointment(){
            this.refreshHolder(this.appointments[this.appointment_id])
        },
        
    },
}
</script>