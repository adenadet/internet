<template>
<section>
<form v-if="((appointment.consent != null) && (appointment.consultation != null))">
	<alert-error :form="LabReportData"></alert-error> 
	<div class="card row">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Patient</label>
                        <div class="form-control" v-html="appointment.patient != null ? appointment.patient.last_name+' '+appointment.patient.first_name+' '+appointment.patient.middle_name: 'No patient detail'" :class="{'is-invalid' : LabReportData.errors.has('first_name') }"></div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Service</label>
                        <div class="form-control" v-html="appointment.service != null ? appointment.service.name : 'No service selected'" :class="{'is-invalid' : LabReportData.errors.has('middle_name') }"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Result Summary</label>
                        <select class="form-control" id="summary" name="summary" required v-model="LabReportData.summary" :class="{'is-invalid' : LabReportData.errors.has('summary') }">
                            <option value="">--Select Report Summary--</option>
                            <option value="normal">Normal</option>
                            <option value="suggestive">Abnormal suggestive of TB</option>
                            <option value="not suggestive">Abnormal not suggestive of TB</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label>Details*</label>
                        <wysiwyg id="details" name="details" placeholder="Details *" required v-model="LabReportData.details" :class="{'is-invalid' : LabReportData.errors.has('details') }" />
                    </div>
                </div>
            </div>
            <button @click.prevent="createLabReportData()" type="submit" name="submit" class="submit btn btn-success">Submit</button>        
        </div>
    </div>
</form>
</section>
</template>
<script>
export default {
    data() {
        return {
            LabReportData: new Form({
                appointment_id: '',
                summary: '',
                details: '',
            }),
        };
    },
    methods:{
        createLabReportData(){
            this.$Progress.start();
            this.LabReportData.appointment_id = this.appointment.id;
            this.LabReportData.post('/api/emr/laboratories')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('reportReload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Laboratory Result has been uploaded, kindly refresh page.',
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
    },
    props:{
        appointment: Object,
        patient: Object,
    }
};
</script>