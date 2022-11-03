import Vue from 'vue';
import VueRouter from 'vue-router';
//Applicant Component
import ApplicantAppointment       from './applicants/Appointment.vue';
import ApplicantAppointments      from './applicants/Appointments.vue';
import ApplicantDashboard         from './applicants/Dashboard.vue';
import ApplicantPayment           from './applicants/Payment.vue';
import ApplicantPayments          from './applicants/Payments.vue';
import ApplicantProfile           from './applicants/Profile.vue';
import ApplicantTicket            from './applicants/Ticket.vue';
import ApplicantTickets           from './applicants/Tickets.vue';

    import ApplicantDetailsForm         from './applicants/forms/Details.vue';
    
    import ApplicantAppointmentForm     from './eservices/front/forms/Appointment.vue';
    import ApplicantPaymentForm         from './eservices/front/forms/Payment.vue';

Vue.component('ApplicantAppointment',          ApplicantAppointment);
Vue.component('ApplicantAppointments',         ApplicantAppointments);
Vue.component('ApplicantDashboard',            ApplicantDashboard);
Vue.component('ApplicantPayment',              ApplicantPayment);
Vue.component('ApplicantPayments',             ApplicantPayments);
Vue.component('ApplicantProfile',              ApplicantProfile);
    
    Vue.component('ApplicantDetailsForm',      ApplicantDetailsForm);
    Vue.component('ApplicantAppointmentForm',  ApplicantAppointmentForm);
    Vue.component('ApplicantPaymentForm',      ApplicantPaymentForm);


//Chat Components
import BranchAdmin  from './branches/Admin.vue';
import BranchAll  from './branches/All.vue';
import BranchForm  from './branches/Form.vue';
import BranchSingle  from './branches/Single.vue';

Vue.component('BranchAdmin', BranchAdmin);
Vue.component('BranchAll', BranchAll);
Vue.component('BranchForm', BranchForm);
Vue.component('BranchSingle', BranchSingle);

import ChatContacts from './chats/Contacts.vue';
import ChatList from './chats/List.vue';
import ChatMain from './chats/Main.vue';
import ChatMessages from './chats/Messages.vue';
import ChatPrivate  from './chats/Private.vue';

    import ChatFormInput        from './chats/forms/Input.vue';
    import ChatFormContactList  from './chats/forms/ContactList.vue';

Vue.component('ChatContacts', ChatContacts);
Vue.component('ChatList', ChatList);
Vue.component('ChatMain', ChatMain);
Vue.component('ChatMessages', ChatMessages);
Vue.component('ChatPrivate', ChatPrivate);

    Vue.component('ChatFormInput', ChatFormInput);
    Vue.component('ChatFormContactList', ChatFormContactList);

import ContactAll       from './contacts/All.vue';
import ContactSingle    from './contacts/Single.vue';
import ContactStaff     from './contacts/Staff.vue';

Vue.component('ContactAll',     ContactAll);
Vue.component('ContactSingle',  ContactSingle);
Vue.component('ContactStaff',   ContactStaff);

import DashboardMain        from './dashboard/Main.vue';
import DashboardBirthday    from './dashboard/Birthday.vue';
import DashboardChat        from './dashboard/Chat.vue';
import DashboardNewStaff    from './dashboard/NewStaff.vue';
import DashboardNotice      from './dashboard/Notice.vue';
import DashboardStaffMonth  from './dashboard/StaffMonth.vue';
import DashboardSummary     from './dashboard/Summary.vue';
import DashboardTicket      from './dashboard/Ticket.vue';

Vue.component('DashboardMain',          DashboardMain);
Vue.component('DashboardBirthday',      DashboardBirthday);
Vue.component('DashboardChat',          DashboardChat);
Vue.component('DashboardNewStaff',      DashboardNewStaff);
Vue.component('DashboardNotice',        DashboardNotice);
Vue.component('DashboardStaffMonth',    DashboardStaffMonth);
Vue.component('DashboardSummary',       DashboardSummary);
Vue.component('DashboardTicket',        DashboardTicket);

import DepartmentAdmin     from './departments/Admin.vue';
import DepartmentAll       from './departments/All.vue';
import DepartmentForm      from './departments/Form.vue';
import DepartmentSingle    from './departments/Single.vue';

Vue.component('DepartmentAdmin',        DepartmentAdmin);
Vue.component('DepartmentAll',          DepartmentAll);
Vue.component('DepartmentForm',         DepartmentForm);
Vue.component('DepartmentSingle',       DepartmentSingle);

import EServiceCertificate           from './eservices/Certificate.vue';

import EServiceFrontAppointment      from './eservices/front/Appointment.vue';
import EServiceFrontAppointments     from './eservices/front/Appointments.vue';
import EServiceFrontCertificates     from './eservices/front/Certificates.vue';
import EServiceFrontPatients         from './eservices/front/Patients.vue';
import EServicePayments              from './eservices/front/Payments.vue';

import EServiceDocConsultation       from './eservices/doctor/Consultation.vue';
import EServiceDocConsultations      from './eservices/doctor/Consultations.vue';
import EServiceDocConsentView        from './eservices/doctor/ConsentView.vue';
import EServiceDocConsultationView   from './eservices/doctor/ConsultationView.vue';
import EServiceDocReportView         from './eservices/doctor/ReportView.vue';
import EServiceDocReviews            from './eservices/doctor/Reviews.vue';
import EServiceDocView               from './eservices/doctor/View.vue';

import EServiceRadReport             from './eservices/radiologist/Report.vue';
import EServiceRadReports            from './eservices/radiologist/Reports.vue';
import EServiceRadReviews            from './eservices/radiologist/Reviews.vue';

    import EServiceFormAppointment      from './eservices/front/forms/Appointment.vue';
    import EServiceFormPayment          from './eservices/front/forms/Payment.vue';
    import EserviceFormPatient          from './eservices/front/forms/Patient.vue';

    import EServiceDocFormConsent              from './eservices/doctor/forms/Consent.vue';
    import EServiceDocFormScreening            from './eservices/doctor/forms/Screening.vue';

    import EServiceRadFormReport            from './eservices/radiologist/forms/Report.vue';

Vue.component('EServiceCertificate',             EServiceCertificate);
Vue.component('EServiceFrontAppointment',        EServiceFrontAppointment);
Vue.component('EServiceFrontAppointments',       EServiceFrontAppointments);
Vue.component('EServiceFrontCertificates',       EServiceFrontCertificates);
Vue.component('EServiceFrontPatients',           EServiceFrontPatients);
Vue.component('EServicePayments',                EServicePayments);

Vue.component('EServiceDocConsultation',         EServiceDocConsultation);
Vue.component('EServiceDocConsultations',        EServiceDocConsultations);
Vue.component('EServiceDocConsentView',          EServiceDocConsentView);
Vue.component('EServiceDocConsultationView',     EServiceDocConsultationView);
Vue.component('EServiceDocReportView',           EServiceDocReportView); 
Vue.component('EServiceDocReviews',              EServiceDocReviews);
Vue.component('EServiceDocView',                 EServiceDocView);

Vue.component('EServiceRadReport',               EServiceRadReport);
Vue.component('EServiceRadReports',              EServiceRadReports);
Vue.component('EServiceRadReviews',              EServiceRadReviews);

    Vue.component('EServiceFormAppointment',     EServiceFormAppointment);
    Vue.component('EServiceFormPatient',         EserviceFormPatient);
    Vue.component('EServiceFormPayment',         EServiceFormPayment);

    Vue.component('EServiceDocFormConsent',      EServiceDocFormConsent);
    Vue.component('EServiceDocFormScreening',    EServiceDocFormScreening);

    Vue.component('EServiceRadFormReport',       EServiceRadFormReport);

import Users from './components/Users.vue';

//Declare Partials
import DetailLoansAccount from './components/partials/details/LoansAccount.vue';
import DetailSavingsAccount from './components/partials/details/SavingsAccount.vue';

//Declare Form Components  
import FormBioData from './components/partials/forms/BioData.vue';
import FormClosure from './components/partials/forms/Closure.vue';
import FormContact from './components/partials/forms/Contact.vue';
import FormNextOfKin from './components/partials/forms/NextOfKin.vue';
import FormRepayment from './components/partials/forms/Repayment.vue';
import FormSavingsAccount from './components/partials/forms/SavingsAccount.vue';
import FormSecurity from './components/partials/forms/Security.vue';
import FormWithdrawal from './components/partials/forms/Withdrawal.vue';


//Declare LMS Pages
import LmsCategories from './components/lms/admin/Categories.vue';
import LmsCertificates from './components/lms/admin/Certificates.vue';
import LmsCourses from './components/lms/admin/Courses.vue';
import LmsExams from './components/lms/admin/Exams.vue';

import LmsStdCourse from './components/lms/student/Course.vue';
import LmsStdCourses from './components/lms/student/Courses.vue';
import LmsStdExams from './components/lms/student/Exams.vue';
//import LmsStdLesson from './components/lms/student/Lesson.vue';

import LmsTutCourses from './components/lms/tutors/Courses.vue';
import LmsTutExams from './components/lms/tutors/Exams.vue';

//Declare LMS Details
import LmsDetailContact from './components/lms/details/Contact.vue';
import LmsDetailCourse from './components/lms/details/Course.vue';
import LmsDetailCourseAssignedTo from './components/lms/details/CourseAssignees.vue';
import LmsDetailCourseLessons from './components/lms/details/CourseLessons.vue';
import LmsDetailQuestions from './components/lms/details/Questions.vue';
import LmsDetailSubCategory from './components/lms/details/SubCategory.vue';

Vue.component('Users', Users);

//All Details are declared here
Vue.component('DetailLoansAccount', DetailLoansAccount)
Vue.component('DetailSavingsAccount', DetailSavingsAccount)

//All Forms are declared here
Vue.component('FormBioData', FormBioData);
Vue.component('FormClosure', FormClosure);
Vue.component('FormContact', FormContact);
Vue.component('FormNextOfKin', FormNextOfKin);
Vue.component('FormSecurity', FormSecurity);

//Declare All LMS pages
Vue.component('LmsCategories', LmsCategories);
Vue.component('LmsCertificates', LmsCertificates);
Vue.component('LmsCourses', LmsCourses);
Vue.component('LmsExams', LmsExams);

Vue.component('LmsStdCourse', LmsStdCourse);
Vue.component('LmsStdCourses', LmsStdCourses);
Vue.component('LmsStdExams', LmsStdExams);
//Vue.component('LmsStdLesson', LmsStdLesson);

Vue.component('LmsTutCourses', LmsTutCourses);
Vue.component('LmsTutExams', LmsTutExams);

//Declare All LMS Details
Vue.component('LmsDetailContact', LmsDetailContact);
Vue.component('LmsDetailCourse', LmsDetailCourse);
Vue.component('LmsDetailCourseAssignedTo', LmsDetailCourseAssignedTo);
Vue.component('LmsDetailCourseLessons', LmsDetailCourseLessons);
Vue.component('LmsDetailQuestions', LmsDetailQuestions);
Vue.component('LmsDetailSubCategory', LmsDetailSubCategory);

//LMS Module 
    //Admin Area
    import AdminCategories  from './learn/admins/Categories.vue';
    import AdminCourse      from './learn/admins/Course.vue';
    import AdminCourses     from './learn/admins/Courses.vue';
    import AdminExam        from './learn/admins/Exam.vue';
    import AdminExams       from './learn/admins/Exams.vue';
    import AdminExamResult  from './learn/admins/ExamResult.vue';
    import AdminExamResults from './learn/admins/ExamResults.vue';
    import AdminLesson      from './learn/admins/Lesson.vue';
    import AdminResult      from './learn/admins/Result.vue';
    import AdminSubCategory from './learn/admins/SubCategory.vue'; 

    Vue.component('AdminCategories',    AdminCategories);
    Vue.component('AdminCourse',        AdminCourse);
    Vue.component('AdminCourses',       AdminCourses);
    Vue.component('AdminExam',          AdminExam);
    Vue.component('AdminExams',         AdminExams);
    Vue.component('AdminLesson',        AdminLesson);
    Vue.component('AdminSubCategory',   AdminSubCategory);


    //Student Area
    import StudentCourse                from    './learn/students/Course.vue';
    import StudentCourses               from    './learn/students/Courses.vue';
    import StudentExams                 from    './learn/students/Exams.vue';
    import StudentLesson                from    './learn/students/Lesson.vue';
    import StudentLessonDetail          from    './learn/students/LessonDetail.vue';
    import StudentResult                from    './learn/students/Result.vue';
    import StudentResults               from    './learn/students/Results.vue';

    Vue.component('StudentCourse',          StudentCourse);
    Vue.component('StudentCourses',         StudentCourses);
    Vue.component('StudentExams',           StudentExams);
    Vue.component('StudentLesson',          StudentLesson);
    Vue.component('StudentLessonDetail',    StudentLessonDetail);

    //Tutor Area 
    import TutorCourse    from './learn/tutors/Course.vue';
    import TutorCourses   from './learn/tutors/Courses.vue';
    import TutorExams     from './learn/tutors/Exams.vue';
    import TutorLesson    from './learn/tutors/Lesson.vue';
    import TutorLessons   from './learn/tutors/Lessons.vue';
    import TutorResult    from './learn/tutors/Lesson.vue';

    Vue.component('TutorCourse',        TutorCourse);
    Vue.component('TutorCourses',       TutorCourses);
    Vue.component('TutorExams',         TutorExams);
    Vue.component('TutorLessons',       TutorLessons);
    //Vue.component('TutorResult',        TutorResults);

    //Forms
    import LmsFormAssignTutor   from './learn/forms/AssignTutor.vue';
    import LmsFormAssignUser    from './learn/forms/AssignUser.vue';
    import LmsFormCategory      from './learn/forms/Category.vue';
    import LmsFormCourse        from './learn/forms/Course.vue';
    import LmsFormExam          from './learn/forms/Exam.vue';
    import LmsFormLesson        from './learn/forms/Lesson.vue';
    import LmsFormLessons       from './learn/forms/Lessons.vue';
    import LmsFormOption        from './learn/forms/Option.vue';
    import LmsFormQuestion      from './learn/forms/Question.vue';
    import LmsFormSubCategory   from './learn/admins/forms/SubCategory.vue';

    Vue.component('LmsFormAssignTutor',     LmsFormAssignTutor);
    Vue.component('LmsFormAssignUser',      LmsFormAssignUser);
    Vue.component('LmsFormCategory',        LmsFormCategory);
    Vue.component('LmsFormCourse',          LmsFormCourse);
    Vue.component('LmsFormExam',            LmsFormExam);
    Vue.component('LmsFormLesson',          LmsFormLesson);
    Vue.component('LmsFormLessons',         LmsFormLessons);
    Vue.component('LmsFormOption',          LmsFormOption);
    Vue.component('LmsFormQuestion',        LmsFormQuestion);
    Vue.component('LmsFormSubCategory',     LmsFormSubCategory);

//Network Checkers
import NetworkCard      from './components/internet/Card.vue';
import NetworkDashboard from './components/internet/Dashboard.vue';

Vue.component('NetworkCard',        NetworkCard);
Vue.component('NetworkDashboard',   NetworkDashboard);

//Notice Board
import NoticeAdmin      from './notices/Admin.vue';
import NoticeAll      from './notices/All.vue';
import NoticeSingle from './notices/Single.vue';

Vue.component('NoticeAll',        NoticeAll);
Vue.component('NoticeAdmin',      NoticeAdmin);
Vue.component('NoticeSingle',     NoticeSingle);

    import NoticeClose   from './notices/forms/Close.vue';
    import NoticeForm    from './notices/forms/New.vue';

    Vue.component('NoticeClose',     NoticeClose);
    Vue.component('NoticeForm',      NoticeForm);

//Policies Components
import PoliciesAdmin        from './policies/Admin.vue';
import PoliciesDept         from './policies/Departmental.vue';
import PoliciesGen          from './policies/General.vue';
import PoliciesView         from './policies/View.vue';

import PoliciesForm         from './policies/form/New.vue';
import PoliciesFormAssign   from './policies/form/Assign.vue';

Vue.component('PoliciesAdmin',       PoliciesAdmin);
Vue.component('PoliciesDept',        PoliciesDept);
Vue.component('PoliciesGen',         PoliciesGen);
Vue.component('PoliciesView',        PoliciesView);

Vue.component('PoliciesForm',        PoliciesForm);
Vue.component('PoliciesFormAssign',  PoliciesFormAssign);

//Profile Components
import Profile from './profile/Profile.vue';
import PMFormBioData from './profile/forms/BioData.vue';
import PMFormNOK from './profile/forms/NextOfKin.vue';
import PMFormPassword from './profile/forms/Password.vue';


Vue.component('Profile',        Profile);
Vue.component('PMFormBioData',  PMFormBioData);
Vue.component('PMFormNOK',      PMFormNOK);
Vue.component('PMFormPassword', PMFormPassword);

//Social Modules Components
import SocialAlbum from './components/socials/Album.vue';
import SocialAlbums from './components/socials/Albums.vue';
import SocialDashboard from './components/socials/Dashboard.vue';
import SocialForum from './components/socials/Forum.vue';
import SocialForums from './components/socials/Forums.vue';

Vue.component('SocialAlbum',        SocialAlbum)
Vue.component('SocialAlbums',       SocialAlbums)
Vue.component('SocialDashboard',    SocialDashboard)
Vue.component('SocialForum',        SocialForum)
Vue.component('SocialForums',       SocialForums)

//Settings Modules Components
import StgCourse from './components/settings/Course.vue';
import StgCourses from './components/settings/Courses.vue';

Vue.component('StgCourse', StgCourse);
Vue.component('StgCourses', StgCourses);

//Settings Modules Components
import SOMNominate      from './som/Nominate.vue';
import SOMView          from './som/View.vue';
import SOMVote          from './som/Vote.vue';
import SOMWinners       from './som/Winners.vue';

Vue.component('SOMNominate', SOMNominate);
Vue.component('SOMView',     SOMView);
Vue.component('SOMVote',     SOMVote);
Vue.component('SOMVote',     SOMVote);

//Ticketing Module Components
import TicketAdmin      from './ticketing/Admin.vue';

import TicketDepartment from './ticketing/Department.vue';
import TicketPersonal   from './ticketing/Personal.vue';
import TicketPersonalSummary   from './ticketing/PersonalSummary.vue';
import TicketSetting     from './ticketing/Setting.vue';
import TicketSingle     from './ticketing/Single.vue';

    import TicketFormAssign     from './ticketing/forms/Assign.vue';
    import TicketFormAccept     from './ticketing/forms/Accept.vue';
    import TicketFormComplete   from './ticketing/forms/Complete.vue';
    import TicketFormNew        from './ticketing/forms/New.vue';
    import TicketFormReply      from './ticketing/forms/Reply.vue';

Vue.component('TicketAdmin',            TicketAdmin);
Vue.component('TicketDepartment',       TicketDepartment);
Vue.component('TicketPersonal',         TicketPersonal);
Vue.component('TicketPersonalSummary',  TicketPersonalSummary);
Vue.component('TicketSingle',           TicketSingle);

    Vue.component('TicketFormAccept',   TicketFormAccept);
    Vue.component('TicketFormAssign',   TicketFormAssign);
    Vue.component('TicketFormComplete', TicketFormComplete);
    Vue.component('TicketFormNew',      TicketFormNew);
    Vue.component('TicketFormReply',    TicketFormReply);

//User Modules Components
import AllRoles from './users/AllRoles.vue';    
import AllUsers from './users/AllUsers.vue';    

import UserFormAssignRole   from './users/forms/AssignRole.vue';    
import UserFormNOK          from './users/forms/NextOfKin.vue'; 
import UserFormRole         from './users/forms/Role.vue';    
import UserFormUser         from './users/forms/BioData.vue'; 

Vue.component('AllRoles',           AllRoles);
Vue.component('AllUsers',           AllUsers);
Vue.component('UserFormAssignRole', UserFormAssignRole);
Vue.component('UserFormNOK',        UserFormNOK);
Vue.component('UserFormRole',       UserFormRole);
Vue.component('UserFormUser',       UserFormUser);


let routes = [
//Applicant Module
    {path: '/',                             component: ApplicantDashboard},
    {path: '/applicants',                   component: ApplicantDashboard},
    {path: '/applicants/appointment/:id',   component: ApplicantAppointment},
    {path: '/applicants/appointments',      component: ApplicantAppointments},
    {path: '/applicants/dashboard',         component: ApplicantDashboard},
    {path: '/applicants/payments',          component: ApplicantPayments},
    {path: '/applicants/payment/:id',       component: ApplicantPayment},
    {path: '/applicants/profile',           component: ApplicantProfile},
    {path: '/applicants/tickets',           component: ApplicantTickets},
    {path: '/applicants/ticket/:id',        component: ApplicantTicket},


//Dashboard Module
    {path: '/home',             component: ApplicantDashboard},
    {path: '/dashboard',        component: DashboardMain},

//Chats Links
    {path: '/branches',         component: BranchAll},
    {path: '/branches/:id',     component: BranchSingle},

//Chats Links
    {path: '/chats',            component: ChatMain},
    {path: '/chats/private',    component: ChatMain},

//Contact Links
    {path: '/contacts',           component:ContactAll},
    {path: '/contacts/staff/:id', component:ContactStaff},

//Department Links
    {path: '/departments',       component:DepartmentAll},
    {path: '/departments/:id',   component:DepartmentSingle},

//EServices Links   
    {path: '/eservices/certificate/:id',                component:EServiceCertificate},
    {path: '/eservices/doctor',                         component:EServiceDocConsultations},
    {path: '/eservices/doctor/consultations',           component:EServiceDocConsultations},
    {path: '/eservices/doctor/consultation/:id',        component:EServiceDocConsultation},
    {path: '/eservices/doctor/reviews',                 component:EServiceDocReviews},
    
    {path: '/eservices/front_office',                   component:EServiceFrontAppointments},
    {path: '/eservices/front_office/applicants',        component:EServiceFrontPatients},
    {path: '/eservices/front_office/appointments',      component:EServiceFrontAppointments},
    {path: '/eservices/front_office/appointment/:id',   component:EServiceFrontAppointment},
    {path: '/eservices/front_office/payments',          component:EServicePayments},
    {path: '/eservices/front_office/Certificates',      component:EServiceFrontCertificates},

    {path: '/eservices/radiologist',                    component:EServiceRadReports},
    {path: '/eservices/radiologist/reports',            component:EServiceRadReports},
    {path: '/eservices/radiologist/reviews',            component:EServiceRadReviews},
    {path: '/eservices/radiologist/report/:id',         component:EServiceRadReport},

//Network Checkers Module
    {path: '/internet', component: NetworkDashboard},

//Learning Module
    //Administrator Area Sub Module
    {path: '/learn/admin_area',                 component: AdminCourses},
    {path: '/learn/admin_area/categories',      component: AdminCategories},
    {path: '/learn/admin_area/course/:id',      component: AdminCourse},
    {path: '/learn/admin_area/courses',         component: AdminCourses},
    {path: '/learn/admin_area/exam/:id',        component: AdminExam},
    {path: '/learn/admin_area/exams',           component: AdminExams},
    {path: '/learn/admin_area/exam_results',    component: AdminExamResults},
    {path: '/learn/admin_area/exam_results/:id',component: AdminExamResult},
    {path: '/learn/admin_area/exam_result/:id', component: AdminResult},
    {path: '/learn/admin_area/lesson/:id',      component: AdminLesson},
    {path: '/learn/admin_area/result/:id',      component: AdminResult},
    //{path: '/admin_area/result/:id', component: AdminResult},

    //Student Area Sub Module
    {path: '/learn/student_area',               component: StudentCourses},
    {path: '/learn/student_area/course/:id',    component: StudentCourse},
    {path: '/learn/student_area/courses',       component: StudentCourses},
    {path: '/learn/student_area/exams',         component: StudentExams},
    {path: '/learn/student_area/lesson/:id',    component: StudentLesson},
    {path: '/learn/student_area/result/:id',    component: StudentResult},
    {path: '/learn/student_area/results',       component: StudentResults},

    //Tutor Area Sub Module
    {path: '/learn/tutor_area', component: TutorCourses},
    {path: '/learn/tutor_area/course/:id', component: TutorCourse},
    {path: '/learn/tutor_area/courses', component: TutorCourses},
    {path: '/learn/tutor_area/exams', component: TutorExams},
    {path: '/learn/tutor_area/exam/:id', component: AdminExam},
    {path: '/learn/tutor_area/lesson/:id', component: TutorLesson},
    {path: '/learn/tutor_area/result/:id', component: TutorResult},

    {path: '/student_area/exams', component: LmsStdExams},
    //{path: '/student_area/lesson/:id', component: LmsStdLesson},
    {path: '/tutor_area/courses', component: LmsTutCourses},
    {path: '/tutor_area/exams', component: LmsTutExams},

//Notice Board Module
    {path: '/notices', component: NoticeAll},
    {path: '/notices/admin', component: NoticeAdmin},
    {path: '/notices/:id', component: NoticeSingle},
    //{path: '/notices', component: NoticeAll},

//Profile Module
    {path: '/policies',             component: PoliciesDept},
    {path: '/policies/department',  component: PoliciesDept},
    {path: '/policies/general',     component: PoliciesGen},
    {path: '/policies/admin',       component: PoliciesAdmin},
    {path: '/policies/view/:id',    component: PoliciesView},

//Profile Module
    {path: '/profile', component: Profile},
    
//Settings Module
    {path: '/settings/branches',        component: BranchAdmin},
    {path: '/settings/departments',     component: DepartmentAdmin},
    {path: '/settings/course/:id',      component: StgCourse},
    {path: '/settings/courses',         component: StgCourses},

//Socials Module
    {path: '/socials/album/:id',    component: SocialAlbum},
    {path: '/socials/albums',       component: SocialAlbums},
    {path: '/socials/dashboard',    component: SocialDashboard},
    {path: '/socials/forum/:id',    component: SocialForum},
    {path: '/socials/forums',       component: SocialForums},

//Staff of the Month Module
    {path: '/staff_month',                component: SOMWinners},
    {path: '/staff_month/nominate',       component: SOMNominate},
    {path: '/staff_month/view/:month',    component: SocialAlbum},
    {path: '/staff_month/vote',           component: SOMVote},
    {path: '/staff_month/winners',        component: SOMWinners},
    //{path: '/staff_month/dashboard',    component: SocialDashboard},

//Ticketing Modules
    {path: '/ticketing',                component: TicketPersonal},
    {path: '/ticketing/admin',          component: TicketAdmin},
    {path: '/ticketing/settings',       component: TicketSetting},
    {path: '/ticketing/department',     component: TicketDepartment},
    {path: '/ticketing/:id',            component: TicketSingle},

//User Module
    {path: '/users', component: AllUsers},
    {path: '/users/all', component: AllUsers},
    {path: '/users/roles', component: AllRoles},
]
    
Vue.component('formcontact', FormContact);
Vue.component('formbiodata', FormBioData);
const router = new VueRouter({ mode: 'history', routes});

export default router