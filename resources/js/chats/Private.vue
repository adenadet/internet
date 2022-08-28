<template>
<div class="card direct-chat direct-chat-primary">
    <div class="card-header">
        <h3 class="card-title" v-show="chat.name != null">{{chat.name}}</h3>
        <h3 class="card-title" v-show="chat.name == null">
            <em v-for="user in chat.members" :key="user.id">{{user.user.first_name+' '+user.user.last_name+', ' }}</em>
        </h3>
    </div>
    <div class="card-body"><ChatMessages :user="user"/></div>
    <div class="card-footer"><ChatFormInput :user="user"/></div> 
</div>
</template>
<script>
export default {
    data(){
        return  { 
            chat: {},
            messages: {},    
        }
    },
    mounted() {
        //console.log('Component mounted.')
    },
    created() {
        //this.getInitials();
        Fire.$on('Reload', response =>{});
        Fire.$on('chatReload', chat =>{this.chat = chat;});
    },
    methods:{
        addNew(){},
        getInitials(){
            axios.get('/api/chats/messenger/'+this.chat.id).then(response =>{
                this.messages = response.data.messages;
                //this.$Progress.finish();
                toast.fire({icon: 'success', title: 'Profile loaded successfully',});
                Fire.$emit('BioDataFill', this.user);
                Fire.$emit('NextOfKinFill', this.nok);
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Profile not loaded successfully',
                })
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
        'user': Object,
    }
}
</script>
