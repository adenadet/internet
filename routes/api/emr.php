<?php

use Illuminate\Support\Facades\Route;
Route::group(['prefix'=>'emr'], function () {
    Route::post('/admin/summary_report',        'AdminController@summary_report')->name('administrator.summary_report');
    Route::post('/admin/detailed_report',       'AdminController@detailed_report')->name('administrator.detailed_report');
    Route::get('/appointments/initials',        'AppointmentController@initials')->name('appointments.initials');
    Route::get('/appointments/missed',          'AppointmentController@missed')->name('appointments.missed');
    Route::get('/appointments/to_doctor/{id}',  'AppointmentController@to_doctor')->name('appointments.to_doctor');
    Route::get('/appointments/certificates',    'AppointmentController@certificates')->name('appointments.certificates');
    Route::put('/appointments/issue/{id}',      'AppointmentController@issue')->name('appointments.certificate_issue');
    Route::post('/appointments/search',         'AppointmentController@search_appointment')->name('appointments.search');
    Route::put('/appointments/toDoctor/{id}',   'AppointmentController@toDoctor')->name('appointments.toDoctor');
    Route::put('/appointments/xray/{id}',       'AppointmentController@postXray')->name('appointments.postXray');
    Route::get('/appointments/xray',            'AppointmentController@getXray')->name('appointments.getXray');
    Route::post('/consents/signature',          'ConsentController@signature')->name('consents.signature');
    Route::get('/consultations/reviews',        'ConsultationController@reviews')->name('consultations.reviews');
    Route::get('/consultations/search',         'ConsultationController@search')->name('consultations.search');
    Route::post('/consultations/search',        'ConsultationController@search_appointment')->name('consultations.search');
    Route::post('/consultations/pending',       'ConsultationController@pending')->name('consultations.pending');
    Route::get('/radiologists/reviews',         'RadiologistController@reviews')->name('radiologists.reviews');
    Route::post('/radiologists/search',         'RadiologistController@search_appointment')->name('radiologists.search');
    Route::get('/referrals/initials',           'ReferralController@initials')->name('referrals.initials');
    Route::get('/registrations/resend/{id}',    'RegistrationController@resend')->name('registration.resend');
    
    Route::apiResources([
        'administrator' => 'AdminController',
        'appointments'  => 'AppointmentController',
        'consents'      => 'ConsentController',
        'consultations' => 'ConsultationController',
        'laboratories'  => 'LaboratoryController',
        'patients'      => 'PatientController',
        'payments'      => 'PaymentController',
        'radiologists'  => 'RadiologistController',
        'referrals'     => 'ReferralController',
    ]);
});