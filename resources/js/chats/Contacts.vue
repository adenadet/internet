<template>
<div class="direct-chat-contacts">
    <ul class="contacts-list">
        <li v-for="chat in chats" :key="chat.id" @click="viewChat(chat)">
            <img class="contacts-list-img" src="dist/img/user1-128x128.jpg">
            <div class="contacts-list-info">
                <span class="contacts-list-name">Count Dracula <small class="contacts-list-date float-right">{{this.chat.updated_at | excelDate}}</small></span>
                <span class="contacts-list-msg">{{this.chat.messages[0].content}} </span>
            </div>
        </li>
        <li>
            <a href="#"><img class="contacts-list-img" src="dist/img/user7-128x128.jpg">
            <div class="contacts-list-info">
                <span class="contacts-list-name">Sarah Doe <small class="contacts-list-date float-right">2/23/2015</small></span>
                <span class="contacts-list-msg">I will be waiting for...</span>
            </div>
            </a>
        </li>
        <li><a href="#">
            <img class="contacts-list-img" src="dist/img/user3-128x128.jpg">
            <div class="contacts-list-info">
                <span class="contacts-list-name">Nadia Jolie <small class="contacts-list-date float-right">2/20/2015</small></span>
                <span class="contacts-list-msg">I'll call you back at...</span>
            </div>
        </a></li>
        <li><a href="#">
            <img class="contacts-list-img" src="dist/img/user5-128x128.jpg">
            <div class="contacts-list-info">
                <span class="contacts-list-name">Nora S. Vans <small class="contacts-list-date float-right">2/10/2015</small></span>
                <span class="contacts-list-msg">Where is your new...</span>
            </div>
        </a></li>
        <li><a href="#">
            <img class="contacts-list-img" src="dist/img/user6-128x128.jpg">
            <div class="contacts-list-info">
                <span class="contacts-list-name">John K. <small class="contacts-list-date float-right">1/27/2015</small></span>
                <span class="contacts-list-msg">Can I take a look at...</span>
            </div>
        </a></li>
        <li><a href="#">
            <img class="contacts-list-img" src="dist/img/user8-128x128.jpg">
            <div class="contacts-list-info">
                <span class="contacts-list-name">Kenneth M. <small class="contacts-list-date float-right">1/4/2015</small></span>
                <span class="contacts-list-msg">Never mind I found...</span>
            </div>
        </a></li>
    </ul>
</div>
</template>
<script>
</script>