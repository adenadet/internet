<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/patient', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');
Route::get('/uk-tb-screening', function () {return view('welcome');});
Route::get('/uk-tb-cancellation', function () {return view('welcome');});
//Route::get('/uk-tb-reschedule', function () {return view('welcome');});
Route::get('/uk-tb-reschedules', function () {return view('welcome');});
//Route::get('/certificates/{id}', function () {return view('welcome');});
Route::get('/test/{id}', function () {return view('certificates.new2');});

Route::resources([
    'certificates' => 'App\Http\Controllers\CertificateController',
]); 

Route::get('/clear-cache', function() {
    //$exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    //$exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('cache:clear');
    
    return "All done boss, anything else";
});

Route::group(['middleware' => 'auth','namespace' => 'App\Http\Controllers\Std', 'name' => 'student.'],function(){
    Route::resource('/learn/student_area/exam', 'ExamController');
});

Route::group(['middleware' => 'auth','namespace' => 'App\Http\Controllers\Learn', 'name' => 'learn.', 'prefix' => '/learn'],function(){
    Route::get('/admin_area',             'AdminController@index');
    Route::get('/student_area',           'StudentController@index');
    Route::get('/tutor_area',             'TutorController@index');
    Route::get('/tutor_area/lesson/{id}', 'TutorController@lesson_show');
    Route::get('/admin_area/{any}',       'AdminController@index')->where('any', '.*');
    Route::get('/student_area/{any}',     'StudentController@index')->where('any', '.*');
    Route::get('/tutor_area/{any}',       'TutorController@index')->where('any', '.*'); 
});

Route::group(['middleware' => ['auth', 'role:Staff'],'namespace' => 'App\Http\Controllers\EMR', 'name' => 'eservices.', 'prefix' => '/eservices'],function(){
    Route::get('/administrator',          'ServiceController@administrator');
    Route::get('/front_admin',            'ServiceController@front_admin');
    Route::get('/front_office',           'ServiceController@front');
    Route::get('/doctor',                 'ServiceController@medical');
    Route::get('/radiologist',            'ServiceController@radiologist');
    Route::get('/doctor/consent/{id}',    'ServiceController@consent');
    Route::post('/doctor/consents',        'ServiceController@consent_save');

    Route::get('/administrator/{any}',    'ServiceController@administrator')->where('any', '.*');
    Route::get('/certificate/{any}',      'ServiceController@certificate')->where('any', '.*'); 
    Route::get('/front_admin/{any}',      'ServiceController@front_admin')->where('any', '.*');
    Route::get('/front_office/{any}',     'ServiceController@front')->where('any', '.*');
    Route::get('/doctor/{any}',           'ServiceController@medical')->where('any', '.*');
    Route::get('/radiologist/{any}',      'ServiceController@radiologist')->where('any', '.*'); 
});

Route::group(['middleware' => ['auth', 'role:Staff'],'namespace' => 'App\Http\Controllers',], function () {
    Route::get('/chats',         'ModulesController@chats')->name('chats');
    Route::get('/contacts',      'ModulesController@contacts')->name('contacts');
    Route::get('/dashboard',     'ModulesController@dashboard')->name('dashboard');
    Route::get('/departments',   'ModulesController@departments')->name('departments');
    Route::get('/internet',      'ModulesController@internet')->name('internet');
    Route::get('/inventory',     'ModulesController@inventory')->name('inventory');
    Route::get('/notices',       'ModulesController@notices')->name('notices');
    Route::get('/policies',      'ModulesController@policies')->name('policies');
    Route::get('/profile',       'ModulesController@profile')->name('profile');
    Route::get('/settings',      'ModulesController@settings')->name('settings');
    Route::get('/staff_month',   'ModulesController@staff_month')->name('staff_month');
    Route::get('/ticketing',     'ModulesController@ticketing')->name('ticketing');
    Route::get('/users',         'ModulesController@users')->name('users');
    
    //Auto Redirect
    Route::get('/chats/{any}',              'ModulesController@chats')->where('any', '.*');
    Route::get('/contacts/{any}',           'ModulesController@contacts')->where('any', '.*');
    Route::get('/departments/{any}',        'ModulesController@departments')->where('any', '.*');
    Route::get('/internet/{any}',           'ModulesController@internet')->where('any', '.*');
    Route::get('/inventory/{any}',          'ModulesController@inventory')->where('any', '.*');
    Route::get('/notices/{any}',            'ModulesController@notices')->where('any', '.*');
    Route::get('/policies/view/{id}',       'ModulesController@policy_reader'); 
    Route::get('/policies/{any}',           'ModulesController@policies')->where('any', '.*');
    Route::get('/settings/{any}',           'ModulesController@settings')->where('any', '.*');
    Route::get('/staff_month/{any}',        'ModulesController@staff_month')->where('any', '.*');
    Route::get('/ticketing/{any}',          'ModulesController@ticketing')->where('any', '.*');
    Route::get('/users/{any}',              'ModulesController@users')->where('any', '.*');

});

//Route::get('/member_area/{any}', 'HomeController@index')->where('any', '.*');

Route::middleware(['auth'])->group(function () {
    Route::get('/applicants',         [App\Http\Controllers\ApplicantController::class, 'index'])->name('applicants');
    Route::get('/applicants/{any}',   [App\Http\Controllers\ApplicantController::class, 'index'])->where('any', '.*');
});

