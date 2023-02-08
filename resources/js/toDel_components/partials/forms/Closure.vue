<template>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Apply For Closure</h2>
            </div>
            <div class="body">
<form @submit.prevent="createWithdrawal">
<div class="row">
    <div class="col-md-4 col-sm-12">
        <div class="form-group">
        <label>Savings:</label>
        <select class="form-control" id="saving_id" name="saving_id" disabled v-model="form.saving_id" multiple="multiple" required>
            <option value="">--Select Savings Account--</option>
            <option v-for="saving in savings" :key="saving.id" :value="saving.id" selected="selected">{{saving.name}}  (&#x20a6; {{(saving.balance).toFixed(2)}})</option>
        </select>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="form-group">
        <label>Loans:</label>
        <select class="form-control" id="loan_id" name="loan_id" disabled v-model="form.loan_id" multiple="multiple" required>
            <option value="">--Select Loans Account--</option>
            <option v-for="loan in loans" :key="loan.id" :value="loan.id" selected="selected">{{loan.name}}  (&#x20a6; {{(loan.payable - loan.total_paid).toFixed(2)}})</option>
        </select>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="form-group">
        <label>Amount</label>
        <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount" v-model="form.amount" disabled required>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="form-group">
        <label>Pay To</label>
        <select class="form-control" id="bank_id" name="bank_id" v-model="form.bank_id" required>
            <option value="">--Select Savings Account--</option>
            <option v-for="all_bank in all_banks" :key="all_bank.id" :value="all_bank.id">{{all_bank.bank_name}}</option>
        </select>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="form-group">
        <label>Account Name</label>
        <input type="text" class="form-control" id="acct_name" name="acct_name" placeholder="Account Name" v-model="form.acct_name" required>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="form-group">
        <label>Account Number</label>
        <input type="text" class="form-control" id="acct_number" name="acct_number" placeholder="Account Number" v-model="form.acct_number" required>
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
                all_banks:{},
                form: new Form({
                    bank_id: '',
                    amount:'',
                    description:'',
                    loan_id:[],                    
                    saving_id:[],                    
                }),
                loans:{},
                savings:{},
            }
        },
        methods:{
            createWithdrawal(){
            if(this.form.amount <= 0){
                Swal.fire({
                        icon: 'error',
                        title: 'Insufficient Balance for Closure, kindly pay up and retry!',
                    });
            }
            else{
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You would lose your Cooperator ID and other cooperator benefits!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    })
                    .then((result) => {
                    if(result.value){
                        this.form.post('/api/coop/closures').then(response=>{
                            toast.fire({
                            icon: 'success',
                            title: 'Closure Request was successful, an Admin will speak with you soon',
                            });
                        })
                    .catch(()=>{
                            this.$Progress.fail();
                            toast.fire({
                                icon: 'error',
                                title: 'Closure Request was not submited try again later!',
                                })
                            });
                        }
                    });
                }    
            },
            getAllInitials(){
                axios.get('/api/coop/closures/initials').then(response =>{
                    this.all_banks = response.data.all_banks;
                    this.loans = response.data.loans;
                    this.savings = response.data.savings;
                    let saving_accts= [];
                    let loan_accts = [];
                    let savings_bal =  0.00; 
                    let loans_bal = 0.00;
                    for (let i = 0; i < this.savings.length; i++) {
                        saving_accts.push(this.savings[i].id);
                        savings_bal += (this.savings[i].balance - this.savings[i].fixed);
                        }
                    console.log('Savings Bal: '+savings_bal);
                    for (let i = 0; i < this.loans.length; i++) {
                        loan_accts.push(this.loans[i].id);
                        loans_bal += (this.loans[i].payable - this.loans[i].total_paid);
                        }
                    console.log('Loans Bal: '+loans_bal);
                    this.form.saving_id = saving_accts;
                    this.form.loan_id = loan_accts;
                    this.form.amount = (savings_bal - loans_bal).toFixed(2);
                    toast.fire({
                        icon: 'success',
                        title: 'Closure Form loaded successfully',
                    });
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Closure Form not loaded successfully',
                    })
                });
            },
        },
        mounted() {
            this.getAllInitials();
        }
    }
</script>