import Vue from 'vue';
import VueRouter from 'vue-router';

import SOMAdmin             from '../som/Admin.vue';
import SOMCloseNominations  from '../som/CloseNominations.vue';
import SOMCloseVoting       from '../som/CloseVoting.vue';
import SOMCloseWinners      from '../som/CloseWinners.vue';
import SOMDetail            from '../som/Detail.vue';
import SOMNominate          from '../som/Nominate.vue'; 
import SOMOpen              from '../som/Open.vue'; 
import SOMView              from '../som/View.vue';
import SOMVote              from '../som/Vote.vue';
import SOMWinners           from '../som/Winners.vue';

    import SOMFormMonth    from '../som/forms/Month.vue';

Vue.component('SOMAdmin', SOMAdmin);
Vue.component('SOMCloseNominations', SOMCloseNominations);
Vue.component('SOMCloseVoting', SOMCloseVoting);
Vue.component('SOMCloseWinners', SOMCloseWinners);
Vue.component('SOMDetail', SOMDetail);
Vue.component('SOMNominate', SOMNominate);
Vue.component('SOMView',     SOMView);
Vue.component('SOMVote',     SOMVote);
Vue.component('SOMVote',     SOMVote);

    Vue.component('SOMFormMonth', SOMFormMonth);


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