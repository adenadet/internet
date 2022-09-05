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
        getProfilePic(){
            let photo = (this.ApplicantData.image.length >= 150) ? this.ApplicantData.image : "./"+this.ApplicantData.image;
            return photo;
            },
        updateProfilePic(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file['size'] < 2000000){
                reader.onloadend = (e) => {
                    this.ApplicantData.image = reader.result
                    }
                reader.readAsDataURL(file)
            }
            else{
                swal.fire({
                    type: 'error',
                    title: 'File is too large'
                })
            }
        }
    },
    props:{
        nations: Array,
    }
}
</script>