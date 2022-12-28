import Vue from 'vue';
import VueRouter from 'vue-router';

import PoliciesAdmin        from '../policies/Admin.vue';
import PoliciesDept         from '../policies/Departmental.vue';
import PoliciesGen          from '../policies/General.vue';
import PoliciesView         from '../policies/View.vue';

import PoliciesForm         from '../policies/form/New.vue';
import PoliciesFormAssign   from '../policies/form/Assign.vue';

Vue.component('PoliciesAdmin',       PoliciesAdmin);
Vue.component('PoliciesDept',        PoliciesDept);
Vue.component('PoliciesGen',         PoliciesGen);
Vue.component('PoliciesView',        PoliciesView);

Vue.component('PoliciesForm',        PoliciesForm);
Vue.component('PoliciesFormAssign',  PoliciesFormAssign);

let routes = [
    {path: '/policies',             component: PoliciesDept},
    {path: '/policies/department',  component: PoliciesDept},
    {path: '/policies/general',     component: PoliciesGen},
    {path: '/policies/admin',       component: PoliciesAdmin},
    {path: '/policies/view/:id',    component: PoliciesView},
]


export default routes