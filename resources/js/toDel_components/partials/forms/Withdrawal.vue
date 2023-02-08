<template>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Apply For Withdrawal</h2>
            </div>
            <div class="body">
<form @submit.prevent="createWithdrawal">
<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="form-group">
        <label>Withdrawal From:</label>
        <select class="form-control" id="saving_id" name="saving_id"  v-on:change="updateAccountBalance($event)" v-model="form.saving_id" required>
            <option value="">--Select Savings Account--</option>
            <option v-for="saving in savings" :key="saving.id" :value="saving.id">{{saving.name}} (&#x20a6; {{saving.balance | currency}})</option>
        </select>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="form-group">
        <label>Amount</label>
        <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount" v-model="form.amount" required>
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
        <input type="text" class="form-control" id="acct_number" name="Account Number" placeholder="acct_number" v-model="form.acct_number" required>
        </div>
    </div>
    <div class="col-md-12 col-sm-12">
        <div class="form-group">
            <label>Checkbox</label>
            <br/>
            <label class="fancy-checkbox">
                <input type="checkbox" name="agreed" id="agreed" v-model="form.agreed" required>
                <span>I understand and agree that I will be charged 0.5% of the amount applied for as Management fees *</span>
            </label>
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
                balance:'',
                form: new Form({
                    agreed:'',
                    saving_id:'',
                    bank_id: '',
                    amount:'',
                    acct_name: '',
                    acct_number: '',
                }),
                savings:{},
            }
        },
        methods:{
            createWithdrawal(){
                if (this.balance <= (this.form.amount*1.05)){
                    Swal.fire({
                        icon: 'error',
                        title: 'Insufficient Balance for this Withdrawal',
                    });
                }
                else{
                    this.form.post('/api/coop/withdrawals').then(response=>{
                        Swal.fire({
                            icon: 'success',
                            title: 'Withdrawal Request was successful, an Admin will speak with you soon',
                        });
                    this.form.reset();
                    })
                    .catch(()=>{
                        this.$Progress.fail();
                        toast.fire({
                            icon: 'error',
                            title: 'Withdrawal Request was not added try again later!',
                        })
                    });
                }
            },
            getAllInitials(){
                axios.get('/api/coop/withdrawals/initials').then(response =>{
                    this.all_banks = response.data.all_banks;
                    this.savings = response.data.savings;
                    this.$Progress.finish();
                    toast.fire({
                        icon: 'success',
                        title: 'Withdrawal Form loaded successfully',
                    });
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Withdrawal Form not loaded successfully',
                    })
                });
            },
            updateAccountBalance(e){
                let value = e.target.value;
                let saving = this.savings.find(d => d.id == value);
                this.balance = saving.balance - saving.fixed;
                console.log(this.balance);
            },
        },
        mounted() {
            this.getAllInitials();
        }
    }
</script>