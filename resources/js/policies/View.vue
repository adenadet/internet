<template>
<div class="card">
    <div class="card-header"><h3>{{policy.name}}</h3></div>
    <div class="card-body">
        <div class="col-md-12" style="max-height: 500px" v-if="policy.file != null">
            https://intranet.saintnicholashospital.com/upload/policies/1668508208.pdf
            <VuePdfApp pdf="https://intranet.saintnicholashospital.com/upload/policies/1668508208.pdf"/>
        </div>
    </div>
</div>
</template>
<script>
import VuePdfApp from 'vue-pdf-app';
import "vue-pdf-app/dist/icons/main.css";

export default {
    components: {
        VuePdfApp
    },
    data(){
        return {
            policy: {},
        }
    },
    methods:{
        getInitials(){
            this.$Progress.start();
            axios.get('/api/policies/'+this.$route.params.id).then(response =>{
                this.policy = response.data.policy;
                this.$Progress.finish();
                toast.fire({icon: 'success', title: 'Policies were loaded successfully',});
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Policies were not loaded successfully',})
            });
        },
        return(){},
    },  
    mounted() {
        this.getInitials();
    },
}
</script>