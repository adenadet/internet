<?php 
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'som'], function () {
    Route::put('/nominations/close/{id}', 'NominationController@close')->name('nominations.close');
    Route::get('/nominations/open/{id}', 'NominationController@open')->name('nominations.open');
    Route::put('/votes/close/{id}', 'VoteController@close')->name('votes.close');
    Route::apiResources([
        '/nominations' => 'NominationController',
        '/votes'       => 'VoteController',
        '/winners'     => 'WinnerController',
        '/months'      => 'MonthController',
    ]);
});