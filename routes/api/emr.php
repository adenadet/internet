<?php

use Illuminate\Support\Facades\Route;
Route::group(['prefix'=>'emr'], function () {
    Route::get('/appointments/initials', 'AppointmentController@initials')->name('appointments.initials');
    Route::get('/appointments/missed', 'AppointmentController@missed')->name('appointments.missed');
    Route::get('/appointments/to_doctor/{id}', 'AppointmentController@to_doctor')->name('appointments.to_doctor');
    Route::get('/appointments/certificates', 'AppointmentController@certificates')->name('appointments.certificates');
    Route::put('/appointments/issue/{id}', 'AppointmentController@issue')->name('appointments.certificate_issue');
    Route::put('/appointments/toDoctor/{id}', 'AppointmentController@toDoctor')->name('appointments.toDoctor');
    Route::put('/appointments/xray/{id}', 'AppointmentController@postXray')->name('appointments.postXray');
    Route::get('/appointments/xray', 'AppointmentController@getXray')->name('appointments.getXray');
    Route::get('/consultations/reviews', 'ConsultationController@reviews')->name('consultations.reviews');
    Route::get('/consultations/search', 'ConsultationController@search')->name('consultations.search');
    Route::get('/radiologists/reviews', 'RadiologistController@reviews')->name('radiologists.reviews');
    Route::get('/patients/search', 'PatientController@search')->name('patients.search');
    Route::post('/appointments/search', 'AppointmentController@search_appointment')->name('appointments.search');
    Route::post('/consultations/search', 'ConsultationController@search_appointment')->name('consultations.search');

    Route::apiResources([
        'appointments'  => 'AppointmentController',
        'consents'      => 'ConsentController',
        'consultations' => 'ConsultationController',
        'laboratories'  => 'LaboratoryController',
        'patients'      => 'PatientController',
        'payments'      => 'PaymentController',
        'schedulers'    => 'SchedulerController',
        'radiologists'  => 'RadiologistController',
    ]);
});