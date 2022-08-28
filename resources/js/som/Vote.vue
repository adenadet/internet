<template>
<form>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">Month</label>
            <input type="month" disabled class="form-control" id="som_month" placeholder="Month" v-model="voteData.month">
        </div>
    </div>
    <div class="col-md-4" v-for="nomination in nominations" :key="nomination.id">
        <div class="card bg-light">
            <div class="card-header text-muted border-bottom-0">
                <div class="row">
                <div class="form-group">
                    <input type="radio" id="som_month"  name="voted_for" :value="nomination.user_id" v-model="voteData.user_id"/>
                    <label for="exampleInputEmail1">{{nomination.nominee.first_name+' '+nomination.nominee.middle_name+' '+nomination.nominee.last_name}}</label>
                </div>  
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-8"><p class="text-muted text-sm">{{nomination.description}}</p></div>
                    <div class="col-4 text-center">
                        <img :src="(nomination.nominee.image) ? '/img/profile/'+nomination.nominee.image : '/img/profile/default.png'" :alt="nomination.nominee.first_name+' '+nomination.nominee.middle_name+' '+nomination.nominee.last_name" :title="nomination.nominee.first_name+' '+nomination.nominee.middle_name+' '+nomination.nominee.last_name" class="img-circle img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<button @click.prevent="editMode ? editVote() : addVote()" type="submit" name="submit" class="submit btn btn-success">{{editMode ? 'Update' : 'Submit' }}</button>
</form>
</template>
<script>
import moment from 'moment'
export default {
    data(){
        return {
            dept_users: [],
            editMode: false,
            nominations: [],
            voteData: new Form({
                id: '',
                user_id: 0,
                month: '',
            }),   
        }
    },
    methods:{
        addVote(){
            this.$Progress.start();
            this.voteData.post('/api/som/votes')
            .then(response=>{
                this.$Progress.finish();
                Swal.fire({icon: 'success', title: 'Your vote has been accepted!',});
            })
            .catch(()=>{
                this.$Progress.fail();
                Swal.fire({icon: 'error', title: 'Your form was not sent try again later!',});
            })
        },
        editVote(){
            this.$Progress.start();
            this.voteData.put('/api/som/votes/'+this.voteData.id)
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

            axios.get('/api/som/votes')
            .then(response =>{
                console.log(response.data)
                
                if (response.data.previous == 1){
                    Swal.fire({icon: 'warning', title: 'You have previously voted for '+futureMonth.format('YYYY-MM')+', you would be modifying your record',});
                    this.voteData.id            = response.data.vote.id;
                    this.voteData.user_id       = response.data.vote.user_id;
                    this.voteData.month         = response.data.vote.month;
                    this.editMode               = true;
                }
                else{
                    this.voteData.id            = '';
                    this.voteData.description   = '';
                    this.voteData.user_id       = 0;
                    this.voteData.month         = futureMonth.format('YYYY-MM');
                    this.editMode               = false;
                }
                
                this.nominations = response.data.nominations;
                
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