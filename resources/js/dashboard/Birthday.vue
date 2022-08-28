<template>
<div class="card card-success">
    <div class="card-header"><h3 class="card-title">Birthdays</h3></div>
    <div class="card-body p-0">
        <ul class="users-list clearfix">
            <li v-for="user in birthdays" :key="user.id">
                <img style="height: 50px;" :src="(user.image) ? '/img/profile/'+user.image : '/img/profile/default.png'" :alt="user ? user.first_name+' '+user.middle_name+' '+user.last_name : 'Default Image' " :title="user ? user.first_name+' '+user.middle_name+' '+user.last_name : 'Celebrant\'s  Image' ">
                <router-link :to="'/users/staff/'+user.id" class="users-list-name" href="#">{{user.first_name}} {{user.last_name}}</router-link>
                <span class="users-list-date">{{user.dob | ExcelDateMonth}}</span>
            </li>
        </ul>
    </div>
    <div class="card-footer text-center">
        <router-link to="/birthdays">See More</router-link>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {}
    },
    methods:{
        scrollHanle(evt) {},
    },
    mounted() {
        //this.getAllInitials();
    },
    props:{
        'birthdays': Array,
    },
}
</script>