<template>
<section>
    <div class="card">
        <div class="card-body">
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
                            <option value="suggestive">Abnormal suggestive of TB</option>
                            <option value="not suggestive">Abnormal not suggestive of TB</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Findings <span><small>You can choose multiple</small></span></label>
                        <div style="width:100%; padding:5px; border: 1px solid #666;" id="findings" name="findings[]">
                            <p v-for="finding in report.findings">
                            <span v-html="finding.code+': '+finding.name"></span><br />
                            </p>
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
        </div>
        <div class="card-footer">
            <p>Reporting Doctor: <br /><b>{{consultation.radiologist.first_name+' '+consultation.radiologist.last_name}}</b></p>
            <p>Report Date: {{consultation.radiologist_at | excelDate}}</p>
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