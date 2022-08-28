<template>
    <div class="card direct-chat direct-chat-warning">
        <div class="card-header">
            <h3 class="card-title">Chats</h3>
            <div class="card-tools">
                <span data-toggle="tooltip" title="3 New Messages" class="badge badge-warning">3</span>
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                <i class="fas fa-comments"></i></button>
            </div>
        </div>
        <div class="card-body">
            <ChatMessages :user="user"/>
            <div class="direct-chat-contacts">
                <ul class="contacts-list">
                    <li v-for="chat in chats.data" :key="chat.id" @click="viewChat(chat)"><router-link to="/chats/private">
                        <img class="contacts-list-img" v-if="chat.messages.length == 0" src="/assets/dist/img/user1-128x128.jpg">
                        <img class="contacts-list-img" v-else :src="'img/profile/'+chat.messages[chat.messages.length - 1].user.image">
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
                    </router-link></li>
                </ul>
            </div>
        </div>
        <div class="card-footer">
            <router-link to="/chats"><button class="btn btn-primary">See All</button></router-link>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return  {
            chats: {},
            chat: {},
            user: {},
        }
    },
    mounted() {
        //console.log('Component mounted.')
    },
    created() {
        this.getInitials();
        Fire.$on('Reload', response =>{
            this.chats = response.data.chats;
            this.user = response.data.user;
        });
        Fire.$on('chatReload', chat =>{
            this.chat = chat;
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
        viewChat(chat){
            Fire.$emit('chatReload', chat);
        },
    },
    props:{
        //'chat': Object,
    },
}
</script>
