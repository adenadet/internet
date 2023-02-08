<template>
<section>
    <div class="row">
        <div class="col-sm-4">
            <img class="img-fluid" :src="(patient.image != null && patient != null) ? '/img/applicants/'+patient.image : '/img/profile/default.png'"/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>Last Name*</label>
                <div class="form-control" id="last_name" v-html="patient.last_name"></div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>First Name *</label>
                <div class="form-control" id="first_name" v-html="patient.first_name"></div> 
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Middle Name</label>
                <div class="form-control" id="middle_name" v-html="patient.middle_name"></div>
            </div>
        </div>  
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <label>Date of Birth</label>
            <div class="form-group">
                <div id="dob" class="form-control" v-html="patient.dob"></div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group"><label>Sex</label><div class="form-control" id="sex" v-html="patient.sex"></div></div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group"><label>Last Menstrual Period (Females only)</label><div class="form-control" id="lmp" v-html="patient.lmp"></div></div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Nationality</label>
                <select disabled class="form-control" id="nationality_id" name="nationality_id" v-model="patient.nationality_id">
                    <option value=''>---Select Nationality---</option>
                    <option v-for="nation in nations" v-bind:key="nation.id" :value="nation.id" >{{nation.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Passport Number</label><div class="form-control" id="passport_no" v-html="patient.passport_no"></div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group"><label>Visa Type</label><div class="form-control" id="visa_type" v-html="patient.visa_type"></div></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="form-group"><label>No of accompanying children less than 11 years</label><div class="form-control" id="accompanying_kids" v-html="patient.accompanying_kids"></div></div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group"><label>Phone Number</label><div class="form-control" id="phone" v-html="patient.phone"></div></div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group"><label>Alternate Phone</label><div class="form-control" id="alt_phone" v-html="patient.alt_phone"></div></div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group"><label>Email Address</label><div type="email" class="form-control" id="email" v-html="patient.email"></div></div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Address in Nigeria*</label>
                <div id="nigerian_address" v-html="patient.nigerian_address" style="min-height:200px; padding: 5px 10px; width: 100%; border: 1px solid #AAA;"></div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Address in the UK*</label>
                <div id="uk_address" name="uk_address" v-html="patient.uk_address" style="min-height:200px; padding: 5px 10px; width: 100%; border: 1px solid #AAA;"></div>
            </div>
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
    },
    props:{
        patient: Object,
        nations: Array,
    }
};
</script>