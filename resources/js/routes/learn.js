import Vue from 'vue';
import VueRouter from 'vue-router';

//LMS Module 
    //Admin Area
    import AdminCategories  from '../learn/admins/Categories.vue';
    import AdminCourse      from '../learn/admins/Course.vue';
    import AdminCourses     from '../learn/admins/Courses.vue';
    import AdminExam        from '../learn/admins/Exam.vue';
    import AdminExams       from '../learn/admins/Exams.vue';
    import AdminExamResult  from '../learn/admins/ExamResult.vue';
    import AdminExamResults from '../learn/admins/ExamResults.vue';
    import AdminLesson      from '../learn/admins/Lesson.vue';
    import AdminResult      from '../learn/admins/Result.vue';
    import AdminSubCategory from '../learn/admins/SubCategory.vue'; 

    Vue.component('AdminCategories',    AdminCategories);
    Vue.component('AdminCourse',        AdminCourse);
    Vue.component('AdminCourses',       AdminCourses);
    Vue.component('AdminExam',          AdminExam);
    Vue.component('AdminExams',         AdminExams);
    Vue.component('AdminLesson',        AdminLesson);
    Vue.component('AdminSubCategory',   AdminSubCategory);


    //Student Area
    import StudentCourse                from    '../learn/students/Course.vue';
    import StudentCourses               from    '../learn/students/Courses.vue';
    import StudentExams                 from    '../learn/students/Exams.vue';
    import StudentLesson                from    '../learn/students/Lesson.vue';
    import StudentLessonDetail          from    '../learn/students/LessonDetail.vue';
    import StudentResult                from    '../learn/students/Result.vue';
    import StudentResults               from    '../learn/students/Results.vue';

    Vue.component('StudentCourse',          StudentCourse);
    Vue.component('StudentCourses',         StudentCourses);
    Vue.component('StudentExams',           StudentExams);
    Vue.component('StudentLesson',          StudentLesson);
    Vue.component('StudentLessonDetail',    StudentLessonDetail);

    //Tutor Area 
    import TutorCourse    from '../learn/tutors/Course.vue';
    import TutorCourses   from '../learn/tutors/Courses.vue';
    import TutorExams     from '../learn/tutors/Exams.vue';
    import TutorLesson    from '../learn/tutors/Lesson.vue';
    import TutorLessons   from '../learn/tutors/Lessons.vue';
    import TutorResult    from '../learn/tutors/Lesson.vue';

    Vue.component('TutorCourse',        TutorCourse);
    Vue.component('TutorCourses',       TutorCourses);
    Vue.component('TutorExams',         TutorExams);
    Vue.component('TutorLessons',       TutorLessons);
    //Vue.component('TutorResult',        TutorResults);

    //Forms
    import LmsFormAssignTutor   from '../learn/forms/AssignTutor.vue';
    import LmsFormAssignUser    from '../learn/forms/AssignUser.vue';
    import LmsFormCategory      from '../learn/forms/Category.vue';
    import LmsFormCourse        from '../learn/forms/Course.vue';
    import LmsFormExam          from '../learn/forms/Exam.vue';
    import LmsFormLesson        from '../learn/forms/Lesson.vue';
    import LmsFormLessons       from '../learn/forms/Lessons.vue';
    import LmsFormOption        from '../learn/forms/Option.vue';
    import LmsFormQuestion      from '../learn/forms/Question.vue';
    import LmsFormSubCategory   from '../learn/admins/forms/SubCategory.vue';

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

let routes = [
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

    //{path: '/student_area/exams', component: LmsStdExams},
    //{path: '/student_area/lesson/:id', component: LmsStdLesson},
    //{path: '/tutor_area/courses', component: LmsTutCourses},
    //{path: '/tutor_area/exams', component: LmsTutExams},
];

export default routes