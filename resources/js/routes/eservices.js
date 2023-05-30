import Vue from 'vue';
import VueRouter from 'vue-router';

import EServiceCertificate           from '../eservices/certificates/Certificate.vue';
import EServiceCertificateBioData    from '../eservices/certificates/BioData.vue';
import EServiceCertificateFooter     from '../eservices/certificates/Footer.vue';
import EServiceCertificateHeader     from '../eservices/certificates/Header.vue';
import EServiceCertificateSummary    from '../eservices/certificates/Summary.vue';
import EServiceCertificateSummaryKid from '../eservices/certificates/SummaryKid.vue';
import EServiceCertificateSummaryLab from '../eservices/certificates/SummaryLab.vue';

import EServiceFrontAppointment      from '../eservices/front/Appointment.vue';
import EServiceFrontAppointments     from '../eservices/front/Appointments.vue';
import EServiceFrontCertificates     from '../eservices/front/Certificates.vue';
import EServiceFrontMissed           from '../eservices/front/Missed.vue';
import EServiceFrontPatients         from '../eservices/front/Patients.vue';
import EServicePayments              from '../eservices/front/Payments.vue';
import EServiceRadiographer          from '../eservices/front/Radiographer.vue';

import EServiceFrontAdminAppointments from '../eservices/front_admin/Appointments.vue';

import EServiceDocConsultation       from '../eservices/doctor/Consultation.vue';
import EServiceDocConsultations      from '../eservices/doctor/Consultations.vue';
import EServiceDocConsentView        from '../eservices/doctor/ConsentView.vue';
import EServiceDocConsultationView   from '../eservices/doctor/ConsultationView.vue';
import EServiceDocIssueView          from '../eservices/doctor/IssueView.vue';
//import EServiceDocLaboratory         from '../eservices/doctor/Laboratory.vue';
import EServiceDocLaboratoryView     from '../eservices/doctor/LaboratoryView.vue';
import EServiceDocPatientView        from '../eservices/doctor/PatientView.vue';
import EServiceDocReportView         from '../eservices/doctor/ReportView.vue';
import EServiceDocReviews            from '../eservices/doctor/Reviews.vue';
import EServiceDocView               from '../eservices/doctor/View.vue';

import EServiceRadReport             from '../eservices/radiologist/Report.vue';
import EServiceRadReports            from '../eservices/radiologist/Reports.vue';
import EServiceRadReviews            from '../eservices/radiologist/Reviews.vue';

    import EServiceFormAppointment      from '../eservices/front/forms/Appointment.vue';
    import EServiceFormArrival          from '../eservices/front/forms/Arrival.vue';
    import EServiceFormPayment          from '../eservices/front/forms/Payment.vue';
    import EserviceFormPatient          from '../eservices/front/forms/Patient.vue';
    import EServiceFormDirect           from '../eservices/front/forms/Direct.vue';
    import EServiceFormSearch           from '../eservices/front/forms/Search.vue';

    import EServiceDocFormConsent              from '../eservices/doctor/forms/Consent.vue';
    import EServiceDocFormIssue                from '../eservices/doctor/forms/Issue.vue';
    import EServiceDocFormLaboratory           from '../eservices/doctor/forms/Laboratory.vue';
    import EServiceDocFormScreening            from '../eservices/doctor/forms/Screening.vue';

    import EServiceRadFormReport            from '../eservices/radiologist/forms/Report.vue';
    

Vue.component('EServiceCertificate',             EServiceCertificate);
Vue.component('EServiceCertificateBioData',      EServiceCertificateBioData);
Vue.component('EServiceCertificateHeader',       EServiceCertificateHeader);
Vue.component('EServiceCertificateFooter',       EServiceCertificateFooter);
Vue.component('EServiceCertificateSummary',      EServiceCertificateSummary);
Vue.component('EServiceCertificateSummaryKid',   EServiceCertificateSummaryKid);
Vue.component('EServiceCertificateSummaryLab',   EServiceCertificateSummaryLab);


Vue.component('EServiceFrontAppointment',        EServiceFrontAppointment);
Vue.component('EServiceFrontAppointments',       EServiceFrontAppointments);
Vue.component('EServiceFrontCertificates',       EServiceFrontCertificates);
Vue.component('EServiceFrontPatients',           EServiceFrontPatients);
Vue.component('EServiceFrontMissed',             EServiceFrontMissed);
Vue.component('EServicePayments',                EServicePayments);

Vue.component('EServiceFrontAdminAppointments',  EServiceFrontAdminAppointments);

Vue.component('EServiceDocConsultation',         EServiceDocConsultation);
Vue.component('EServiceDocConsultations',        EServiceDocConsultations);
Vue.component('EServiceDocConsentView',          EServiceDocConsentView);
Vue.component('EServiceDocConsultationView',     EServiceDocConsultationView);
Vue.component('EServiceDocIssueView',            EServiceDocIssueView);
//Vue.component('EServiceDocLaboratory',           EServiceDocLaboratory); 
Vue.component('EServiceDocLaboratoryView',       EServiceDocLaboratoryView); 
Vue.component('EServiceDocPatientView',          EServiceDocPatientView); 
Vue.component('EServiceDocReportView',           EServiceDocReportView); 
Vue.component('EServiceDocReviews',              EServiceDocReviews);
Vue.component('EServiceDocView',                 EServiceDocView);

Vue.component('EServiceRadReport',               EServiceRadReport);
Vue.component('EServiceRadReports',              EServiceRadReports);
Vue.component('EServiceRadReviews',              EServiceRadReviews);

    Vue.component('EServiceFormAppointment',     EServiceFormAppointment);
    Vue.component('EServiceFormArrival',         EServiceFormArrival);
    Vue.component('EServiceFormDirect',          EServiceFormDirect);
    Vue.component('EServiceFormPatient',         EserviceFormPatient);
    Vue.component('EServiceFormPayment',         EServiceFormPayment);
    Vue.component('EServiceFormSearch',          EServiceFormSearch);

    Vue.component('EServiceDocFormConsent',      EServiceDocFormConsent);
    Vue.component('EServiceDocFormIssue',        EServiceDocFormIssue);
    Vue.component('EServiceDocFormLaboratory',   EServiceDocFormLaboratory);
    Vue.component('EServiceDocFormScreening',    EServiceDocFormScreening);

    Vue.component('EServiceRadFormReport',       EServiceRadFormReport);


let routes = [
    //EServices Links   
    {path: '/eservices/certificate/:id',                component:EServiceCertificate},
    {path: '/eservices/doctor',                         component:EServiceDocConsultations},
    {path: '/eservices/doctor/consultations',           component:EServiceDocConsultations},
    {path: '/eservices/doctor/consultation/:id',        component:EServiceDocConsultation},
    //{path: '/eservices/doctor/laboratory',              component:EServiceDocLaboratory},
    {path: '/eservices/doctor/reviews',                 component:EServiceDocReviews},
    
    {path: '/eservices/front_admin',                    component:EServiceFrontAdminAppointments},
    {path: '/eservices/front_admin/appointments',       component:EServiceFrontAdminAppointments},
    {path: '/eservices/front_admin/appointments/missed',component:EServiceFrontMissed},
    {path: '/eservices/front_admin/applicants',         component:EServiceFrontPatients},
    
    {path: '/eservices/front_office',                   component:EServiceFrontAppointments},
    {path: '/eservices/front_office/appointments',      component:EServiceFrontAppointments},
    {path: '/eservices/front_office/appointment/:id',   component:EServiceFrontAppointment},
    {path: '/eservices/front_office/payments',          component:EServicePayments},
    {path: '/eservices/front_office/radiographer',      component:EServiceRadiographer},
    {path: '/eservices/front_office/Certificates',      component:EServiceFrontCertificates},

    {path: '/eservices/radiologist',                    component:EServiceRadReports},
    {path: '/eservices/radiologist/reports',            component:EServiceRadReports},
    {path: '/eservices/radiologist/reviews',            component:EServiceRadReviews},
    {path: '/eservices/radiologist/report/:id',         component:EServiceRadReport},
];

export default routes 