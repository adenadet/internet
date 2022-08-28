<template>
<div>
    <div class="row clearfix">
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="header">
                    <h2>Savings</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover m-b-0">
                            <thead class="thead-dark">
                                <tr>
                                <th>Name</th>
                                <th>Balance</th>
                                <th>Fixed</th>
                                <th>Unconfirmed</th>
                                <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="saving in savings" :key="saving.id">
                                    <td><router-link to="/member_area/savings">{{saving.name}}</router-link></td>
                                    <td>{{saving.balance | currency}}</td>
                                    <td>{{saving.fixed | currency}}</td>
                                    <td><div v-show="(1 <= 0)" v-for="contribution in saving.contributions" :key="contribution.id">
                                        {{unconfirmed += contribution.amount}}
                                    </div>
                                        {{unconfirmed | currency}}</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="header">
                    <h2>Loans</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover m-b-0">
                            <thead class="thead-dark">
                                <tr>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Paid</th>
                                <th>Payable</th>
                                <th>Balance</th>
                                <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="loan in loans" :key="loan.id">
                                    <td><router-link to="/member_area/loans">{{loan.name}}</router-link></td>
                                    <td><span>{{loan.amount | currency}}</span></td>
                                    <td>{{loan.paid | currency}}</td>
                                    <td>{{loan.balance | currency}}</td>
                                    <td>{{loan.payable | currency}}</td>
                                    
                                    <td><span class="badge badge-success">Active</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="header">
                    <h2>Contribution Statistics</h2>
                    <ul class="header-dropdown">
                        
                    </ul>
                </div>
                <div class="body">
                    <column-chart :data="contributionData"></column-chart>    
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="header">
                    <h2>Contribution Statistics</h2>
                    <ul class="header-dropdown">
                        
                    </ul>
                </div>
                <div class="body">
                    <FormContact></FormContact>    
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
                chartData:[
                    {   name: "sales", 
                        data: {'2020-08-19' : 5, '2020-08-20': 8, '2020-08-21': 9, '2020-08-22': 3, '2020-08-23': 7, '2020-08-24': 14, '2020-08-25': 4,}
                    },
                    {
                        name: "expenses",
                        data:{'2020-08-19': 7, '2020-08-20': 10, '2020-08-21': 8, '2020-08-22': 0, '2020-08-23': 15,'2020-08-24': 9, '2020-08-25': 12,
                        }
                    }
                ],
                contributionData:[],
                contributions:[],
                con_sums:[],
                loans:[],
                months:[],
                repaymentData:[],
                savings: [],
                user:[],
                unconfirmed:0,
            }
        },
        methods:{
            getAllInitials(){
                axios.get('/api/coop/dashboard')
                .then(response =>{
                    this.contributions = response.data.contribution;
                    this.con_sums = response.data.con_sum;
                    this.loans = response.data.loans;
                    this.savings = response.data.savings;
                    this.user = response.data.user;
                    
                    var monthNames = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
                    var today = new Date();
                    var d;
                    
                    //Put the Data into an array
                    for (var k = 0; k < this.con_sums.length; k++) {
                        var item =[this.con_sums[k].month, this.con_sums[k].sum ]
                        this.contributionData.push(item)
                    }

                    //Add Missing months with value of Zero
                    for(var j = 6; j > -1; j -= 1) {
                        d = new Date(today.getFullYear(), today.getMonth() - j, 1);
                        this.months.push(d.getFullYear()+'-'+monthNames[d.getMonth()]);
                    }

                    //console.log(this.con_sums);
                    for (var i = 0; i < this.months.length; i++) {
                        if(!(this.con_sums.some(con_sum => con_sum.month === this.months[i]))){
                            var item = [this.months[i], 0];
                            this.contributionData.push(item);
                        }
                    }
                    
                    this.contributionData.sort();

                    toast.fire({
                        icon: 'success',
                        title: 'Dashboard loaded successfully',
                    });
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast.fire({
                        icon: 'error',
                        title: 'Dashboard not loaded successfully',
                    })
                });
            },
        },
        mounted() {
            this.getAllInitials();
        }
    }
</script>
