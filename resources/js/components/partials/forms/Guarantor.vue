<template>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Update Guarantee Details</h2>
            </div>
            <div class="body">
<form @submit.prevent="editMode ? updateGuarantor() : createGuarantor() ">    
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
            <label>Loan</label>
                <input type="hidden" id="saving_id" name="loan_id" v-model="form.loan_id">
                <input class="form-control" type="text" :value="guarantor.loan? guarantor.loan.name+' by '+guarantor.requested_by.first_name+' '+guarantor.requested_by.middle_name+' '+guarantor.requested_by.last_name+' ' : ''" disabled />
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
            <label>Maximum You can Guarantee</label>
            <input class="form-control" type="text" :value="saving ? ((saving.balance / 2) - saving.fixed).toFixed(2) : 0.00" disabled />
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
            <label>Guarantee Sum</label>
            <input type="number" class="form-control" name="amount" id="amount" placeholder="Enter Amount Paid" required v-model="form.amount" :max="saving ? ((saving.balance / 2) - saving.fixed) : 0">
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
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
                    amount: '',
                    type: 'guarantor',
                }),
                savings:{},
            }
        },
        methods:{
            createGuarantor(){
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
            editGuarantor(guarantor){
                this.editMode = true;
                this.form.fill(guarantor);
            },
            updateGuarantor(){
                if(this.form.amount <= 0){
                    Swal.fire({
                        icon: 'error',
                        title: 'You can not guarantee &#x20a6; 0 or less than &#x20a6; 0',
                    })
                }
                else{
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
                            Swal.fire({
                                icon: 'error',
                                title: 'Guarantor was not updated try again later!',
                            })
                        });
                }
            },
        },
        mounted() {
            Fire.$on('editGuarantor', guarantor =>{
                this.editMode = true;
                this.form.fill(guarantor);
                this.form.type = 'guarantor';
            }); 
        },
        props:{
            'guarantor': Object,
            'saving': Object,
        },
    }
</script>