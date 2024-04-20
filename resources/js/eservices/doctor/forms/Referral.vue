<template>
<section class="row">
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-4 col-form-label">Template</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="referral_template" name="referral_template" v-model="referral_template" @change="loadReferral()">
                            <option value="">--Select Referral Template to Use--</option>
                            <option v-for="(r_template, index) in templates" :value="index">{{ r_template.name }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    <form>
        <alert-error :form="ReferralData"></alert-error> 
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Patient</label>
                    <div class="form-control">{{ appointment.patient | fullName }}</div>
                    <has-error :form="ReferralData" field="first_name"></has-error> 
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Service</label>
                    <div class="form-control" id="middle_name" name="middle_name" placeholder="middle Name" v-html="appointment.service != null ? appointment.service.name : 'No service selected'"></div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label>Referral Details*</label>
                    <wysiwyg id="details" name="details" placeholder="Details *" required v-model="ReferralData.details" :class="{'is-invalid' : ReferralData.errors.has('details') }" />
                </div>
            </div>
        </div>
        <button @click.prevent="editMode ? updateReferralData() : createReferralData()" type="submit" name="submit" class="submit btn btn-success">Submit</button>
    </form>
</div>
</section>
</template>
<script>
export default {
    data(){
        return  {
            ReferralData: new Form({
                appointment_id:'', 
                id: '',
                details: '', 
            }),
            referral_template: '',
            templates: [],
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('ReferralDataFill', report =>{
            if (report != null ){this.ReferralData.fill(report);}
        });
    },
    methods:{
        createReferralData(){
            this.$Progress.start();
            this.ReferralData.appointment_id = this.appointment.id;
            this.ReferralData.post('/api/emr/referrals')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('reportReload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Referral has been created',
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
        getInitials(){
            axios.get('/api/emr/referrals/initials')
            .then(response => {
                this.refreshReferrals(response)
            })
            .catch(() => {
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Your consultations did not loaded successfully',
                })
            });
        },
        loadReferral(){
            this.ReferralData.details = this.templates[this.referral_template].content;
        },
        refreshReferrals(response){
            this.templates = response.data.templates;
        },
        updateReferralData(){
            console.log("Tested");
            this.$Progress.start();
            this.ReferralData.put('/api/emr/radiologists/'+ this.ReferralData.id)
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
    },
    props:{
        appointment: Object,
        editMode: Boolean,
    }
}
</script>