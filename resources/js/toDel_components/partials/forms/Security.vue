<template>
<div class="row clearfix">
    <div class="col-sm-12">
        <div class="card">
            <div class="header">
                <h2>Change Password</h2>
            </div>
            <div class="body">
<form @submit.prevent="updateProfile" class="col-md-8 col-md-offset-2">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label>Current Password*</label>
                <input type="text" class="form-control" id="old" name="old" placeholder="Current Password *" v-model="password.old" required>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>New Password</label>
                <input type="text" class="form-control" id="new" name="new" placeholder="New Password " v-model="password.new">
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="text" class="form-control" id="confirm" name="confirm" placeholder="Confirm New Password" v-model="password.confirm">
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
                password: new Form({
                    old: '', 
                    new:'', 
                    confirm:'', 
                }),
            }
        },
        methods:{
            updatePassword(){
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
                this.password.fill(user);
            },
        },
        mounted() {
                 
        },
        props: {},
    }
</script>