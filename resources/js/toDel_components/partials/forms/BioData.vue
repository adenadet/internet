<template>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="body">
<form @submit.prevent="editMode ? updateProfile() : (outside ? createContactOpen() : createContact()) ">
    <alert-error :form="BioData"></alert-error> 
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>First Name *</label>
                <input type="text" required class="form-control" id="first_name" name="first_name" placeholder="First Name *" v-model="BioData.first_name" :class="{'is-invalid' : BioData.errors.has('first_name') }">
                <has-error :form="BioData" field="first_name"></has-error> 
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Middle Name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="middle Name" v-model="BioData.middle_name" :class="{'is-invalid' : BioData.errors.has('middle_name') }"/>
                <has-error :form="BioData" field="middle_name"></has-error> 
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Last Name*</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name *" required v-model="BioData.last_name" :class="{'is-invalid' : BioData.errors.has('last_name') }" />
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Get Address -->
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Address*</label>
                <input type="text" class="form-control" id="street" name="street" placeholder="Enter Address *" required v-model="BioData.street" :class="{'is-invalid' : BioData.errors.has('street') }" />
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Address2</label>
                <input type="text" class="form-control" id="street2" name="street2" placeholder="Enter Street Desc" v-model="BioData.street2" :class="{'is-invalid' : BioData.errors.has('street2') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>City*</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Enter City *" v-model="BioData.city" :class="{'is-invalid' : BioData.errors.has('city') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>State</label>
                <select class="form-control" id="state_id" name="state_id" placeholder="Enter State / County *" required v-model="BioData.state_id" :class="{'is-invalid' : BioData.errors.has('state_id') }">
                    <option value="">--Select State--</option>
                    <option v-for="state in states" v-bind:key="state.id" :value="state.id" >{{state.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>LGA</label>
                <select class="form-control" id="area_id" name="area_id" required v-model="BioData.area_id" :class="{'is-invalid' : BioData.errors.has('area_id') }">
                    <option value="">--Select area--</option>
                    <option v-for="area in areas" v-bind:key="area.id" :value="area.id" >{{area.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Phone Number</label>
                <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number *" required v-model="BioData.phone" :class="{'is-invalid' : BioData.errors.has('phone') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Alternate Phone</label>
                <input type="text" class="form-control" id="alt_phone" name="alt_phone" placeholder="Alternate Phone Number" v-model="BioData.alt_phone" :class="{'is-invalid' : BioData.errors.has('alt_phone') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Personal Email Address</label>
                <input type="email" class="form-control" id="personal_email" name="personal_email" placeholder="Enter Email Address *" required v-model="BioData.personal_email" :class="{'is-invalid' : BioData.errors.has('personal_email') }">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Email Address</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email Address *" required v-model="BioData.email" :class="{'is-invalid' : BioData.errors.has('email') }">
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Unique ID</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email Address *" required v-model="BioData.email" :class="{'is-invalid' : BioData.errors.has('email') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Department</label>
                <select class="form-control" id="department_id" name="department_id" v-model="BioData.department_id" :class="{'is-invalid' : BioData.errors.has('branch_id') }">
                    <option value="">---Select Department---</option>
                    <option v-for="department in departments" v-bind:key="department.id" :value="department.id" >{{department.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Branch</label>
                <select class="form-control" id="branch_id" name="branch_id" v-model="BioData.branch_id" :class="{'is-invalid' : BioData.errors.has('branch_id') }">
                    <option value="">---Select Branch---</option>
                    <option v-for="branch in branches" v-bind:key="branch.id" :value="branch.id" >{{branch.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Sex</label>
                <select class="form-control" id="sex" name="sex" required v-model="BioData.sex" :class="{'is-invalid' : BioData.errors.has('sex') }">
                    <option value="">---Select Sex---</option>
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <label>Date of Birth</label>
            <div class="form-group">
                <input name="dob" id="dob" type="date" data-provide="datepicker" data-date-autoclose="true" class="form-control" placeholder="Birth Date" v-model="BioData.dob" :class="{'is-invalid' : BioData.errors.has('dob') }">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <label>Profile Picture</label>
            <div class="form-group">
                <input type="file" class="form-control" placeholder="Birth Date" @change="updateProfilePic">
            </div>
        </div>
        <input type="hidden" name="id" id="id" v-model="BioData.id">
        
    </div>
    <button @click.prevent="updateBioData" type="submit" name="submit" class="submit btn btn-success">Submit</button>
</form>
            </div>
        </div>
    </div>
</div>
</template>
<script>
    export default {
        data(){
            return {
                BioData: new Form({
                    first_name: '', 
                    middle_name:'', 
                    last_name:'', 
                    email:'',
                    personal_email: '', 
                    password:'', 
                    street:'', 
                    street2:'', 
                    city:'', 
                    area_id:'', 
                    state_id:'', 
                    phone:'', 
                    alt_phone:'', 
                    branch_id:'', 
                    department_id:'', 
                    sex:'', 
                    image:'', 
                    id:'', 
                    dob:'', 
                    roles:'',
                }),
            }
        },
        methods:{
            createContactOpen(){
                this.BioData.post('/api/member').then(response=>{
                    Swal.fire({
                        icon: 'success',
                        title: 'You have been successfully created. <br/>Your Unique ID is :'+response.data.user.unique_id
                        +' and Password is '+ response.data.password+',<br/> A SMS has been sent with User ID and Password also!',
                    });
                    this.BioData.reset();
                })
                .catch(()=>{
                    this.$Progress.fail();
                    Swal.fire({
                        icon: 'error',
                        title: 'Your form was not sent try again later!',
                    });
                });
            },
            createContact(){
                this.BioData.post('/api/member').then(response=>{
                    console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'You have been successfully created. <br/>Your Unique ID is :'+
                        +' and Password is '+ +',<br/> A SMS has been sent with User ID and Password!',
                    });
                    this.bio.reset();
                })
                .catch(()=>{
                    this.$Progress.fail();
                    Swal.fire({
                        icon: 'error',
                        title: 'Your form was not sent try again later!',
                    });
                });
            },
            updateProfile(){
                this.form.put('/api/coop/profile').then(() =>{
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                    });
                
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Profile update was not unsuccessful, try again later!',
                    })
                });
            },
            updateProfilePic(e){
                let file = e.target.files[0];
                let reader = new FileReader();
                reader.onloadend - function(){this.bio.image = reader.result;}
                reader.readAsDataURL(file);
            },
            setValue(user){
                this.bio.fill(user);
            },
        },
        mounted() {
            Fire.$on('BioDataFill', user =>{
                this.BioData.fill(user);
            });     
        },
        props: {
            'areas': Array,
            'branches': Array,
            'departments': Array,
            'states': Array,
            'user': Object,
            'outside': Boolean,
            'editMode': Boolean,
        },
    }
</script>