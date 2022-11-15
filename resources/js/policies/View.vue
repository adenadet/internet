<template>
<div class="card">
    <div class="card-header"><h3>{{policy.name}}</h3></div>
    <div class="card-body">
        <div class="col-md-12" style="max-height: 500px; overflow: scroll;" v-if="policy.file != null">
            <vue-pdf-embed :source="policy.file != null ? 'https://intranet.saintnicholashospital.com'+policy.file : 'http://localhost:8000/upload/lessons/1666686506.pdf'" width="900" />
        </div>
    </div>
</div>
</template>
<script>
import VuePdfEmbed from 'vue-pdf-embed/dist/vue2-pdf-embed';
export default {
    components: {
        VuePdfEmbed
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