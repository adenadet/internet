<template>
<form action="#" @submit.prevent="message" method="post">
    <div class="input-group">
        <input type="text" name="message" placeholder="Type Message ..." class="form-control" v-model="MessageForm.content">
        <span class="input-group-append">
            <button type="button" :class="MessageForm.content == '' ? 'btn btn-primary disabled' :'btn btn-primary'" @click="message" >Send</button>
        </span>
    </div>
</form>
</template>
<script>
export default {
    data(){
        return  { 
            chat: {},
            date_now: '',
            MessageForm: new Form({
                content: '',
                chat_id: '',
                user_id: '',
            }),
        }
    },
    mounted() {
        //console.log('Component mounted.');
    },
    created() {
        //this.getInitials();
        Fire.$on('Reload', response =>{

        });
        Fire.$on('chatReload', chat =>{this.chat = chat;});
    },
    methods:{
        message(){
            this.$Progress.start();
            this.MessageForm.chat_id = this.chat.id;
            this.MessageForm.user_id = this.user.id;
            this.MessageForm.post('/api/chats/messenger')
            .then(response => {
                this.chat = response.data.chat;
                Fire.$emit('chatReload', response.data.chat);
                Fire.$emit('chatsReload', response.data.chats);
                this.MessageForm.content = '';
                this.$Progress.finish();
            })
            .catch(()=> {
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Messenger not sent',});
            })
        },
        scrollToEnd(){
            window.scrollTo(0, 99999);
        },
    },
    props:{
        'user': Object,
    }
}
</script>