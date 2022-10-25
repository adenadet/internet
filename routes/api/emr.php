<?php

use Illuminate\Support\Facades\Route;
Route::group(['prefix'=>'emr'], function () {
    Route::get('/appointments/initials', 'AppointmentController@initials')->name('appointments.initials');
    Route::get('/appointments/schedules', 'AppointmentController@schedules')->name('appointments.schedules');
    
    Route::apiResources([
        'appointments'  => 'AppointmentController',
        'consultations' => 'ConsultationController',
        'patients'      => 'PatientController',
        'payments'      => 'PaymentController',
        'schedulers'    => 'SchedulerController',
    ]);
});