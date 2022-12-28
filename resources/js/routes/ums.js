import Vue from 'vue';
import VueRouter from 'vue-router';

import AllRoles from '../users/AllRoles.vue';    
import AllUsers from '../users/AllUsers.vue';    

import UserFormAssignRole   from '../users/forms/AssignRole.vue';    
import UserFormNOK          from '../users/forms/NextOfKin.vue'; 
import UserFormRole         from '../users/forms/Role.vue';    
import UserFormUser         from '../users/forms/BioData.vue'; 

Vue.component('AllRoles',           AllRoles);
Vue.component('AllUsers',           AllUsers);
Vue.component('UserFormAssignRole', UserFormAssignRole);
Vue.component('UserFormNOK',        UserFormNOK);
Vue.component('UserFormRole',       UserFormRole);
Vue.component('UserFormUser',       UserFormUser);


let routes = [
    //User Module
    {path: '/users', component: AllUsers},
    {path: '/users/all', component: AllUsers},
    {path: '/users/roles', component: AllRoles},
];

export default routes