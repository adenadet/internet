<template>
<div class="card card-widget">
    <div class="card-header">
        <div class="user-block">
            <img class="img-circle" :src="creator.image | profilePicture" alt="User Image">
            <span class="username"><a href="#">{{creator != null ? creator.first_name+' '+creator.last_name : 'Loading User'}}</a></span>
            <span class="description">Shared publicly - {{notice.created_at | excelDate}}</span>
        </div>
    </div>
    <div class="card-body">
        <img v-if="notice.image != null" class="img-fluid pad" :src="'/upload/notices/'+notice.image" alt="Photo">
        <p>{{notice.content}}</p>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {
            notice: {},
            creator: {},   
        }
    },
    methods:{
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/notices/'+this.$route.params.id).then(response =>{
                this.refresh(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Departments were loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Departments were not loaded successfully',
                })
            });
        },
        refresh(response){
            this.notice = response.data.notice;
            this.creator = response.data.notice.creator;
        },
    },
    mounted() {
        this.getAllInitials();
    }
}
</script>
