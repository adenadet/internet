<template>
<section>
<form v-if="((appointment.consent != null) && (appointment.consultation != null) && (appointment.report != null))">
	<alert-error :form="IssueData"></alert-error> 
	<div class="card row">
        <div class="card-header">Issue Certificate</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Patient</label>
                        <div class="form-control" v-html="appointment.patient != null ? appointment.patient.last_name+' '+appointment.patient.first_name+' '+appointment.patient.middle_name: 'No patient detail'" :class="{'is-invalid' : IssueData.errors.has('first_name') }"></div>
                        <has-error :form="IssueData" field="first_name"></has-error> 
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Service</label>
                        <div class="form-control" v-html="appointment.service != null ? appointment.service.name : 'No service selected'" :class="{'is-invalid' : IssueData.errors.has('middle_name') }"></div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Action*</label>
                        <select class="form-control" id="summary" name="summary" required v-model="IssueData.issue_action" :class="{'is-invalid' : IssueData.errors.has('issue_action') }">
                            <option value="">--Select Action--</option>
                            <option value="certificate">Issue Certificate</option>
                            <option value="cert_ref">Issue Certificate + Referral</option>
                            <option value="referral">Referral only</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label>Details*</label>
                        <wysiwyg id="details" name="details" placeholder="Details *" required v-model="IssueData.issue_detail" :class="{'is-invalid' : IssueData.errors.has('issue_detail') }" />
                    </div>
                </div>
            </div>
            <button @click.prevent="createIssueData()" type="submit" name="submit" class="submit btn btn-success">Submit</button>        
        </div>
    </div>
</form>
</section>
</template>
<script>
export default {
    data() {
        return {
            IssueData: new Form({
                issue_action: "",
                issue_detail: '',
            }),
        };
    },
    methods:{
        createIssueData(){
            this.$Progress.start();
            this.IssueData.appointment_id = this.appointment.id;
            this.IssueData.put('/api/emr/appointments/issue/'+this.appointment.id).then(response =>{
                this.$Progress.finish();
                Fire.$emit('reportReload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Certifcate is cleared for issue',
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
    }
};
</script>