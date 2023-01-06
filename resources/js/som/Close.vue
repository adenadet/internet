<template>
<section class="row">
    <div class="col-12 col-md-12 col-sm-6">
        <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-five-overlay-tab" data-toggle="pill" href="#custom-tabs-five-overlay" role="tab" aria-controls="custom-tabs-five-overlay" aria-selected="true">Overlay</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-five-overlay-dark-tab" data-toggle="pill" href="#custom-tabs-five-overlay-dark" role="tab" aria-controls="custom-tabs-five-overlay-dark" aria-selected="false">Overlay Dark</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-five-normal-tab" data-toggle="pill" href="#custom-tabs-five-normal" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="false">Normal Tab</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-five-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-five-overlay" role="tabpanel" aria-labelledby="custom-tabs-five-overlay-tab">
                        <SOMCloseNominations />
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-five-overlay-dark" role="tabpanel" aria-labelledby="custom-tabs-five-overlay-dark-tab">
                        <SOMCloseNominations />
                        
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-five-normal" role="tabpanel" aria-labelledby="custom-tabs-five-normal-tab">
                    Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
                    </div>
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
        addNomination(){
            this.$Progress.start();
            this.nominateData.post('/api/som/nominations')
            .then(response=>{
                this.$Progress.finish();
                Swal.fire({icon: 'success', title: 'Your nomination has been accepted!',});
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({icon: 'error', title: 'Your form was not sent try again later!',});
            })
        },
        editNomination(){
            this.$Progress.start();
            this.nominateData.put('/api/som/nominations/'+this.nominateData.id)
            .then(response=>{
                console.log(response)
                this.$Progress.finish();
                Swal.fire({icon: 'success', title: 'Your nomination has been accepted!',});
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({icon: 'error', title: 'Your form was not sent try again later!',});
            })
        },
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
        this.getAllInitials();
    }
}
</script>