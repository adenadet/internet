import Vue from 'vue';
import VueRouter from 'vue-router';

import EServiceCertificate           from '../eservices/certificates/Certificate.vue';
import EServiceCertificateBioData    from '../eservices/certificates/BioData.vue';
import EServiceCertificateFooter     from '../eservices/certificates/Footer.vue';
import EServiceCertificateHeader     from '../eservices/certificates/Header.vue';
import EServiceCertificateSummary    from '../eservices/certificates/Summary.vue';
import EServiceCertificateSummaryKids from '../eservices/certificates/SummaryKids.vue';

import EServiceFormDirect           from '../eservices/front/forms/Direct.vue';

Vue.component('EServiceCertificate',             EServiceCertificate);
Vue.component('EServiceCertificateBioData',      EServiceCertificateBioData);
Vue.component('EServiceCertificateHeader',       EServiceCertificateHeader);
Vue.component('EServiceCertificateFooter',       EServiceCertificateFooter);
Vue.component('EServiceCertificateSummary',      EServiceCertificateSummary);
Vue.component('EServiceCertificateSummaryKids',  EServiceCertificateSummaryKids);

Vue.component('EServiceFormDirect',          EServiceFormDirect);

let routes = [
    {path:'/certificate/:id', component: EServiceCertificate},
    {path:'/uk-tb-screening', component: EServiceFormDirect},
];


export default routes