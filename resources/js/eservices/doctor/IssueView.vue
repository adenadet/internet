<template>
<section>
    <div class="card row">
        <div class="card-header">Issue Certificate</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Patient</label>
                        <div class="form-control" v-html="appointment.patient != null ? appointment.patient.last_name+' '+appointment.patient.first_name+' '+appointment.patient.middle_name: 'No patient detail'"></div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Service</label>
                        <div class="form-control" v-html="appointment.service != null ? appointment.service.name : 'No service selected'"></div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Action*</label>
                        <select class="form-control" id="summary" name="summary" disabled v-model="appointment.issue_action">
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
                        <div style="width: 100%; border: 1px solid #666; min-height:200px; padding:3px 5px;" id="details" name="details" placeholder="Details *" v-html="appointment.issue_detail"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <p>Issuing Doctor: <br /><b>{{appointment.issuing_officer.first_name+' '+appointment.issuing_officer.last_name}}</b></p>
            <p>Issue Date: {{appointment.issue_at | excelDate}}</p>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data() {
        return {
        };
    },
    methods:{
    },
    props:{
        appointment: Object,
        patient: Object,
    }
};
</script>