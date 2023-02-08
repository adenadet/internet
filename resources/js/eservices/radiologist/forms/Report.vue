<template>
<section>
<form>
    <alert-error :form="ReportData"></alert-error> 
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label>Patient</label>
                <div class="form-control" v-html="patient != null ? patient.last_name+' '+patient.first_name+' '+patient.middle_name: 'No patient detail'" :class="{'is-invalid' : ReportData.errors.has('first_name') }"></div>
                <has-error :form="ReportData" field="first_name"></has-error> 
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>Service</label>
                <div class="form-control" id="middle_name" name="middle_name" placeholder="middle Name" v-html="service != null ? service.name : 'No service selected'" :class="{'is-invalid' : ReportData.errors.has('middle_name') }"></div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Result Summary</label>
                <select class="form-control" id="summary" name="summary" required v-model="ReportData.summary" :class="{'is-invalid' : ReportData.errors.has('summary') }">
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
                <select class="form-control" id="findings" name="findings[]" multiple v-model="ReportData.findings" :class="{'is-invalid' : ReportData.errors.has('findings') }" required>
                    <option value="">--Select Findings--</option>
                    <option value="-1">None</option>
                    <option v-for="finding in findings" :value="finding.id" :key="finding.id">{{finding.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label>Detailed Report*</label>
                <wysiwyg id="details" name="details" placeholder="Details *" required v-model="ReportData.details" :class="{'is-invalid' : ReportData.errors.has('details') }" />
            </div>
        </div>
    </div>
    <button @click.prevent="editMode ? updateReportData() : createReportData()" type="submit" name="submit" class="submit btn btn-success">Submit</button>
</form>
</section>
</template>
<script>
export default {
    data(){
        return  {
            ReportData: new Form({
                patient_id:'', 
                appointment_id:'', 
                id: '',
                summary: '',
                findings: [],
                details: '', 
            }),
        }
    },
    mounted() {
        Fire.$on('reportDataFill', report =>{
            if (report.report != null ){
                this.ReportData.summary = report.report.summary;
                this.ReportData.details = report.report.details;
                this.ReportData.id = report.report.id;
                this.ReportData.findings = [];
                for (let i = 0; i < report.report.findings.length; i++) {this.ReportData.findings.push(report.report.findings[i].id);} 
            }
        });
        //Fire.$on('AfterCreation', ()=>{//axios.get("api/profile").then(({ data }) => (this.ReportData.fill(data)));});
    },
    methods:{
        createReportData(){
            this.$Progress.start();
            this.ReportData.appointment_id = this.report.id;
            this.ReportData.patient_id = this.patient.id;
            this.ReportData.post('/api/emr/radiologists')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('reportReload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Report has been created',
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
        updateReportData(){
            console.log("Tested");
            this.$Progress.start();
            this.ReportData.appointment_id = this.report.id;
            this.ReportData.patient_id = this.patient.id;
            this.ReportData.put('/api/emr/radiologists/'+ this.ReportData.id)
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('reportReload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Report has been updated',
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
        getProfilePic(){
            let photo = (this.ReportData.image.length >= 150) ? this.ReportData.image : "./"+this.ReportData.image;
            return photo;
            },
        updateProfilePic(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file['size'] < 2000000){
                reader.onloadend = (e) => {
                    this.ReportData.image = reader.result
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
    },
    props:{
        patient: Object,
        findings: Array,
        service: Object,
        editMode: Boolean,
        report: Object,
    }
}
</script>
