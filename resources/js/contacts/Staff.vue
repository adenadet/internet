<template>
<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
    <div class="card bg-light d-flex flex-fill">
        <div class="card-header text-muted border-bottom-0">Digital Strategist</div>
        <div class="card-body pt-0">
            <div class="row">
                <div class="col-7">
                    <h2 class="lead"><b>Nicole Pearson</b></h2>
                    <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: Demo Street 123, Demo City 04312, NJ</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: + 800 - 12 12 23 52</li>
                    </ul>
                </div>
                <div class="col-5 text-center">
                    <img :src="(user.image) ? '/img/profile/'+user.image : '/img/profile/default.png'" alt="" class="img-circle img-fluid">
                </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                <a href="#" class="btn btn-sm bg-teal">
                    <i class="fas fa-comments"></i>
                </a>
                <a href="#" class="btn btn-sm btn-primary">
                    <i class="fas fa-user"></i> View Profile
                </a>
                </div>
            </div>
            </div>
        </div>
</template>
<script>
export default {
    data(){
        return {
            areas:[],
            branches:[],
            departments:[],
            editMode: false,
            savings:{},
            states:[],
            user:{},
            users:{},
            form: new Form({}),
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
                //Send Delete request
                if(result.value){
                    axios.get('/api/chats/rooms/check/'+id)//check if there is an existing Room with only these two people
                    .then(response =>{this.$router.push('/chats');})
                    .catch(()=>{toast.fire({icon: 'error', title: 'Chats not loaded successfully',})})
                }
            });  
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/ums/staffs/'+this.$route.params.id).then(response =>{
                this.areas = response.data.areas;
                this.branches = response.data.branches;
                this.departments = response.data.departments;
                this.states = response.data.states;
                this.users = response.data.users;
                
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Users loaded successfully',
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