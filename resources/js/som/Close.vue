<template>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Running</h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead><tr><th>#</th><th>Task</th><th>Progress</th><th></th></tr></thead>
            <tbody>
                <tr v-for="task in tasks" :key="task.id">
                    <td>1.</td>
                    <td>{{task.name}}</td>
                    <td>{{task.return}} nominations</td>
                    <td><button class="btn btn-success" @click="closeNomination">End Nominations</button></td>
                </tr>
                <tr v-for="task in tasks" :key="task.id">
                    <td>1.</td>
                    <td>{{task.name}}</td>
                    <td>{{task.return}} votes</td>
                    <td><button class="btn btn-success" @click="closeNomination">End Nominations</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
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