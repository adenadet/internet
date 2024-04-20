<template>
<section class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <form>
                <alert-error :form="CuracelData"></alert-error> 
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">New Claims Form</h3>
                    </div>
                    <div class="card-body pt-0" style="overflow-y: scroll;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">HMO</label>
                                    <select class="form-control" id="hmo_code" name="hmo_code"  v-model="CuracelData.hmo_code">
                                        <option value="">--Select HMO to receive payment--</option>
                                        <option v-for="hmo in hmos" :value="hmo.id">{{ hmo.name }}</option>
                                    </select>
                                </div>        
                            </div>
                            <div>
                                <div class="btn btn-group">
                                    <button class="btn btn-sm btn-default" type="button"  @click="addNew(1)"><i class="fa fa-plus"></i></button>
                                    <button class="btn btn-sm btn-default" type="button" @click="addNew(10)"><i class="fa fa-plus">10</i></button>
                                </div>
                                <vue-excel-editor v-model="CuracelData.jsonData"  class="col-md-12">
                                    <vue-excel-column field="patient" label="Patient" type="string"  />
                                    <vue-excel-column field="snh_id" label="EMR No" type="string"  />
                                    <vue-excel-column field="enrollee_id" label="Enroll ID" type="string" />
                                    <vue-excel-column field="encounter_date" label="Date" type="date" />
                                    <vue-excel-column field="diagnosis_full" label="Diagnosis" type="string" />
                                    <vue-excel-column field="icd_code" label="ICD 10 Code" type="string" />
                                    <vue-excel-column field="authorization" label="Authorization" type="string" />
                                    <vue-excel-column field="treatment" label="Treatment" type="string" />
                                    <vue-excel-column field="unit_price" label="Unit Price" type="number" />
                                    <vue-excel-column field="unit" label="Unit" type="number" />
                                    <vue-excel-column field="amount_due" label="Amount Due" type="number" />
                                    <vue-excel-column field="claims" label="Claims" type="number" />
                                </vue-excel-editor>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data() {
        return {
            row: {patient: '', snh_id: '', enrolllee_id: '', encounter_date:'', diagnosis_full: '', encounter_date: '', diagnosis_full: '', icd_code: '', authorization: '', treatment: '', unit_price: '', unit: '', amount_due: '', claims: ''},
            CuracelData: new Form({
                hmo_id: '',
                jsonData: []
            }),
            hmos: [],
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('refreshReport', response => {
            this.refreshReport(response);
        });
    },
    methods: {
        addNew(num){
            for (let i = 0; i < num; i++ ){
                this.CuracelData.jsonData.push(this.row); 
                console.log(i);   
            }
        },
        getInitials(){
            axios.get('/api/claims/curacel/initials').then(response =>{
                this.$Progress.finish();
                this.reloadPage(response);
                toast.fire({
                    icon: 'success',
                    title: 'Profile loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Profile not loaded successfully',
                })
            });
        },
        reloadPage(response){
            if (this.CuracelData.jsonData == [] || this.CuracelData.jsonData == null){
                this.addNew(50);
            }
        },
        searchAppointment(){
            this.$Progress.start();
            this.reportData.post('/api/emr/admin/summary_report')
            .then(response => {
                this.appointments = response.data.appointments;
                this.reports = response.data.reports;
                this.report_type = response.data.report_type;
                this.$Progress.finish();
            })
            .close(()=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please try again later!'
                    });
                this.$Progress.fail();
            });
        }
    },
}
</script>