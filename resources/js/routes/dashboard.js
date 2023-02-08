import Vue from 'vue';
import VueRouter from 'vue-router';


import DashboardMain        from '../dashboard/Main.vue';
import DashboardBirthday    from '../dashboard/Birthday.vue';
import DashboardChat        from '../dashboard/Chat.vue';
import DashboardNewStaff    from '../dashboard/NewStaff.vue';
import DashboardNotice      from '../dashboard/Notice.vue';
import DashboardStaffMonth  from '../dashboard/StaffMonth.vue';
import DashboardSummary     from '../dashboard/Summary.vue';
import DashboardTicket      from '../dashboard/Ticket.vue';

Vue.component('DashboardMain',          DashboardMain);
Vue.component('DashboardBirthday',      DashboardBirthday);
Vue.component('DashboardChat',          DashboardChat);
Vue.component('DashboardNewStaff',      DashboardNewStaff);
Vue.component('DashboardNotice',        DashboardNotice);
Vue.component('DashboardStaffMonth',    DashboardStaffMonth);
Vue.component('DashboardSummary',       DashboardSummary);
Vue.component('DashboardTicket',        DashboardTicket);


let routes = [ 
    {path: '/home',             component: DashboardMain},
    {path: '/dashboard',        component: DashboardMain},
];


export default routes