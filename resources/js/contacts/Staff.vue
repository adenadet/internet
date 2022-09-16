<template>
<div class="col-sm-8 col-md-8 offset-md-2 offset-sm-2 d-flex align-items-stretch flex-column">
    <div class="card bg-light d-flex flex-fill">
        <div class="card-header text-muted border-bottom-0">Staff Details</div>
        <div class="card-body pt-0">
            <div class="row">
                <div class="col-7">
                    <h2 class="lead"><b>{{user.first_name}} {{user.middle_name}} {{user.last_name}}</b></h2>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span> Email: {{user.email}}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Branch: {{((typeof staff.branch != 'undefined') && (staff.branch !== null))? staff.branch.name: ''}}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Department: {{((typeof staff.department != 'undefined') && (staff.department !== null))? staff.department.name: ''}}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone-square-alt"></i></span> Office Phone: {{((typeof staff.department != 'undefined') && (staff.department !== null))? staff.department.phone: ''}}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone-alt"></i></span> Phone #: {{user.phone}}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-birthday-cake"></i></span> Birthday: {{user.dob | ExcelDateMonth}}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-sign-in-alt"></i></span> Joined On: {{staff.joined_at | getAge}}</li>
                    </ul>
                </div>
                <div class="col-5 text-center">
                    <img :src="(user.image) ? '/img/profile/'+user.image : '/img/profile/default.png'" alt="" class="img-circle img-fluid">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-right">
                <button class="btn btn-sm btn-primary" @click="chatUser(user.id)"><i class="fas fa-comment-alt"></i> Chat with Staff</button>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {
            staff: {},
            user:{},
        }
    },
    methods:{
        addUser(){
            this.editMode = false;
            this.user = {};
            Fire.$emit('BioDataFill', this.user);
            $('#userModal').modal('show');

            this.$Progress.finish();
        },
        chatUser(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "A new chat would be created between you and the user",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, create it!'
            })
            .then((result) => {
                if(result.value){
                    axios.get('/api/chats/rooms/check/'+id)
                    .then(response =>{this.$router.push('/chats');})
                    .catch(()=>{toast.fire({icon: 'error', title: 'Chats not loaded successfully',})})
                }
            });  
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/ums/staffs/'+this.$route.params.id).then(response =>{
                this.user = response.data.user;
                this.staff = response.data.staff;
                
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Staff loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Users not loaded successfully',
                })
            });
        },
    },
    mounted() {
        this.getAllInitials();
    },
}
</script>