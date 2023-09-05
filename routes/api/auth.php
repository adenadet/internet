<?php

use Illuminate\Support\Facades\Route;
Route::group(['prefix'=>'auth'], function () {
    Route::post('/login', 'AuthController@login')->name('login');
    Route::post('/register', 'AuthController@register')->name('register');
});