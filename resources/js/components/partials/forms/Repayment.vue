
<template>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2>{{editMode? 'Update Repayment' : 'Add New Repayment'}}</h2>
                </div>
                <div class="body">
                    <div class="row clearfix">
<form @submit.prevent="editMode? updateRepayment() : createRepayment()">    
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="form-group">
            <label>Loan:</label>
                <select class="form-control" id="loan_id" name="loan_id" v-model="form.loan_id">
                    <option value="">---Select Loan---</option>
                    <option v-for="loan in loans" :key="loan.id" :value="loan.id">{{loan.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-3 col-sm-6" id="bank_mode">
            <div class="form-group">
            <label>Account</label>
                <select class="form-control" id="bank_id" name="bank_id" v-model="form.bank_id">
                    <option value="">---Select Account---</option>
                    <option v-for="account in accounts" :key="account.id" :value="account.id">{{account.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="form-group">
            <label>Amount</label>
            <input type="number" class="form-control" name="amount" id="amount" placeholder="Enter Amount Paid" required v-model="form.amount">
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="form-group">
            <label>Date</label>
            <input type="date" class="form-control" id="payment_date" name="payment_date" placeholder="Enter Payment Date" required v-model="form.payment_date">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" rows=5 id="description" name="description" placeholder="Description"  v-model="form.description"></textarea>
            </div>
        </div>
    </div>
    <input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
</form>
                    </div>
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
                    id: '',
                    loan_id:'',
                    bank_id: '',
                    payment_date:'',
                    amount:'',
                    description:'',                    
                }),
                loans:{},
            }
        },
        methods:{
            createRepayment(){
                this.form.post('/api/coop/repayments').then(response=>{
                    toast.fire({
                        icon: 'success',
                        title: 'Repayment was successfully added!',
                    });
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Repayment was not added, try again later!',
                    })
                });
            },
            editRepayment(repayment){
                this.editMode = true;
                this.form.fill(repayment);
                /*
                this.form.id = repayment.id;
                this.form.loan_id = repayment.loan_id;
                this.form.bank_id = repayment.bank_id;
                this.form.payment_date = repayment.payment_date;
                this.form.amount = repayment.amount;
                this.form.description = repayment.description;*/
            },
            getAllInitials(){
                this.$Progress.start();
                axios.get('/api/coop/repayments/initials').then(response =>{
                    this.accounts = response.data.accounts;
                    this.loans = response.data.loans;
                    this.$Progress.finish();
                    toast.fire({
                        icon: 'success',
                        title: 'Repayment Form loaded successfully',
                    });
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Repayment Form not loaded successfully',
                    })
                });
            },
            updateRepayment(){
                this.form.put('/api/coop/repayments/'+this.form.id)
                .then(response=>{
                    this.form.reset();
                    Fire.$emit('Refresh')
                    Swal.fire({
                        icon: 'success',
                        title: 'Repayment was successfully updated!',
                    });
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Repayment was not updated try again later!',
                    })
                });
            },
        },
        mounted() {
            this.getAllInitials();
            Fire.$on('editRepayment', repayment =>{
                this.editRepayment(repayment);
            });
        }
    }
</script>