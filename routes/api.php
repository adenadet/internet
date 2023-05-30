<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers\Api\Chats')->middleware('auth:api')->name('api.chats.')->group(base_path('routes/api/chats.php'));
Route::namespace('App\Http\Controllers\Api\EMR')
//->middleware('auth:api')
->name('api.emr.')->group(base_path('routes/api/emr.php'));
Route::namespace('App\Http\Controllers\Api\Icms')->middleware('auth:api')->name('api.icms.')->group(base_path('routes/api/icms.php'));
Route::namespace('App\Http\Controllers\Api\Hrms')->middleware('auth:api')->name('api.hrms.')->group(base_path('routes/api/hrms.php'));
Route::namespace('App\Http\Controllers\Api\Lms')->middleware('auth:api')->name('api.lms.')->group(base_path('routes/api/lms.php'));
Route::namespace('App\Http\Controllers\Api\Som')->name('api.som.')->group(base_path('routes/api/som.php'));
Route::namespace('App\Http\Controllers\Api\Ticketing')->middleware('auth:api')->name('api.tickets.')->group(base_path('routes/api/ticket.php'));
Route::namespace('App\Http\Controllers\Api\Ums')->middleware('auth:api')->name('api.ums.')->group(base_path('routes/api/ums.php'));

Route::get('dashboard/applicant',  'App\Http\Controllers\Api\DashboardController@applicant')->name('api.dashboard.applicant');
Route::get('schedules', 'App\Http\Controllers\Api\EMR\RegistrationController@schedules')->name('appointments.schedules');
Route::post('notices/modify',    'App\Http\Controllers\Api\NoticeController@modify')->name('api.notices.modify');
Route::get('policies/all/{id}',  'App\Http\Controllers\Api\PolicyController@all')->name('api.policies.all');
Route::post('policies/assign',   'App\Http\Controllers\Api\PolicyController@assign')->name('api.policies.assign');

Route::apiResources([
    'certificates'  => 'App\Http\Controllers\Api\EMR\CertificateController',
    'dashboard'     => 'App\Http\Controllers\Api\DashboardController',
    'member'        => 'App\Http\Controllers\Api\MemberController',
    'notices'       => 'App\Http\Controllers\Api\NoticeController',
    'policies'      => 'App\Http\Controllers\Api\PolicyController',
    'scheduler'     => 'App\Http\Controllers\Api\EMR\RegistrationController',
]);
