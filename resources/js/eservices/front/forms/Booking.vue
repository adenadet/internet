<template>
<div>
<form>
    <alert-error :form="AppointmentData"></alert-error> 
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label>First Name *</label>
                <input type="text" required class="form-control" id="first_name" name="first_name" placeholder="First Name *" v-model="AppointmentData.first_name" :class="{'is-invalid' : AppointmentData.errors.has('first_name') }">
                <has-error :form="AppointmentData" field="first_name"></has-error> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Service *</label>
                <select class="form-control" id="service_id" name="service_id" placeholder="Enter State / County *" required v-model="AppointmentData.service_id" :class="{'is-invalid' : AppointmentData.errors.has('service_id') }">
                    <option value="">--Select Service--</option>
                    <option v-for="service in services" v-bind:key="service.id" :value="service.id" >{{service.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Date</label>
                <input type="text" class="form-control" id="street2" name="street2" placeholder="Enter Street Desc" v-model="AppointmentData.street2" :class="{'is-invalid' : AppointmentData.errors.has('street2') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>City*</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Enter City *" v-model="AppointmentData.city" :class="{'is-invalid' : AppointmentData.errors.has('city') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>State</label>
                <select class="form-control" id="state_id" name="state_id" placeholder="Enter State / County *" required v-model="AppointmentData.state_id" :class="{'is-invalid' : AppointmentData.errors.has('state_id') }">
                    <option value="">--Select State--</option>
                    <option v-for="state in states" v-bind:key="state.id" :value="state.id" >{{state.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>LGA</label>
                <select class="form-control" id="area_id" name="area_id" required v-model="AppointmentData.area_id" :class="{'is-invalid' : AppointmentData.errors.has('area_id') }">
                    <option value="">--Select area--</option>
                    <option v-for="area in areas" v-bind:key="area.id" :value="area.id" >{{area.name}}</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Phone Number</label>
                <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number *" required v-model="AppointmentData.phone" :class="{'is-invalid' : AppointmentData.errors.has('phone') }">
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Alternate Phone</label>
                <input type="text" class="form-control" id="alt_phone" name="alt_phone" placeholder="Alternate Phone Number" v-model="AppointmentData.alt_phone" :class="{'is-invalid' : AppointmentData.errors.has('alt_phone') }">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Email Address</label>
                <input :disabled= "editMode ? 'disabled' : 'false'" type="text" class="form-control" id="email" name="email" placeholder="Enter Email Address *" required v-model="AppointmentData.email" :class="{'is-invalid' : AppointmentData.errors.has('email') }">
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Unique ID</label>
                <input :disabled= "editMode ? 'disabled' : 'false'" type="text" class="form-control" id="unique_id" name="unique_id" placeholder="Enter unique_id Address *" required v-model="AppointmentData.unique_id" :class="{'is-invalid' : AppointmentData.errors.has('unique_id') }">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Sex</label>
                <select class="form-control" id="sex" name="sex" required v-model="AppointmentData.sex" :class="{'is-invalid' : AppointmentData.errors.has('sex') }">
                    <option value="">---Select Sex---</option>
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <label>Date of Birth</label>
            <div class="form-group">
                <input name="dob" id="dob" type="date" data-provide="datepicker" data-date-autoclose="true" class="form-control" placeholder="Birth Date" v-model="AppointmentData.dob" :class="{'is-invalid' : AppointmentData.errors.has('dob') }">
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <label>Profile Picture</label>
            <div class="form-group">
                <input type="file" class="form-control" placeholder="Birth Date" @change="updateProfilePic">
            </div>
        </div>
        <input type="hidden" name="id" id="id" v-model="AppointmentData.id">
    </div>
    <button @click.prevent="updateAppointmentData" type="submit" name="submit" class="submit btn btn-success">Submit</button>
</form>
</div>
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