<template>
<section class="row">
    <div class="overlay-wrapper">
        <div class="overlay dark"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Loading...</div></div>
        Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis.
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
