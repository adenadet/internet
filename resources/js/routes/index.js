import Vue from 'vue';
import VueRouter from 'vue-router';

//import applicant from './applicant';

import chats from './chats';
import claims from './claims';
import contacts from './contacts';
import dashboard from './dashboard';
//import domiciliary from './domiciliary';
import eservices from './eservices';
import external from './external';
//import hims from './hims';
//import hr from './hr';
import inventory from './inventory';
import learn from './learn';
import notices from './notices';

//import operations from './operations';
import policies from './policies';
import profile from './profile';
import settings from './settings';
import som from './som';
import ticketing from './ticketing';
import ums from './ums';

const baseRoutes = [];
const routes = baseRoutes.concat(
    chats, claims,
    contacts,
    dashboard,
    eservices,
    external,
    //hims, 
    //hr, 
    inventory,
    learn,
    notices, 
    policies,
    profile,
    settings,
    som,
    ticketing,
    ums,
    );

const router = new VueRouter({
    mode: 'history',
    routes
})

export default router