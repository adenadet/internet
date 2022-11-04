<template>
<section>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label>Patient</label>
                <div class="form-control" v-html="patient != null ? patient.last_name+' '+patient.first_name+' '+patient.middle_name: 'No patient detail'"></div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>Service</label>
                <div class="form-control" id="service_name" name="service_name" placeholder="Service Name" v-html="consultation.service != null ? consultation.service.name : 'No service selected'"></div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Result Summary</label>
                <select disabled class="form-control" id="summary" name="summary" v-model="report.summary">
                    <option value="">--Select Report Summary--</option>
                    <option value="normal">Normal</option>
                    <option value="suggestive">Abnormal TB suggestive</option>
                    <option value="not suggestive">Abnormal not TB suggestive</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Findings <span><small>You can choose multiple</small></span></label>
                <div disabled class="form-control" id="findings" name="findings[]">
                    <span v-for="finding in report.findings" v-html="finding.code+': '+finding.name"></span>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label>Detailed Report*</label>
                <div style="width:100%; padding: 2px; border: 1px solid #222; min-height:200px;" v-html="report.details"></div>
            </div>
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
        consultation: Object,
        patient: Object,
        report: Object,
        findings: Array,
    }
};
</script>