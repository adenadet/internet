import Vue from 'vue';
import VueRouter from 'vue-router';

import BranchAdmin          from '../branches/Admin.vue';
import BranchAll            from '../branches/All.vue';
import BranchForm           from '../branches/Form.vue';
import BranchSingle         from '../branches/Single.vue';

Vue.component('BranchAdmin', BranchAdmin);
Vue.component('BranchAll', BranchAll);
Vue.component('BranchForm', BranchForm);
Vue.component('BranchSingle', BranchSingle);

import DepartmentAdmin     from '../departments/Admin.vue';
import DepartmentAll       from '../departments/All.vue';
import DepartmentForm      from '../departments/Form.vue';
import DepartmentSingle    from '../departments/Single.vue';

Vue.component('DepartmentAdmin',        DepartmentAdmin);
Vue.component('DepartmentAll',          DepartmentAll);
Vue.component('DepartmentForm',         DepartmentForm);
Vue.component('DepartmentSingle',       DepartmentSingle);

let routes = [
    {path: '/branches',         component: BranchAll},
    {path: '/branches/:id',     component: BranchSingle},

    {path: '/departments',       component:DepartmentAll},
    {path: '/departments/:id',   component:DepartmentSingle},

    {path: '/settings/branches',        component: BranchAdmin},
    {path: '/settings/departments',     component: DepartmentAdmin},

];

export default routes