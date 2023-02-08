<?php 
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'hrms'], function () {
    
    Route::get('/profile', 'UserController@profile')->name('profile.initials');
    Route::post('/password', 'UserController@password')->name('profile.password');
    Route::get('/users/initials', 'UserController@initials')->name('users.initials');
    Route::get('/users/search', 'UserController@search')->name('users.search');
    
    Route::apiResources([
        '/bios' => 'BioController',
        '/nok' => 'NOKController',
        '/users' => 'UserController',
        //'/profile' => 'ProfileController',
    ]);
});