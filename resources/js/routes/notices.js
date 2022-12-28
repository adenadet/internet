import Vue from 'vue';
import VueRouter from 'vue-router';

import NoticeAdmin      from '../notices/Admin.vue';
import NoticeAll      from '../notices/All.vue';
import NoticeSingle from '../notices/Single.vue';

Vue.component('NoticeAll',        NoticeAll);
Vue.component('NoticeAdmin',      NoticeAdmin);
Vue.component('NoticeSingle',     NoticeSingle);

    import NoticeClose   from '../notices/forms/Close.vue';
    import NoticeForm    from '../notices/forms/New.vue';

    Vue.component('NoticeClose',     NoticeClose);
    Vue.component('NoticeForm',      NoticeForm);


let routes = [
    {path: '/notices',          component: NoticeAll},
    {path: '/notices/admin',    component: NoticeAdmin},
    {path: '/notices/:id',      component: NoticeSingle},
];

export default routes