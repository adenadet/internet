<template>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2>Loan Request Form</h2>
                </div>
                <div class="body">
<form @submit.prevent="createLoan">    
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
            <label>Loan Type</label>
            <select class="form-control" id="type_id" name="type_id" v-model="form.loan_type_id" required>
                <option value="">---Select Type---</option>
                <option v-for="loan_type in loan_types" :key="loan_type.id" :value="loan_type.id">{{loan_type.name}}</option>
            </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Loan Name" v-model="form.name" required>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
            <label>Requested Amount</label>
            <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Fund Requested" v-model="form.amount" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
            <label>Guarantors</label>
            <multiselect v-model="form.guarantors" :options="guarantors" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="name" track-by="name" :preselect-first="true">
                <template slot="selection" slot-scope="{ values, search, isOpen }">
                    <span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">
                        {{ values.length }} options selected
                    </span>
                </template>
            </multiselect>
            <pre class="language-json"><code>{{ value  }}</code></pre>    
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" rows=5 id="description" name="description" placeholder="Description"></textarea>
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
                accounts:{},
                editMode: false,
                form: new Form({
                    loan_type_id:'',
                    name: '',
                    amount: '',
                    guarantors: [],
                    description: '',
                }),
                loan_types:{},
                users:{},
                guarantors:[],
                values:{},
                value:'',
            }
        },
        methods:{
            createLoan(){
                console.log(this.form);
                this.form.post('/api/coop/loans').then(response=>{
                    this.form.reset();
                    Swal.fire({
                        icon: 'success',
                        title: 'Great',
                        title: 'Loan was successfully added!',
                        footer: '<router-link to="/member_area/loans">Why do I have this issue?</router-link>'
                    });
                })
                .catch(()=>{
                    this.$Progress.fail();
                    Swal.fire({
                        icon: 'error',
                        title: 'Repayment was not added try again later!',
                    })
                });
            },
            getAllInitials(){
                axios.get('/api/coop/loans/initials').then(response =>{
                    this.accounts = response.data.accounts;
                    this.loan_types = response.data.loan_types;
                    this.users = response.data.users;
                    let guarantors = [];
                    
                    for (let i = 0; i < this.users.length; i++) {
                        guarantors.push({
                            'id' : this.users[i].id, 
                            'name' : this.users[i].unique_id+' | '+this.users[i].first_name+' '+this.users[i].last_name,
                            'value' : this.users[i].unique_id,
                            });
                        }
                    
                    this.guarantors = guarantors;
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Loan form was not loaded successfully',
                    })
                });
            },
        },
        mounted() {
            this.getAllInitials();
        }
    }
</script>