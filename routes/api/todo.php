<?php 
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'todos'], function () {
    Route::apiResources([
        '/tasks'      => 'TaskController',
    ]);
});