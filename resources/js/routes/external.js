import Vue from 'vue';
import VueRouter from 'vue-router';

import EServiceCertificate           from '../eservices/certificates/Certificate.vue';
import EServiceCertificateBioData    from '../eservices/certificates/BioData.vue';
import EServiceCertificateFooter     from '../eservices/certificates/Footer.vue';
import EServiceCertificateHeader     from '../eservices/certificates/Header.vue';
import EServiceCertificateSummary    from '../eservices/certificates/Summary.vue';
import EServiceCertificateSummaryKid from '../eservices/certificates/SummaryKid.vue';
import EServiceCertificateSummaryLab from '../eservices/certificates/SummaryLab.vue';

import EServiceDetailPolicy          from '../eservices/front/details/Policy.vue';

import EServiceFormCancellation      from '../eservices/front/forms/Cancellation.vue';
import EServiceFormDirect            from '../eservices/front/forms/Direct.vue';
import EServiceFormReschedule        from '../eservices/front/forms/Reschedule.vue';

Vue.component('EServiceCertificate',            EServiceCertificate);
Vue.component('EServiceCertificateBioData',     EServiceCertificateBioData);
Vue.component('EServiceCertificateHeader',      EServiceCertificateHeader);
Vue.component('EServiceCertificateFooter',      EServiceCertificateFooter);
Vue.component('EServiceCertificateSummary',     EServiceCertificateSummary);
Vue.component('EServiceCertificateSummaryKid',  EServiceCertificateSummaryKid);
Vue.component('EServiceCertificateSummaryLab',  EServiceCertificateSummaryLab);

Vue.component('EServiceDetailPolicy',           EServiceDetailPolicy);

Vue.component('EServiceFormCancellation',       EServiceFormCancellation);
Vue.component('EServiceFormDirect',             EServiceFormDirect);
Vue.component('EServiceFormReschedule',         EServiceFormReschedule);

let routes = [
    {path:'/certificates/:id',      component: EServiceCertificate},
    {path:'/uk-tb-cancellation',    component: EServiceFormCancellation},
    {path:'/uk-tb-reschedule',      component: EServiceFormReschedule},
    {path:'/uk-tb-screening',       component: EServiceFormDirect},
];


export default routes