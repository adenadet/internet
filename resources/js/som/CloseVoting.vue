<template>
<div class="overlay-wrapper">
    <div v-if="loading" class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Loading...</div></div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Votings for {{ month_date | ExcelMonthYear }}</h3>
                    <div class="card-tools">
                        <button class="btn btn-sm btn-primary" @click="openVotings(new_month)"><i class="fa fa-calendar-check"></i> Open Voting for {{ new_month | ExcelMonthYear }}</button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0" style="max-height: 500px;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Branch</th>
                                <th>Staff</th>
                                <th>Votes</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(nomination,index) in nominations" :key="nomination.id">
                                <td>{{ index | addOne}}</td>
                                <td>{{ nomination.branch != null ?nomination.branch.name: 'HQ?' }}</td>
                                <td>{{ nomination.nominee | FullName }}</td>
                                <td>{{ nomination.votes.length }}</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button class="btn btn-sm btn-primary" @click="closeVoting()"><i class="fa fa-calendar-times mr-1"></i>Close Voting</button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
import moment from 'moment'
export default {
    data(){
        return {
            nominations: [],
            loading: true,
            editMode: false,
            month: '', 
            month_date: '',
            new_month: '',
            voteData: new Form({}),
        }
    },
    methods:{
        closeVoting(){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, close voting!'
            })
            .then((result) => {
                if(result.value){
                    this.$Progress.start();
                    this.voteData.put('/api/som/votes/close/'+this.month_date)
                    .then(response=>{
                        this.$Progress.finish();
                        Swal.fire({icon: 'success', title: 'All nominations has for '+this.month+' been closed!',});
                    })
                    .catch(()=>{
                        this.$Progress.fail();
                        Swal.fire({icon: 'error', title: 'Your form was not sent try again later!',});
                    })
                }
            });
        },
        getAllInitials(){
            this.loading = true;
            var currentDate = moment({});
            this.new_month = currentDate.format('YYYY-MM');
            var futureMonth = moment(currentDate).add(-1, 'M');
            var futureMonthEnd = moment(futureMonth).endOf('month');
            this.month = futureMonthEnd.format('MMM YYYY');
            this.month_date = futureMonthEnd.format('YYYY-MM');
            
            axios.get('/api/som/votes/'+futureMonthEnd.format('YYYY-MM'))
            .then(response =>{
                this.reloadPage(response);
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Nominations did not loaded successfully',
                })
            });
        },
        reloadPage(response){
            this.nominations = response.data.nominations;
            this.loading = false;
        },
    },
    mounted() {
        this.getAllInitials();
    }
}
</script>