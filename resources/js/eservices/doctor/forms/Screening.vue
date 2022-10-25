<template>
<section>
    <div class="card">
        <h3>Annex G: United Kingdom pre-entry TB screening programme medical record Symptom screen, history of contact with TB and discretionary medical examination (all applicants)</h3>
        <p>Symptom screen</p>
        <div class="card-body">
            <alert-error :form="AppointmentData"></alert-error> 
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Has the applicant (or their child) had any of the following symptoms in the last 3 months *</label>
                        <select required class="form-control" id="symptoms" name="symptoms" placeholder="First Name *" v-model="AppointmentData.symptoms" :class="{'is-invalid' : AppointmentData.errors.has('symptoms') }">
                            <option value="cough">Cough</option>
                            <option value="fever">Fever</option>
                            <option value="haemoptysis">Haemoptysis</option>
                            <option value="night sweats">Night Sweats</option>
                            <option value="weight loss">Weight Loss</option>
                            <option value="none">None</option>
                        </select>
                        <has-error :form="AppointmentData" field="symptoms"></has-error> 
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>For Children only; is there any history of the following:</label>
                        <select class="form-control" id="kid_symptoms" name="kid_symptoms" placeholder="Enter State / County *" required v-model="AppointmentData.kid_symptoms" :class="{'is-invalid' : AppointmentData.errors.has('kid_symptoms') }">
                            <option value="">--Select Service--</option>
                            <option value="chronic respiratory disease" >Any chronic respiratory disease, such as Cystic fibrosis</option>
                            <option value="thoraic surgery" >previously thoraic surgery</option>
                            <option value="cyanosis" >cyanosis</option>
                            <option value="respiratory insufficiency" >respiratory insufficiency that limits activity</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>For All Applicants</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="applicants[]" id="applicants[]">
                        <label class="form-check-label">Is there any history of previous TB?</label>
                    </div>
                </div> 
                <div class="col-sm-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="applicants[]" id="applicants[]">
                        <label class="form-check-label">has anyone in the household been diagnosed with TB in the last 2 years?</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="applicants[]" id="applicants[]">
                        <label class="form-check-label">Is there any history of recent contact with a case of active pulmonary TB (shared the same enclosed air space or household or other enclosed environmentfor a prolonged period for days or weeks)></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data(){
        return  {
            editMode: true, 
            AppointmentData: new Form({
                first_name: '', 
                other_name:'', 
                last_name:'', 
                email:'', 
                unique_id: '',
                password:'', 
                street:'', 
                street2:'', 
                city:'', 
                area_id:'', 
                state_id:'', 
                phone:'', 
                alt_phone:'', 
                sex:'', 
                image:'', 
                id:'', 
                dob:'', 
                roles:'',
            }),
        }
    },
    mounted() {
        Fire.$on('AppointmentDataFill', user =>{
            this.AppointmentData.fill(user);
        });
        Fire.$on('AfterCreation', ()=>{
            //axios.get("api/profile").then(({ data }) => (this.AppointmentData.fill(data)));
        });
    },
    methods:{
        createUser(){

            },
        updateAppointmentData(){
            this.$Progress.start();
            this.AppointmentData.post('/api/ums/bios')
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
            let photo = (this.AppointmentData.image.length >= 150) ? this.AppointmentData.image : "./"+this.AppointmentData.image;
            return photo;
            },
        updateProfilePic(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file['size'] < 2000000){
                reader.onloadend = (e) => {
                    this.AppointmentData.image = reader.result
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
        areas: Array,
        branches: Array, 
        states: Array,
        user: Object,
        services: Array,
    }
}
</script>