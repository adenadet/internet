<template>
<div>
<form>
    <alert-error :form="ApplicantData"></alert-error> 
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Nationality *</label>
                <select class="form-control" id="nationality_id" name="nationality_id" required v-model="ApplicantData.nationality_id" :class="{'is-invalid' : ApplicantData.errors.has('nationality_id') }">
                    <option value="">---Select Nationality---</option>
                    <option v-for="nation in nations" v-bind:key="nation.id" :value="nation.id" >{{nation.name}}</option>
               </select>
                <has-error :form="ApplicantData" field="nation"></has-error> 
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Passport Number</label>
                <input type="text" class="form-control" id="passport_no" name="passport_no" placeholder="other Name" v-model="ApplicantData.passport_no" :class="{'is-invalid' : ApplicantData.errors.has('passport_no') }"/>
                <has-error :form="ApplicantData" field="passport_no"></has-error> 
            </div>
        </div>
        <input type="hidden" class="form-control" id="user_id" name="user_id" v-model="ApplicantData.user_id" :class="{'is-invalid' : ApplicantData.errors.has('user_id') }"/>                
    </div>
    <button @click.prevent="updateApplicantData" type="submit" name="submit" class="submit btn btn-success">Submit</button>
</form>
</div>
</template>
<script>
export default {
    data(){
        return  {
            editMode: true, 
            ApplicantData: new Form({
                user_id: '',
                nationality_id: '',
                passport_no: '',
            }),
        }
    },
    mounted() {
        Fire.$on('ApplicantDataFill', patient =>{
            this.ApplicantData.fill(patient);
            console.log("Get Here");
        });
    },
    methods:{
        createUser(){

            },
        updateApplicantData(){
            this.$Progress.start();
            this.ApplicantData.user_id = this.user.id;
            this.ApplicantData.post('/api/ums/details')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Profile details has been updated',
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
        nations: Array,
        user: Object,
    }
}
</script>