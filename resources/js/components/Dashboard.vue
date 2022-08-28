<template>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>150</h3>
                        <p>Assigned Courses</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>53<!--<sup style="font-size: 20px">%</sup>--></h3>
                        <p>Completed Courses</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>44</h3>
                        <p>Courses in Progress</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>65</h3>
                        <p>Certificate Gotten</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-certificate"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card direct-chat direct-chat-warning">
                <div class="card-header">
                    <h3 class="card-title">Direct Chat</h3>
                    <div class="card-tools">
                        <span data-toggle="tooltip" title="3 New Messages" class="badge badge-warning">3</span>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts"
                                data-widget="chat-pane-toggle">
                            <i class="fas fa-comments"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <vue-custom-scrollbar class="scroll-area"  :settings="settings" @ps-scroll-y="scrollHanle">
<ul class="contacts-list" style="color:#000;">
<li>
<a href="#">
    <img class="contacts-list-img" src="/assets/lms/dist/img/user1-128x128.jpg">
    <div class="contacts-list-info">
        <span class="contacts-list-name" style="color:#000;">Count Dracula<small class="contacts-list-date float-right" style="color:#000;">2/28/2015</small></span>
        <span class="contacts-list-msg"  style="color:#000;">How have you been? I was...</span>
    </div>
</a>
</li>
<li>
<a href="#">
    <img class="contacts-list-img" src="/assets/lms/dist/img/user7-128x128.jpg">
    <div class="contacts-list-info">
        <span class="contacts-list-name" style="color:#000;">Sarah Doe<small class="contacts-list-date float-right" style="color:#000;">2/23/2015</small></span>
        <span class="contacts-list-msg" style="color:#000;">I will be waiting for...</span>
    </div>
</a>
</li>
<li>
<a href="#">
    <img class="contacts-list-img" src="/assets/lms/dist/img/user3-128x128.jpg">
    <div class="contacts-list-info">
        <span class="contacts-list-name">Nadia Jolie<small class="contacts-list-date float-right">2/20/2015</small></span>
        <span class="contacts-list-msg">I'll call you back at...</span>
    </div>
</a>
</li>
<li>
<a href="#">
    <img class="contacts-list-img" src="/assets/lms/dist/img/user5-128x128.jpg">
    <div class="contacts-list-info">
        <span class="contacts-list-name">Nora S. Vans<small class="contacts-list-date float-right">2/10/2015</small></span>
        <span class="contacts-list-msg">Where is your new...</span>
    </div>
</a>
</li>
<li>
<a href="#">
    <img class="contacts-list-img" src="/assets/lms/dist/img/user6-128x128.jpg">
    <div class="contacts-list-info">
        <span class="contacts-list-name">John K.<small class="contacts-list-date float-right">1/27/2015</small></span>
        <span class="contacts-list-msg">Can I take a look at...</span>
    </div>
</a>
</li>
<li>
<a href="#">
    <img class="contacts-list-img" src="/assets/lms/dist/img/user8-128x128.jpg">
    <div class="contacts-list-info">
        <span class="contacts-list-name">Kenneth M.<small class="contacts-list-date float-right">1/4/2015</small></span>
        <span class="contacts-list-msg">Never mind I found...</span>
    </div>
</a>
</li>
</ul>
                            </vue-custom-scrollbar>
                        </div>
                        <div class="col-7">
                            <vue-custom-scrollbar :settings="settings">
<div class="direct-chat-messages" style="height:auto">
<div class="direct-chat-msg">
    <div class="direct-chat-infos clearfix">
    <span class="direct-chat-name float-left">Alexander Pierce</span>
    <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
    </div>
    <!-- /.direct-chat-infos -->
    <img class="direct-chat-img" src="/assets/lms/dist/img/user1-128x128.jpg" alt="message user image" />
    <!-- /.direct-chat-img -->
    <div class="direct-chat-text">
    Is this template really for free? That's unbelievable!
    </div>
    <!-- /.direct-chat-text -->
</div>
<div class="direct-chat-msg right">
    <div class="direct-chat-infos clearfix">
        <span class="direct-chat-name float-right">Sarah Bullock</span>
        <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
    </div>
    <img class="direct-chat-img" src="/assets/lms/dist/img/user3-128x128.jpg" alt="message user image">
    <div class="direct-chat-text">You better believe it!</div>
</div>
<div class="direct-chat-msg">
    <div class="direct-chat-infos clearfix">
        <span class="direct-chat-name float-left">Alexander Pierce</span>
        <span class="direct-chat-timestamp float-right">23 Jan 5:37 pm</span>
    </div>
    <img class="direct-chat-img" src="/assets/lms/dist/img/user1-128x128.jpg" alt="message user image">
    <div class="direct-chat-text">Working with AdminLTE on a great new app! Wanna join?</div>
</div>
<div class="direct-chat-msg right">
    <div class="direct-chat-infos clearfix">
        <span class="direct-chat-name float-right">Sarah Bullock</span>
        <span class="direct-chat-timestamp float-left">23 Jan 6:10 pm</span>
    </div>
    <img class="direct-chat-img" src="/assets/lms/dist/img/user3-128x128.jpg" alt="message user image">
    <div class="direct-chat-text">I would love to.</div>
</div>
</div>
                            </vue-custom-scrollbar>
<form action="#" method="post">
<div class="input-group">
    <input type="text" name="message" placeholder="Type Message ..." class="form-control">
    <span class="input-group-append">
    <button type="button" class="btn btn-warning">Send</button>
    </span>
</div>
</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                <p class="text-center">
                    <strong>Course Completion</strong>
                </p>

                <div class="progress-group">
                    Add Products to Cart
                    <span class="float-right"><b>160</b>/200</span>
                    <div class="progress progress-sm">
                    <div class="progress-bar bg-primary" style="width: 80%"></div>
                    </div>
                </div>
                    <!-- /.progress-group -->

                <div class="progress-group">
                    Complete Purchase
                    <span class="float-right"><b>310</b>/400</span>
                    <div class="progress progress-sm">
                    <div class="progress-bar bg-danger" style="width: 75%"></div>
                    </div>
                </div>

                    <!-- /.progress-group -->
                <div class="progress-group">
                    <span class="progress-text">Visit Premium Page</span>
                    <span class="float-right"><b>480</b>/800</span>
                    <div class="progress progress-sm">
                    <div class="progress-bar bg-success" style="width: 60%"></div>
                    </div>
                </div>

                    <!-- /.progress-group -->
                <div class="progress-group">
                    Send Inquiries
                    <span class="float-right"><b>250</b>/500</span>
                    <div class="progress progress-sm">
                    <div class="progress-bar bg-warning" style="width: 50%"></div>
                    </div>
                </div>
                </div>
            </div>
                <!-- /.progress-group -->
        </div>
    </div>
</section>
</template>

<script>
    import vueCustomScrollbar from 'vue-custom-scrollbar'
    import "vue-custom-scrollbar/dist/vueScrollbar.css"
    export default {
        components: {vueCustomScrollbar},
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
                settings: {suppressScrollY: false, suppressScrollX: false, wheelPropagation: false},
                unconfirmed:0,
                user:[],
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
            scrollHanle(evt) {},
        },
        mounted() {
            this.getAllInitials();
        }
    }
</script>
<style >
.scroll-area {
    position: relative;
    margin: auto;
    width: auto;
    height: 300px;
    }
</style>
