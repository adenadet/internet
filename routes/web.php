<?php

use Illuminate\Support\Facades\Route;


Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/patient', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');
Route::get('/uk-tb-screening', function () {return view('welcome');});
Route::get('/uk-tb-cancellation', function () {return view('welcome');});
Route::get('/uk-tb-reschedule', function () {return view('welcome');});
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

    Route::get('/administrator/{any}',    'ServiceController@administrator')->where('any', '.*');
    Route::get('/certificate/{any}',      'ServiceController@certificate')->where('any', '.*'); 
    Route::get('/front_admin/{any}',      'ServiceController@front_admin')->where('any', '.*');
    Route::get('/front_office/{any}',     'ServiceController@front')->where('any', '.*');
    Route::get('/doctor/{any}',           'ServiceController@medical')->where('any', '.*');
    Route::get('/radiologist/{any}',      'ServiceController@radiologist')->where('any', '.*'); 
});

Route::middleware(['auth', 'role:Staff'])->group(function () {
    Route::get('/chats',         [App\Http\Controllers\ModulesController::class, 'chats'])->name('chats');
    Route::get('/contacts',      [App\Http\Controllers\ModulesController::class, 'contacts'])->name('contacts');
    Route::get('/dashboard',     [App\Http\Controllers\ModulesController::class, 'dashboard'])->name('dashboard');
    Route::get('/departments',   [App\Http\Controllers\ModulesController::class, 'departments'])->name('departments');
    Route::get('/internet',      [App\Http\Controllers\ModulesController::class, 'internet'])->name('internet');
    Route::get('/notices',       [App\Http\Controllers\ModulesController::class, 'notices'])->name('notices');
    Route::get('/policies',      [App\Http\Controllers\ModulesController::class, 'policies'])->name('policies');
    Route::get('/profile',       [App\Http\Controllers\ModulesController::class, 'profile'])->name('profile');
    Route::get('/settings',      [App\Http\Controllers\ModulesController::class, 'settings'])->name('settings');
    Route::get('/staff_month',   [App\Http\Controllers\ModulesController::class, 'staff_month'])->name('staff_month');
    Route::get('/ticketing',     [App\Http\Controllers\ModulesController::class, 'ticketing'])->name('ticketing');
    Route::get('/users',         [App\Http\Controllers\ModulesController::class, 'users'])->name('users');
    
    //Auto Redirect
    Route::get('/chats/{any}',              [App\Http\Controllers\ModulesController::class, 'chats'])->where('any', '.*');
    Route::get('/contacts/{any}',           [App\Http\Controllers\ModulesController::class, 'contacts'])->where('any', '.*');
    Route::get('/departments/{any}',        [App\Http\Controllers\ModulesController::class, 'departments'])->where('any', '.*');
    Route::get('/internet/{any}',           [App\Http\Controllers\ModulesController::class, 'internet'])->where('any', '.*');
    Route::get('/notices/{any}',            [App\Http\Controllers\ModulesController::class, 'notices'])->where('any', '.*');
    Route::get('/policies/{any}',           [App\Http\Controllers\ModulesController::class, 'policies'])->where('any', '.*');
    Route::get('/settings/{any}',           [App\Http\Controllers\ModulesController::class, 'settings'])->where('any', '.*');
    Route::get('/staff_month/{any}',        [App\Http\Controllers\ModulesController::class, 'staff_month'])->where('any', '.*');
    Route::get('/ticketing/{any}',          [App\Http\Controllers\ModulesController::class, 'ticketing'])->where('any', '.*');
    Route::get('/users/{any}',              [App\Http\Controllers\ModulesController::class, 'users'])->where('any', '.*');

});

//Route::get('/member_area/{any}', 'HomeController@index')->where('any', '.*');

Route::middleware(['auth'])->group(function () {
    Route::get('/applicants',         [App\Http\Controllers\ApplicantController::class, 'index'])->name('applicants');

    Route::get('/applicants/{any}',   [App\Http\Controllers\ApplicantController::class, 'index'])->where('any', '.*');

});