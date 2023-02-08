<template>
<div class="card bg-dark">
    <div class="modal fade" id="chatModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Chat</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <ChatFormContactList />
                </div>
            </div>
        </div>
    </div>
    <div class="card-header">
        <h3 class="card-title">Active Chats</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" @click="newChat"><i class="fas fa-plus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <ul class="contacts-list">
            <li v-for="chat in chats.data" :key="chat.id" @click="viewChat(chat)">
                <img class="contacts-list-img" src="/assets/dist/img/user1-128x128.jpg">
                <div class="contacts-list-info">
                    <span class="contacts-list-name" v-show="chat.name != null">{{chat.name}}
                        <small class="contacts-list-date float-right">{{chat.updated_at | excelDate}}</small>
                    </span>
                    <span class="contacts-list-name" v-show="chat.name == null">
                        <em v-for="user in chat.members" :key="user.id">{{user.user.first_name+' '+user.user.last_name+', ' }}</em>
                        <small class="contacts-list-date float-right">{{chat.updated_at | excelDate}}</small>
                    </span>
                    <span class="contacts-list-msg" v-if="chat.messages.length == 0">No Message Yet</span>
                    <span class="contacts-list-msg" v-else>{{chat.messages[chat.messages.length - 1].content }}</span>
                </div>
            </li>
        </ul>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return  {
            chats: [],
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    created() {
        //this.getInitials();
        Fire.$on('Reload', response =>{
            
        });
        Fire.$on('chatsReload', chats =>{this.chats = chats;});
        Fire.$on('changeChatRoom', response =>{
            this.chats = response.data.chats;
            Fire.$emit('chatReload', response.data.chat);
            $('#chatModal').modal('hide'); 
        });
    },
    methods:{
        newChat(){
            Fire.$emit('ContactListRefresh')
            this.$Progress.start();
            $('#chatModal').modal('show');
            this.$Progress.finish();
        },
        viewChat(chat){
            Fire.$emit('chatReload', chat);
        },
    },
    props:{}
}
</script>

