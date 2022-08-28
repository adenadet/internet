<template>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6" v-for="check in checks" :key="check.id">
                <NetworkCard :check="check" />
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {
            checks: [],
            message:'Working',
            last_check_time: '',
            last_active_time: '',
            response:{},
        }
    },
    methods:{
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/icms/checks').then(response =>{
                this.checks = response.data.checks;
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
        this.getAllInitials();

        this.last_check_time = this.check.last_check_time;
        this.last_active_time = this.check.last_active_time;

    },
    props:{
        'check': Object,
    }
}
</script>