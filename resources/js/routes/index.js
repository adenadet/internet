import Vue from 'vue';
import VueRouter from 'vue-router';

//import applicant from './applicant';
import chats from './chats';
import contacts from './contacts';
//import domiciliary from './domiciliary';
import eservices from './eservices';
//import hims from './hims';
//import hr from './hr';
import learn from './learn';
import notices from './notices';

//import operations from './operations';
import policies from './policies';
import profile from './profile';
import settings from './settings';
import ticketing from './ticketing';
import ums from './ums';

const baseRoutes = [];
const routes = baseRoutes.concat(
    chats,
    contacts,
    eservices,
    //hims, 
    //hr, 
    learn,
    notices, 
    policies,
    profile,
    settings,
    ticketing,
    ums,
    );

const router = new VueRouter({
    mode: 'history',
    routes
})

export default router