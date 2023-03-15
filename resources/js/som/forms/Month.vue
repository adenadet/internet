<template>
<section>
    <form>
        <alert-error :form="MonthData"></alert-error> 
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Month <span class="text-danger">*</span></label>
                    <input type="month" required class="form-control" id="month" name="month" placeholder="First Name *" v-model="MonthData.month" :class="{'is-invalid' : MonthData.errors.has('month') }">
                    <has-error :form="MonthData" field="month"></has-error> 
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Nomination Start <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="nomination_start" name="nomination_start" placeholder="middle Name" v-model="MonthData.nomination_start" :class="{'is-invalid' : MonthData.errors.has('nomination_start') }"/>
                    <has-error :form="MonthData" field="nomination_start"></has-error> 
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Nomination End</label>
                    <input type="date" class="form-control" id="nomination_end" name="nomination_end" placeholder="Last Name *" required v-model="MonthData.nomination_end" :class="{'is-invalid' : MonthData.errors.has('nomination_end') }" />
                    <has-error :form="MonthData" field="nomination_end"></has-error> 
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Voting Start <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="voting_start" name="voting_start" placeholder="middle Name" v-model="MonthData.voting_start" :class="{'is-invalid' : MonthData.errors.has('voting_start') }"/>
                    <has-error :form="MonthData" field="voting_start"></has-error> 
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Voting End</label>
                    <input type="date" class="form-control" id="voting_end" name="voting_end" placeholder="Last Name *" required v-model="MonthData.voting_end" :class="{'is-invalid' : MonthData.errors.has('voting_end') }" />
                    <has-error :form="MonthData" field="voting_end"></has-error> 
                </div>
            </div>
        </div>
        <button type="button" name="button" class="submit btn btn-primary" @click.prevent="editMode ? updateMonthData() : createMonthData()">Submit</button>
    </form>
</section>
</template>
<script>
export default {
    data(){
        return  {
            month: {},
            MonthData: new Form({
                month: '',
                nomination_start: '',
                nomination_end: null,
                voting_start: '',
                voting_end: null, 
                id: '',
            }),
        }
    },
    mounted() {
        Fire.$on('MonthDataFill', month =>{
            this.month = month;
            if (month.id != null){
                this.MonthData.id = month.id;
                this.MonthData.month = month.month.slice(0, 7);
                this.MonthData.nomination_start = month.nomination_start;
                this.MonthData.nomination_end = month.nomination_end.slice(0, 10);
                this.MonthData.voting_start = month.voting_start;
                this.MonthData.voting_end = month.voting_end.slice(0, 10);
                //this.MonthData.month = month.month;
            }
            else{
                this.MonthData.fill(month);
            }
        });
    },
    methods:{
        createMonthData(){
            this.$Progress.start();
            this.MonthData.post('/api/som/months')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('monthReload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The month has been created',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(()=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please try again later!'
                });
                this.$Progress.fail();
            });
        },
        updateMonthData(){
            this.$Progress.start();
            this.MonthData.put('/api/som/months/'+this.MonthData.id)
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('monthReload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Month has been updated',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(()=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please try again later!'
                });
                this.$Progress.fail();
            });
        },
    },
    props:{
        type: String,
        editMode: Boolean,
    }
}
</script>