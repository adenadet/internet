<template>
<div :class="(message=='Working') ? 'card card-success' : 'card card-danger'">
    <div class="card-header border-0" >
        <div class="d-flex justify-content-between">
            <h3 class="card-title">{{check.name}}</h3>
        </div>
    </div>
    <div class="card-body info-box">
        <span class="info-box-icon elevation-1" :class="(message=='Working') ? 'bg-success' : 'bg-danger'"><i class="fa" :class="(message=='Working') ? 'fa-arrow-up' : 'fa-arrow-down'"></i></span>
        <div class="info-box-content">
            <span class="info-box-number">Last Checked Time: {{last_check_time}}</span>
            <span class="info-box-number">Last Active Time: {{last_active_time}}</span>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {
            checke: {},
            message:'Working',
            last_check_time: '',
            last_active_time: '',
            response:{},
        }
    },
    methods:{
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/icms/checks/'+ this.check.id).then(response =>{
                this.checke = response.data.check;
                this.message = response.data.message;
                this.last_check_time = response.data.current_time;
                if (this.checke.status == 1) {this.message = "Working"; this.last_active_time = response.data.current_time}
                else if (response.data.message == "Working") {this.last_active_time = response.data.current_time}
                else {console.log(response.data)}
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Internet loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Internet not loaded successfully',
                })
            });
        },
    },
    mounted() {
        this.last_check_time = this.check.last_check_time;
        this.last_active_time = this.check.last_active_time;
        this.message = (this.check.status == 1) ? "Working" : "Not Working";

        window.setInterval(() => {this.getAllInitials()}, 300000)
    },

    props:{
        'check': Object,
    }
}
</script>