<template>
<div class="card card-primary">
    <div class="card-header">Staffs of the Month</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3"><button class="btn btn-default" @click="showSOM(month.id)" v-for="month in staff_months.data" :key="month.id">{{month.month | ExcelMonthYear}}</button></div>
            <div class="col-md-7 offset-1">
            <VueHorizontalList :items="items" :options="options">
                <template v-slot:nav-prev><div>👈</div></template>
                <template v-slot:nav-next><div>👉</div></template>
            
                <template v-slot:default="{ item }">
                    <div class="item">
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
                    </div>
                </template>
            </VueHorizontalList>
        </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return  {
            items: [],
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
            staff_months: {},
        }
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('BranchDataFill', response =>{});
        Fire.$on('AfterCreation', ()=>{});
    },
    methods:{
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/som/winners').then(response =>{
                this.refresh(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Winners were loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Winners were not loaded successfully',
                })
            });
        },
        refresh(response){
            this.staff_months = response.data.som_months;
            this.items = response.data.staff_months;
        },
        showSOM(id){
            axios.get('/api/som/winners/'+id).then(response =>{
                this.refresh(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Winners were loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Winners were not loaded successfully',
                })
            });            
        },
    },
    props:{branch: Object, editMode: Boolean, users: Array,}
}
</script>
