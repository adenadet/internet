import Vue from 'vue';
import VueRouter from 'vue-router';

import Profile from '../profile/Profile.vue';
import PMFormBioData from '../profile/forms/BioData.vue';
import PMFormNOK from '../profile/forms/NextOfKin.vue';
import PMFormPassword from '../profile/forms/Password.vue';


Vue.component('Profile',        Profile);
Vue.component('PMFormBioData',  PMFormBioData);
Vue.component('PMFormNOK',      PMFormNOK);
Vue.component('PMFormPassword', PMFormPassword);
let routes = [
    {path: '/profile', component: Profile},
];

export default routes