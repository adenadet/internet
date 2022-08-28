<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');


Route::get('/clear-cache', function() {
    //$exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    //$exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('cache:clear');
    
    return "All done boss, anything else";
    // return what you want
});

Route::group(['middleware' => 'auth','namespace' => 'App\Http\Controllers\Std', 'name' => 'student.'],function(){
    Route::resource('/learn/student_area/exam', 'ExamController');
});

Route::group(['middleware' => 'auth','namespace' => 'App\Http\Controllers\Learn', 'name' => 'learn.', 'prefix' => '/learn'],function(){
    Route::get('/admin_area',             'AdminController@index');
    Route::get('/student_area',           'StudentController@index');
    Route::get('/tutor_area',             'TutorController@index');

    Route::get('/admin_area/{any}',       'AdminController@index')->where('any', '.*');
    Route::get('/student_area/{any}',     'StudentController@index')->where('any', '.*');
    Route::get('/tutor_area/{any}',       'TutorController@index')->where('any', '.*'); 
});

Route::group(['middleware' => 'auth','namespace' => 'App\Http\Controllers\EMR', 'name' => 'eservices.', 'prefix' => '/eservices'],function(){
    Route::get('/administrator',          'ServiceController@administrator');
    Route::get('/front_office',           'ServiceController@front');
    Route::get('/medical_officer',        'ServiceController@medical');
    Route::get('/radiologist',            'ServiceController@radiologist');

    Route::get('/administrator/{any}',    'ServiceController@administrator')->where('any', '.*'); 
    Route::get('/front_office/{any}',     'ServiceController@front')->where('any', '.*');
    Route::get('/medical_officer/{any}',  'ServiceController@medical')->where('any', '.*');
    Route::get('/radiologist/{any}',      'ServiceController@radiologist')->where('any', '.*'); 
});

Route::middleware(['auth'])->group(function () {
    Route::get('/chats',                    'ModulesController@chats');
    Route::get('/contacts',                 'ModulesController@contacts');
    Route::get('/dashboard',                'ModulesController@dashboard');
    Route::get('/departments',              'ModulesController@departments');
    Route::get('/internet',                 'ModulesController@internet');
    Route::get('/notices',                  'ModulesController@notices');
    Route::get('/policies',                 'ModulesController@policies');
    Route::get('/profile',                  'ModulesController@profile');
    Route::get('/settings',                 'ModulesController@settings');
    Route::get('/staff_month',              'ModulesController@staff_month');
    Route::get('/ticketing',                'ModulesController@ticketing');
    Route::get('/users',                    'ModulesController@users');
    
    //Auto Redirect
    Route::get('/chats/{any}',              'ModulesController@chats')->where('any', '.*');
    Route::get('/departments/{any}',        'ModulesController@departments')->where('any', '.*');
    Route::get('/internet/{any}',           'ModulesController@internet')->where('any', '.*');
    Route::get('/notices/{any}',            'ModulesController@notices')->where('any', '.*');
    Route::get('/policies/{any}',           'ModulesController@policies')->where('any', '.*');
    Route::get('/settings/{any}',           'ModulesController@settings')->where('any', '.*');
    Route::get('/staff_month/{any}',        'ModulesController@staff_month')->where('any', '.*');
    Route::get('/ticketing/{any}',          'ModulesController@ticketing')->where('any', '.*');
    Route::get('/users/{any}',              'ModulesController@users')->where('any', '.*');

});

Route::get('/member_area/{any}', 'HomeController@index')->where('any', '.*');
