import Vue from 'vue';
import VueRouter from 'vue-router';

import SOMAdmin             from '../som/Admin.vue';
import SOMCloseNominations  from '../som/CloseNominations.vue';
import SOMCloseVoting       from '../som/CloseVoting.vue';
import SOMNominate          from '../som/Nominate.vue'; 
import SOMOpen              from '../som/Open.vue'; 
import SOMView              from '../som/View.vue';
import SOMVote              from '../som/Vote.vue';
import SOMWinners           from '../som/Winners.vue';

Vue.component('SOMAdmin', SOMAdmin);
Vue.component('SOMCloseNominations', SOMCloseNominations);
Vue.component('SOMCloseVoting', SOMCloseVoting);
Vue.component('SOMNominate', SOMNominate);
Vue.component('SOMView',     SOMView);
Vue.component('SOMVote',     SOMVote);
Vue.component('SOMVote',     SOMVote);

let routes = [

    {path: '/staff_month',                component: SOMWinners},
    {path: '/staff_month/open',          component: SOMOpen},
    {path: '/staff_month/admin',          component: SOMAdmin},
    {path: '/staff_month/nominate',       component: SOMNominate},
    //{path: '/staff_month/view/:month',    component: SocialAlbum},
    {path: '/staff_month/vote',           component: SOMVote},
    {path: '/staff_month/winners',        component: SOMWinners},
];

export default routes