<template>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Add New Saving Account</h2>
            </div>
            <div class="body">
<form @submit.prevent="editMode ? updateContribution() : createContribution() ">    
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="form-group">
            <label>Savings Account</label>
                <select class="form-control" id="saving_id" name="saving_id" v-model="form.saving_id">
                    <option value="">---Select Account---</option>
                    <option v-for="saving in savings" :key="saving.id" :value="saving.id">{{saving.name}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
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
        <div class="col-md-3 col-sm-6">
            <div class="form-group">
            <label>Date</label>
            <input type="date" class="form-control" id="payment_date" name="payment_date" placeholder="Enter Payment Date" required v-model="form.payment_date">
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
                    saving_id:'',
                    bank_id: '',
                    payment_date:'',
                    amount:'',
                    description:'',                    
                }),
                savings:{},
            }
        },
        methods:{
            createContribution(){
                this.form.post('/api/coop/contributions').then(response=>{
                    Swal.fire({
                        icon: 'success',
                        title: 'Contribution was successfully added!',
                    });
                    this.form.reset();
                })
                .catch(()=>{
                    this.$Progress.fail();
                    Swal.fire({
                        icon: 'error',
                        title: 'Contribution was not added try again later!',
                    });
                });
            },
            editContribution(contribution){
                this.editMode = true;
                console.log(contribution);
                this.form.fill(contribution);
            },
            getAllInitials(){
                axios.get('/api/coop/contributions/initials').then(response =>{
                    this.accounts = response.data.accounts;
                    this.savings = response.data.savings;
                    this.$Progress.finish();
                    toast.fire({
                        icon: 'success',
                        title: 'Contribution Form loaded successfully',
                    });
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Contribution Form not loaded successfully',
                    })
                });
            },
            updateContribution(){
                this.form.put('/api/coop/contributions/'+this.form.id)
                .then(response=>{
                    this.form.reset();
                    Fire.$emit('Refresh')
                    Swal.fire({
                        icon: 'success',
                        title: 'Contribution was successfully updated!',
                    });
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Contribution was not updated try again later!',
                    })
                });
            },
            updateItems(invoice_items){
                this.form.invoice_items = invoice_items.items;
                this.form.delivery = invoice_items.delivery;
                this.form.vat = invoice_items.vat;
                this.form.sub_total = invoice_items.sub_total;
                this.form.totals = parseFloat(invoice_items.sub_total) + parseFloat(invoice_items.delivery) + parseFloat(invoice_items.vat);
            },
            
        },
        mounted() {
            this.getAllInitials();
            Fire.$on('editContribution', contribution =>{
                this.editContribution(contribution);
            }); 
        },
        props:{'contribution': Object},
    }
</script>