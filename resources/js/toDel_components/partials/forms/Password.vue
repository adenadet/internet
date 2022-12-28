<template>
    <form id="password_form">
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <div class="form-group">
                    <label>Current Password*</label>
                    <input type="password" class="form-control" id="opw" name="opw" placeholder="Enter Current Password" v-model="pwForm.opw" required>
                </div>
            </div>
            <div class="col-md-9 col-sm-12">
                <div class="form-group">
                    <label>New Password*</label>
                    <input type="password" class="form-control" id="npw" name="npw" placeholder="New Password"  v-model="pwForm.npw" required>
                </div>
            </div>
            <div class="col-md-9 col-sm-12">
                <div class="form-group">
                    <label>Confirm New Password*</label>
                    <input type="password" class="form-control" id="cpw" name="cpw" placeholder="Re-enter New Password"  v-model="pwForm.npw" required>
                </div>
            </div>
        </div>
        <button @click.prevent="changePassword" type="submit" name="submit" class="submit btn btn-success">Submit </button>
    </form>
</template>
<script>
    export default {
        data(){
            return {
                pwForm: new Form({
                    opw: '',
                    npw: '',
                    cpw: '',
                }),
            }
        },
        methods:{
            changePassword(){
                this.$Progress.start();
                this.pwForm.post('/api/hrms/nok')
                .then(response =>{
                    this.$Progress.finish();
                    Swal.fire({
                        icon: 'success',
                        title: 'The password has been successfully changed',
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
        mounted() {},
        props:{},
    }
</script>