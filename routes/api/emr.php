<?php

use Illuminate\Support\Facades\Route;
Route::group(['prefix'=>'emr'], function () {
    Route::get('/appointments/initials', 'AppointmentController@initials')->name('appointments.initials');
    Route::get('/appointments/schedules', 'AppointmentController@schedules')->name('appointments.schedules');
    Route::get('/appointments/to_doctor/{id}', 'AppointmentController@to_doctor')->name('appointments.to_doctor');
    Route::get('/appointments/certificates', 'AppointmentController@certificates')->name('appointments.certificates');
    Route::put('/appointments/issue/{id}', 'AppointmentController@issue')->name('appointments.certificate_issue');
    Route::get('/radiologists/reviews', 'RadiologistController@reviews')->name('radiologists.reviews');
    Route::get('/patients/search', 'PatientController@search')->name('patients.search');

    Route::apiResources([
        'appointments'  => 'AppointmentController',
        'consents'      => 'ConsentController',
        'consultations' => 'ConsultationController',
        'patients'      => 'PatientController',
        'payments'      => 'PaymentController',
        'schedulers'    => 'SchedulerController',
        'radiologists'  => 'RadiologistController',
    ]);
});