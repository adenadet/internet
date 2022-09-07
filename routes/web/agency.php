<?php 
use Illuminate\Support\Facades\Route;
Route::group(['prefix'=>'agency'], function () {
    Route::post('/messenger/add', 'MessengerController@add')->name('messenger.add');
    Route::get('/messenger/private', 'MessengerController@private')->name('messenger.private');
    Route::get('/messenger/room', 'MessengerController@room')->name('messenger.room');
    Route::get('/rooms/check/{id}', 'RoomController@check')->name('rooms.check');
});