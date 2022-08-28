<template>
<section>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="ion ion-clipboard mr-1"></i>To Do List</h3>
            <div class="card-tools">
                <ul class="pagination pagination-sm">
                    <li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
                    <li class="page-item"><a href="#" class="page-link">1</a></li>
                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                    <li class="page-item"><a href="#" class="page-link">3</a></li>
                    <li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class=""><input type="text" class="form-control" name="search" id="search" placeholder="Search" v-model="search" @change="searchUser"></div>
            <form action="#" method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Room Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Chat Name" v-model="roomData.name"/>
                        <div class="input-group-append"><span class="input-group-text" id="">{{roomData.members.count}} Members</span></div>
                    </div>
                </div>
                <div class="col-sm-4" v-for="user in users.data" :key="user.id">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="departments[]" id="departments[]" v-model="roomData.members" :value="user.id" :checked="roomData.members.includes(user.id)">
                        <label class="form-check-label" style="color: #111;">{{user.unique_id+' | '+user.first_name+' '+user.last_name}}</label>

                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-info float-right" @click="addNew"><i class="fas fa-plus"></i> Add item</button>
            </form>
        </div>
        <div class="card-footer">
            <pagination :data="users" @pagination-change-page="getUser">
                <span slot="prev-nav">&lt; Previous </span>
                <span slot="next-nav">Next &gt;</span>
            </pagination>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data(){
        return  { 
            roomData: new Form({
                name: '',
                members : [],
            }),
            search: '',    
            users: {},
        }
    },
    mounted() {
        //console.log('Component mounted.')
    },
    created() {
        Fire.$on('ContactListRefresh', () => {
            console.log("Working")
            this.getInitials();
        });
    },
    methods:{
        addNew(){
            this.roomData.post('/api/chats/rooms')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('changeChatRoom', response);
                Swal.fire({
                    icon: 'success',
                    title: 'A New Chat has been created',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(()=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please try again later!'
                });
                this.$Progress.fail();
            });
        },
        getInitials(){
            axios.get('/api/ums/users').then(response =>{
                this.users = response.data.users;
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Users not loaded successfully',
                })
            });
        },
        getUser(page=1){
            axios.get('/api/ums/users?page='+page)
            .then(response=>{
                this.users = response.data.users;   
            });
        },
        searchUser(){
            axios.get('/api/ums/users/search?q='+this.search)
            .then(response=>{this.users = response.data.users;})
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error',title: 'Users not loaded successfully',})
            });
        },
    },
    props:{}
}
</script>