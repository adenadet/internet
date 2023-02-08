import Vue from 'vue';
import VueRouter from 'vue-router';

import ChatContacts             from '../chats/Contacts.vue';
import ChatList                 from '../chats/List.vue';
import ChatMain                 from '../chats/Main.vue';
import ChatMessages             from '../chats/Messages.vue';
import ChatPrivate              from '../chats/Private.vue';

    import ChatFormInput        from '../chats/forms/Input.vue';
    import ChatFormContactList  from '../chats/forms/ContactList.vue';

Vue.component('ChatContacts', ChatContacts);
Vue.component('ChatList', ChatList);
Vue.component('ChatMain', ChatMain);
Vue.component('ChatMessages', ChatMessages);
Vue.component('ChatPrivate', ChatPrivate);

    Vue.component('ChatFormInput', ChatFormInput);
    Vue.component('ChatFormContactList', ChatFormContactList);

let routes = [
    {path: '/chats',            component: ChatMain},
    {path: '/chats/private',    component: ChatMain},
];

export default routes