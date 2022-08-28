<template>
<section>
<div v-if="this.nogo == ''" class="direct-chat-messages" id="messageDiv">
    <div v-for="message in chat.messages" :key="message.id">    
        <div class="direct-chat-msg" v-show="message.user_id != user.id">
            <div class="direct-chat-infos clearfix">
                <span class="direct-chat-name float-left">{{message.user !== null ? message.user.first_name+' '+message.user.last_name : 'Deleted User'}}</span>
                <span class="direct-chat-timestamp float-right">{{message.created_at | excelDate}}</span>
            </div>
            <img class="direct-chat-img" :src="message.user !== null ? '/img/profile/'+message.user.image : '/img/profile/default.png'" alt="message user image">
            <div class="direct-chat-text">{{message.content}}</div>
        </div>
        <div class="direct-chat-msg right" v-show="message.user_id == user.id">
            <div class="direct-chat-infos clearfix">
                <span class="direct-chat-name float-right">Me</span>
                <span class="direct-chat-timestamp float-left">{{message.created_at | excelDate}}</span>
            </div>
            <img class="direct-chat-img" :src="message.user !== null ? '/img/profile/'+message.user.image : '/img/profile/default.png'" alt="message user image">
            <div class="direct-chat-text">{{message.content}}</div>
        </div>
    </div>
</div>
<div v-if="this.nogo != ''" class="direct-chat-messages" id="messageDiv">
    <h1>You are not a member of this chat room </h1>
</div>
</section>
</template>
<script>
export default {
    data(){
        return  {
            nogo: '',
            chat: {},
            messages: {},
        }
    },
    mounted() {},
    created() {
        this.timer = setInterval(this.getInitials, 10000);
        this.times = setInterval(this.scrollToEnd, 5000);
        
        Fire.$on('Reload', response =>{});
        Fire.$on('chatReload', chat =>{ 
            this.chat = chat; 
            /*$("#messageDiv").scrollTop($("#messageDiv")[0].scrollHeight);
            console.log("This is a test")

            var myDiv = document.getElementById("messageDiv");
            //alert(myDiv.scrollHeight);
            myDiv.scrollTop = myDiv.scrollHeight;
            this.sleep(3000);
            this.scrollToElement();
            this.sleep(10000);
            this.scrollToEnd();*/
        });
    },
    methods:{
        getInitials(){
            axios.get('/api/chats/messenger/'+this.chat.id).then(response =>{
                this.chat = response.data.chat;
            })
            .catch(()=>{});
        },
        scrollToElement(options) {
            const el = this.$el.getElementsByClassName('buttom')[0];
            if (el) {el.scrollIntoView(options);}
        },
        scrollToEnd(){
            const container = document.getElementById("messageDiv");
            container.scrollTop = container.scrollHeight;
            console.log(container.scrollHeight);
        },
        sleep(milliseconds) {
            const start = Date.now();
            while (Date.now() - start < milliseconds);
        }
    },
    props:{
        'user': Object,
    },
    updated(){
        /*var elem = this.$el.querySelector("#messageDiv");
        //elem.scrollTop = elem.clientHeight;
        elem.scrollTop = elem.scrollHeight*/
    },
}
</script>

