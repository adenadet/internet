<template>
<section>
<form role="form">
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Nominate Staff</h3>
    </div>
    <div class="card-body">
        
        <div class="form-group">
            <label for="exampleInputEmail1">Month</label>
            <input type="month" disabled class="form-control" id="som_month" placeholder="Month" v-model="nominateData.month">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Nominee</label>
            <select class="form-control" id="user_id" name="user_id" v-model="nominateData.user_id">
                <option value="0">---Select Staff---</option>
                <option v-for="user in dept_users" :key="user.id" :value="user.id">{{user.unique_id+' | '+user.first_name+' '+user.middle_name+' '+user.last_name}}</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Description</label>
            <textarea class="form-control" rows="5" id="description" name="description" placeholder="Explain why this person deserves to be Staff of the Month" v-model="nominateData.description"></textarea>
        </div>
    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-primary" @click="editMode ? editNomination() : addNomination() ">{{editMode ? 'Update' : 'Submit'}} </button>
    </div>
</div>
</form>
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
            nominateData: new Form({id: '', user_id: 0, month: '', description: '',}),   
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