<template>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Latest Members</h3>
        <div class="card-tools">
            <span class="badge badge-danger">8 New Members</span>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <ul class="users-list clearfix">
            <li v-for="user in staffs" :key="user.id">
                <img style="height: 50px;" :src="(user.image) ? '/img/profile/'+user.image : '/img/profile/default.png'" :title="user.first_name+' '+user.last_name" :alt="user.first_name+' '+user.last_name">
                <router-link :to="'/contacts/staff/'+user.id" class="users-list-name" href="#">{{user.first_name+' '+user.last_name}}</router-link>
                <span class="users-list-date">{{user.joined_at | ExcelDateMonth}}</span>
            </li>
        </ul>
    </div>
    <div class="card-footer text-center">
        <a href="javascript::">View All Users</a>
    </div>
</div>
</template>
<script>
export default {
    data() {
        return {
            options: {
                responsive: [
                    { end: 576, size: 1 },
                    { start: 576, end: 768, size: 2 },
                    { start: 768, end: 992, size: 3 },
                    { size: 4 },
                ],
                list: {windowed: 1200, padding: 24,},
                position: {start: 2,},
                autoplay: { play: true, repeat: true, speed: 2500 },
            },
             
        };
    },
    props:{
        'staffs': Array
    }
}
</script>
