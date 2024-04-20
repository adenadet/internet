<?php

use Illuminate\Support\Facades\Route;
Route::group(['prefix'=>'claims'], function () {
    Route::get('/curacel/initials', 'CuracelController@initials')->name('curacel.initials');
    
    Route::apiResources([
        'curacel' => 'CuracelController',
    ]);
});