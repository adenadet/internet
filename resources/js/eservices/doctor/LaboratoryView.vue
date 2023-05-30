<template>
<section>
    <div class="modal fade" id="laboratoryModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Laboratory Result Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <EServiceDocFormLaboratory :patient="patient" :appointment="consultation" />
                </div>
            </div>
        </div>
    </div>
    <div v-if="consultation.laboratory == null" class="card">
        <div class="card-body">
            <p v-if="consultation.consultation.decision == 7"> Patient sent for Sputum</p>
            <p v-else-if="consultation.consultation.decision == 8"> Kid under the age of 11 years</p>
            <p v-else>Awaiting report <br /><button class="btn btn-sm btn-primary" @click="addLabReport()">Add Report </button></p>
        </div>
    </div>
    <div v-else class="card">
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
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Result Summary</label>
                        <select disabled class="form-control" id="summary" name="summary" v-model="laboratory.summary">
                            <option value="">--Select Report Summary--</option>
                            <option value="normal">Normal</option>
                            <option value="suggestive">Abnormal suggestive of TB</option>
                            <option value="not suggestive">Abnormal not suggestive of TB</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label>Detailed Report*</label>
                        <div style="width:100%; padding: 2px; border: 1px solid #222; min-height:200px;" v-html="laboratory.details"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <p>Reporting Doctor: <br /><b>{{consultation.lab_officer != null ? consultation.lab_officer.first_name+' '+consultation.lab_officer.last_name : 'Old Doctor'}}</b></p>
            <p>Report Date: {{consultation.lab_at | excelDate}}</p>
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
        addLabReport(){
            this.$Progress.start();
            $('#laboratoryModal').modal('show');
            this.$Progress.finish();
        },
    },
    props:{
        consultation: Object,
        patient: Object,
        laboratory: Object,
        findings: Array,
    }
};
</script>