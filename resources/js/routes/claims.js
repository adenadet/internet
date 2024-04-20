import Vue from 'vue';
import VueRouter from 'vue-router';

import ClaimsCuracelDashboard             from '../claims/curacel/Dashboard.vue';
import ClaimsCuracelRequest                 from '../claims/curacel/New.vue';

    //import ClaimsFormInput        from '../claims/forms/Input.vue';
    //import ClaimsFormContactList  from '../claims/forms/ContactList.vue';

Vue.component('ClaimsCuracelDashboard', ClaimsCuracelDashboard);
Vue.component('ClaimsCuracelRequest', ClaimsCuracelRequest);

let routes = [
    {path: '/claims/curacel/dashboard',             component: ClaimsCuracelDashboard},
    {path: '/claims/curacel/new_request',           component: ClaimsCuracelRequest},
];

export default routes