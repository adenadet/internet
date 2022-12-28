import Vue from 'vue';
import VueRouter from 'vue-router';

import ContactAll       from '../contacts/All.vue';
import ContactSingle    from '../contacts/Single.vue';
import ContactStaff     from '../contacts/Staff.vue';

Vue.component('ContactAll',     ContactAll);
Vue.component('ContactSingle',  ContactSingle);
Vue.component('ContactStaff',   ContactStaff);

let routes = [
    {path: '/contacts',           component:ContactAll},
    {path: '/contacts/staff/:id', component:ContactStaff},
];

export default routes