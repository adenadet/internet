<template>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2 v-show="editMode">Update Guarantor</h2>
                <h2 v-show="!editMode">Add New Guarantor</h2>
            </div>
            <div class="body">
<form @submit.prevent="editMode ? updateGuarantee() : createGuarantee() ">    
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
            <label>Loan</label>
                <input type="hidden" id="loan_id" name="loan_id" v-model="form.loan_id">
                <input class="form-control" type="text" :value="guarantee.loan ? guarantee.loan.name+' by '+guarantee.requested_by.first_name+' '+guarantee.requested_by.last_name: ''" disabled />
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
            <label>Guarantor</label>
                <select class="form-control" id="guarantor_id" name="guarantor_id" v-model="form.guarantor_id">
                    <option value="">---Select Guarantor---</option>
                    <option v-for="user in users" :key="user.id" :value="user.id">{{user.unique_id}} | {{user.first_name}} {{user.middle_name}} {{user.last_name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" rows=5 id="description" name="description" placeholder="Description" v-model="form.description"></textarea>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
        <input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
        </div>
    </div>
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
                accounts:{},
                editMode:false,
                form: new Form({
                    id:'',
                    loan_id:'',
                    guarantor_id:'',
                    type: 'guarantor'
                }),
                savings:{},
            }
        },
        methods:{
            createGuarantee(){
                this.form.post('/api/coop/guarantors').then(response=>{
                    Swal.fire({
                        icon: 'success',
                        title: 'Guarantor was successfully added!',
                    });
                })
                .catch(()=>{
                    this.$Progress.fail();
                    Swal.fire({
                        icon: 'error',
                        title: 'Guarantor was not added try again later!',
                    })
                });
            },
            updateGuarantee(){
                this.form.put('/api/coop/guarantors/'+this.form.id)
                .then(response=>{
                    this.form.reset();
                    Fire.$emit('Refresh')
                    Swal.fire({
                        icon: 'success',
                        title: 'Guarantor was successfully updated!',
                    });
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Guarantor was not updated try again later!',
                    })
                });
            },
        },
        mounted() {
            Fire.$on('editGuarantee', guarantee =>{
                this.editMode = true;
                console.log(guarantee);
                this.form.fill(guarantee);
                this.form.type = 'guarantee';
            }); 
        },
        props:{
            'guarantee': Object,
            'users': Array,
            },
    }
</script>