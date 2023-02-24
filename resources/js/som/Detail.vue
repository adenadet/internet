<template>
<section>
    <div class="card card-widget widget-user-2">
        <div class="card-body">
            <i class="fas fa-user mr-1"></i> Nomination Opened By:
            <p><strong>{{ month.nomination_open | FullName }}<br /></strong>
            <span class="text-muted">{{ month.nomination_start | excelDate }}</span></p>
            <hr>

            <i class="fas fa-user mr-1"></i> Nomination Closed By:
            <p><strong>{{ month.nomination_close | FullName }}<br /></strong>
            <span class="text-muted">{{ month.nomination_end | excelDate }}</span></p>
            <hr>

            <i class="fas fa-user mr-1"></i> Voting Opened By:
            <p><strong>{{ month.voting_open | FullName }}<br /></strong>
            <span class="text-muted">{{ month.voting_start | excelDate }}</span></p>
            <hr>
            
            <i class="fas fa-user mr-1"></i> Voting Closed By:
            <p><strong>{{ month.voting_close | FullName }}<br /></strong>
            <span class="text-muted">{{ month.voting_end | excelDate }}</span></p>
            <hr>
            
            <i class="fas fa-map-marker-alt mr-1"></i> Status:
            <p> <strong>{{ month.status }}</strong></p>
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
            month: {},
            staff_month: {},
            staff_months: {},   
        }
    },
    methods:{
        reloadPage(response){
            this.month = response.data.month;
        },
    },
    mounted() {
        //this.getAllInitials();
        Fire.$on('loadMonth', month=>{
            var futureMonth = moment(month).format('YYYY-MM');
            console.log(futureMonth);
            let query = this.$parent.search;
            axios.get('/api/som/months/'+futureMonth)
            .then((response ) => {this.reloadPage(response);})
            .catch(()=>{});
        });
    }
}
</script>