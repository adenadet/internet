<template>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8"><ChatPrivate :user="user"/></div>
            <div class="col-md-4"><ChatList /></div>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data(){
        return  {
            chats: {},
            chat: {
                id: 1,
                to: {
                    id: 3,
                    first_name: 'Stella',
                    middle_name: 'N.',
                    last_name: 'Nwagbo',
                },
            }, 
            user: {},
        }
    },
    mounted() {
        //console.log('Component mounted.')
    },
    created() {
        this.getInitials();
        Fire.$on('changeChatRoom', response =>{
            this.chats = response.data.chats;
            this.user = response.data.user;
        });
    },
    methods:{
        addNew(){},
        getInitials(){
            axios.get('/api/chats/messenger/private').then(response =>{
                this.chats = response.data.chats;
                Fire.$emit('chatsReload', this.chats);
                this.user = response.data.user; 
                this.chat = response.data.chats.data[0];
                Fire.$emit('chatReload', this.chat);
                this.$Progress.finish();
                toast.fire({icon: 'success', title: 'Chat loaded successfully',});
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Chat not loaded successfully',});
            });
        },
        getProfilePic(){
            let  photo = (this.form.image.length >= 150) ? this.form.image : "./"+this.form.image;
            return photo;
        },
        updateProfilePic(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file['size'] < 2000000){
                reader.onloadend = (e) => {
                    this.form.image = reader.result
                    }
                reader.readAsDataURL(file)
            }
            else{
                swal.fire({
                        type: 'error',
                        title: 'File is too large'
                    })
            }
        },
    },
    props:{
        //'chat': Object,
    },
}
</script>