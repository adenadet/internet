<template>
<div class="card bg-primary">
    <div class="card-header"><h5>{{ item.branch ? item.branch.name : 'Branch' }}</h5></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8 offset-2 text-center">
                <img :src="(item.user) && (item.user.image) ? '/img/profile/'+item.user.image : '/img/profile/default.png'" class="img-fluid" />
                <h5 class="">{{ item.user.first_name+' '+item.user.last_name }}</h5>
                <p>{{item.user.department.name}}</p>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    props: {'item': Object,},
}
</script>
