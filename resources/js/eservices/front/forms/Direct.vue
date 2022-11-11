<template>
<div class="card card-primary ">
    <div class="card-header bg-navy">Schedule An Appointment</div>
    <div class="card-body">
        <form>
            <alert-error :form="ApplicantData"></alert-error> 
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Last Name*</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name *" required v-model="ApplicantData.last_name" :class="{'is-invalid' : ApplicantData.errors.has('last_name') }" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>First Name *</label>
                        <input type="text" required class="form-control" id="first_name" name="first_name" placeholder="First Name *" v-model="ApplicantData.first_name" :class="{'is-invalid' : ApplicantData.errors.has('first_name') }">
                        <has-error :form="ApplicantData" field="first_name"></has-error> 
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="middle Name" v-model="ApplicantData.middle_name" :class="{'is-invalid' : ApplicantData.errors.has('middle_name') }"/>
                        <has-error :form="ApplicantData" field="middle_name"></has-error> 
                    </div>
                </div>  
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <label>Date of Birth</label>
                    <div class="form-group">
                        <input name="dob" id="dob" type="date" data-provide="datepicker" data-date-autoclose="true" class="form-control" placeholder="Birth Date" v-model="ApplicantData.dob" :class="{'is-invalid' : ApplicantData.errors.has('dob') }">
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label>Sex</label>
                        <select class="form-control" id="sex" name="sex" required v-model="ApplicantData.sex" :class="{'is-invalid' : ApplicantData.errors.has('sex') }">
                            <option value=''>---Select Sex---</option>
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label>Last Menstrual Period (Females only)</label>
                        <input type="date" class="form-control" id="lmp" name="lmp" placeholder="Enter Last Menstrual Period *" required v-model="ApplicantData.lmp" :class="{'is-invalid' : ApplicantData.errors.has('lmp') }" />
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label>Nationality</label>
                        <select class="form-control" id="nationality_id" name="nationality_id" v-model="ApplicantData.nationality_id" :class="{'is-invalid' : ApplicantData.errors.has('nationality_id') }">
                            <option value=''>---Select Nationality---</option>
                            <option v-for="nation in nations" v-bind:key="nation.id" :value="nation.id" >{{nation.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label>Passport Number</label>
                        <input type="text" class="form-control" id="passport_no" name="passport_no" placeholder="Enter Passport Number *" required v-model="ApplicantData.passport_no" :class="{'is-invalid' : ApplicantData.errors.has('passport_number') }" />
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label>Visa Type</label>
                        <input type="text" class="form-control" id="visa_type" name="visa_type" placeholder="Enter Visa Type *" required v-model="ApplicantData.visa_type" :class="{'is-invalid' : ApplicantData.errors.has('visa_type') }" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label>No of accompanying children less than 11 years</label>
                        <input type="number" class="form-control" id="accompanying_kids" name="accompanying_kids" placeholder="Enter Number of Accompanying Kids *" required v-model="ApplicantData.accompanying_kids" :class="{'is-invalid' : ApplicantData.errors.has('accompanying_kids') }">
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label>Profile Picture</label>
                    <div class="form-group">
                        <input type="file" class="form-control" placeholder="Birth Date" @change="updateProfilePic">
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number *" required v-model="ApplicantData.phone" :class="{'is-invalid' : ApplicantData.errors.has('phone') }">
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label>Alternate Phone</label>
                        <input type="text" class="form-control" id="alt_phone" name="alt_phone" placeholder="Alternate Phone Number" v-model="ApplicantData.alt_phone" :class="{'is-invalid' : ApplicantData.errors.has('alt_phone') }">
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address *" required v-model="ApplicantData.email" :class="{'is-invalid' : ApplicantData.errors.has('email') }">
                    </div>
                </div>
                <input type="hidden" name="id" id="id" v-model="ApplicantData.id">
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label>Address in Nigeria*</label>
                        <wysiwyg rows="5" id="nigerian_address" name="nigerian_address" placeholder="Enter Address *" required v-model="ApplicantData.nigerian_address" :class="{'is-invalid' : ApplicantData.errors.has('nigerian_address') }"></wysiwyg>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label>Address in the UK*</label>
                        <wysiwyg rows="5" id="uk_address" name="uk_address" placeholder="Enter Address *" required v-model="ApplicantData.uk_address" :class="{'is-invalid' : ApplicantData.errors.has('uk_address') }"></wysiwyg>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label>Service</label>
                        <select class="form-control" id="service_id" name="service_id" v-model="ApplicantData.service_id" required>
                            <option value="">--Select Service--</option>
                            <option v-for="service in services" :key="service.id" :value="service.id">{{service.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label>Date</label>
                        <input class="form-control" type="date" name="date" id="date" v-model="ApplicantData.date" @change="searchSchedule()"/>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label>Schedule</label>
                        <select class="form-control" id="schedule" name="schedule" v-model="ApplicantData.schedule" required>
                            <option value=''>--Select Available Time--</option>
                            <option v-for="(schedule, index) in schedules" :key="index" :value="schedule.schedule">{{schedule.schedule}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label>Payment Type</label>
                        <select class="form-control" id="payment_method" name="payment_method" v-model="ApplicantData.payment_method" required>
                            <option value="">--Select Method--</option>
                            <option value="paystack">Card</option>
                            <option value="transfer">Transfer</option>
                            <option value="cash">On Site</option>
                        </select>
                    </div>
                </div>
            </div>
            <button @click.prevent="editMode ? updateApplicantData() : createApplicant()" type="submit" name="submit" class="submit btn btn-success">Submit</button>
        </form>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return  {
            nations: [],
            schedules: [],
            services: [], 
            ApplicantData: new Form({
                first_name: '', 
                middle_name:'', 
                last_name:'', 
                dob: '',
                sex:'',
                lmp:'', 
                nationality_id: '',
                alt_phone:'', 
                phone:'', 
                email:'',
                id:'', 
                image:'', 
                nigerian_address:'', 
                uk_address:'',
                accompanying_kids: 0,
                visa_type: '',
                passport_number: '',
                schedule: "",
                service_id: "",
                date: "",
                payment_method:"",
            }),
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('ApplicantDataFill', user =>{
            this.ApplicantData.fill(user);
        });
        Fire.$on('AfterCreation', ()=>{
            
        });
    },
    methods:{
        createApplicant(){
            this.$Progress.start();
            this.ApplicantData.post('/api/scheduler')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('refreshAppointment', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Profile details has been created',
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
        updateApplicantData(){
            console.log("Tested");
            this.$Progress.start();
            this.ApplicantData.put('/api/scheduler/'+this.ApplicantData.id)
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('refreshAppointment', response);
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
        getInitials(){
            axios.get('/api/scheduler')
            .then(response => {this.refreshScheduler(response)})
            .catch(() => {
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Your appointments did not loaded successfully',})
            });
        },
        getProfilePic(){
            let photo = (this.ApplicantData.image.length >= 150) ? this.ApplicantData.image : "./"+this.ApplicantData.image;
            return photo;
        },
        refreshScheduler(response){
            this.services = response.data.services;
            this.nations = response.data.nations;
        },
        searchSchedule(){
            if (this.ApplicantData.service_id == ""){
                alert("Please select the service type");
                this.ApplicantData.date = "";
                return;
            }
            axios.get('/api/schedules?service_id='+this.ApplicantData.service_id+'&date='+this.ApplicantData.date)
            .then(response =>{
                this.schedules = response.data.schedules;
                this.$Progress.finish();
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Schedules not loaded successfully',
                })
            });
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
                Swal.fire({
                    type: 'error',
                    title: 'File is too large'
                })
            }
        },
        
    },
    props:{
    }
}
</script>