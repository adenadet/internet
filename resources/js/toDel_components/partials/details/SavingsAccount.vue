<template>
<div class="table-responsive">
    <table class="table table-hover js-basic-example dataTable table-custom table-striped m-b-0 c_list">
        <thead>
            <tr>
                <th>Cooperator: </th>
                <th colspan=3>{{account.user.first_name}} {{account.user.last_name}}</th>
                <th>Branch</th>
                <th>{{account.branch.name}}</th>
            </tr>
            <tr>
                <th>Balance: </th>
                <th>&#x20a6; {{account.balance}}</th>
                <th>Fixed</th>
                <th>&#x20a6; {{account.fixed}}</th>
                <th>Total</th>
                <th>&#x20a6; {{account.balance}}
                </th>
            </tr>
        </thead>
    </table>
    <table class="table table-hover js-basic-example dataTable table-custom table-striped m-b-0 c_list">
        <thead class="thead-dark">
            <tr>
                <th>Payment Date</th>
                <th>Amount</th>
                <th>Bank</th>
                <th>Admin</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="contribution in account.contributions" :key="contribution.id">
                <td>{{contribution.payment_date}}</td>
                <td>&#x20a6; {{contribution.amount | currency}}</td>
                <td v-for="bank in banks" :key="bank.id" v-show="bank.id == contribution.bank_id">{{bank.bank_name}}<br />{{bank.name}}<br />{{bank.number}}</td>
                <td>{{contribution.admin_id}}</td>
                <td v-show="contribution.status == 1">Awaiting Admin Payment</td>
                <td v-show="contribution.status == 2">Awaiting Confirmation</td>
                <td v-show="contribution.status == 3">Onsite Confirmed</td>
                <td v-show="contribution.status == 4">Admin Confirmed</td>
                <td v-show="contribution.status == 5">Rejected</td>
                <td v-show="contribution.status < 3"><div class="btn-group"><button class="btn btn-sm btn-primary" v-on:click="editContribution(contribution)">Edit</button><button class="btn btn-sm btn-danger">Delete</button></div></td>
            </tr>
        </tbody>
    </table>
</div>

</template>

<script>
export default {
    data(){
        return {
            accounts:{},
            savings:{},
        }
    },
    methods:{
        createContribution(){
            this.form.post('/api/coop/contributions').then(response=>{
                toast.fire({
                    icon: 'success',
                    title: 'Contribution was successfully added!',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Contribution was not added try again later!',
                })
            });
        },
        editContribution(contribution){
            Fire.$emit('editContribution', contribution);
        },
        getAllInitials(){
            toast.fire({
                icon: 'success',
                title: 'Customers loaded successfully',
            });
        },
    },
    mounted() {
        this.getAllInitials();    
    },
    props: {'account': Object, 'banks':Array},
}
</script>
