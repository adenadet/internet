<template>
<div class="card card-danger">
    <div class="card-header">
        <h3 class="card-title">Notices</h3>
    </div>
    <div class="card-body" style="height:400px; overflow-y: scroll;">
        <div class="callout callout-danger" v-for="notice in notices.data" :key="notice.id">
            <h5>{{notice.topic}}</h5>
            <p>{{notice.content | readMore(50, '...')}}</p>
            <a :href="'/notices/'+notice.id"><button class="btn btn-sm btn-primary"> Details</button></a>
        </div>
    </div>
    <div class="card-footer"><a href="/notices">See More</a></div>
</div>
</template>
<script>
export default {
    data(){
        return {}
    },
    methods:{
        refresh(response){
            this.departments = response.data.departments;
            this.users = response.data.users;
            //Fire.$emit('LecturerFill', this.users);
        },
    },
    mounted() {},
    props:{
        'notices': Object,
    },
}
</script>