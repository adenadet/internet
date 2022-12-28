<template>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Update Basic Information</h2>
            </div>
            <div class="body">
<form @submit.prevent="updateNextOfKin">
    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">
                <label>First Name *</label>
                <input type="text" class="form-control" id="nok_name" name="nok_name" placeholder="Full Name *" v-model="nok.nok_name" required>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Relationship</label>
                <input type="text" class="form-control" id="relationship" name="relationship" placeholder="Other Name " v-model="nok.relationship">
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Get Address -->
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Phone Number</label>
                <input type="number" class="form-control" id="nok_phone" name="nok_phone" placeholder="Enter Phone Number *" v-model="nok.nok_phone" required>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Email Address</label>
                <input type="text" class="form-control" id="nok_email" name="nok_email" placeholder="Enter Email Address *" v-model="nok.nok_email">
            </div>
        </div>
    </div>
    <input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
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
                nok: new Form({
                    name: '', 
                    relationship:'', 
                    email:'', 
                    phone:'', 
                    user_id:'', 
                    id:'',  
                }),
            }
        },
        methods:{
            updateNextOfKin(){
                this.form.post('/api/coop/profile').then(response=>{
                    toast.fire({
                        icon: 'success',
                        title: 'Profile update was successful, an Admin will speak with you soon',
                    });
                this.form.reset();
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Profile update was not unsuccessful, try again later!',
                    })
                });
            },
            setValue(user){
                this.nok.fill(user);
            },
        },
        mounted() {
                 
        },
        props: {
            'next_of_kin': Object,
        },
    }
</script>