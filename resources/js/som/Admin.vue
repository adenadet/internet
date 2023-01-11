<template>
<section class="row">
    <div class="col-12 col-md-12 col-sm-6">
        <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="custom-tabs-five-overlay-tab" data-toggle="pill" href="#custom-tabs-five-overlay" role="tab" aria-controls="custom-tabs-five-overlay" aria-selected="true">Nominations</a></li>
                    <li class="nav-item"><a class="nav-link" id="custom-tabs-five-overlay-dark-tab" data-toggle="pill" href="#custom-tabs-five-overlay-dark" role="tab" aria-controls="custom-tabs-five-overlay-dark" aria-selected="false">Voting</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-five-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-five-overlay" role="tabpanel" aria-labelledby="custom-tabs-five-overlay-tab"><SOMCloseNominations /></div>
                    <div class="tab-pane fade" id="custom-tabs-five-overlay-dark" role="tabpanel" aria-labelledby="custom-tabs-five-overlay-dark-tab"><SOMCloseVoting /></div>
                </div>
            </div>
        </div> 
    </div>  
</section>
</template>
<script>
import moment from 'moment'
export default {
    data(){
        return {
            dept_users: [],
            editMode: false,
            month: '',
            nominateData: new Form({
                id: '',
                user_id: 0,
                month: '',
                description: '',
            }),   
        }
    },
    methods:{
        getAllInitials(){
            var currentDate = moment({});
            var futureMonth = moment(currentDate).add(-1, 'M');
            var futureMonthEnd = moment(futureMonth).endOf('month');

            if(currentDate.date() != futureMonth.date() && futureMonth.isSame(futureMonthEnd.format('YYYY-MM-DD'))) {
                futureMonth = futureMonth.add(1, 'd');
            }

            axios.get('/api/som/nominations')
            .then(response =>{
                if (response.data.previous == 1){
                    Swal.fire({icon: 'warning', title: 'You have previously nominate for '+futureMonth.format('YYYY-MM')+', you would be modifying your record',});
                    this.nominateData.id            = response.data.nomination.id;
                    this.nominateData.user_id       = response.data.nomination.user_id;
                    this.nominateData.description   = response.data.nomination.description;
                    this.nominateData.month         = response.data.nomination.month;
                    this.editMode                   = true;
                }
                else{
                    this.nominateData.id            = '';
                    this.nominateData.description   = '';
                    this.nominateData.user_id       = 0;
                    this.nominateData.month         = futureMonth.format('YYYY-MM');
                    this.editMode                   = false;
                }
                this.dept_users = response.data.dept_users;
                
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
        //this.getAllInitials();
    }
}
</script>