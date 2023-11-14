<?php 
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'inventory'], function () {
    
    Route::get('/items/initials', 'ItemController@initials')->name('items.initials');
    Route::post('/items/search', 'ItemController@search')->name('items.search');
    Route::get('/stores/initials', 'StoreController@initials')->name('stores.initials');
    Route::get('/transfer_orders/initials', 'TransferOrderController@initials')->name('transfer_orders.initials');

    Route::apiResources([
        'categories' => 'CategoryController',
        'items' => 'ItemController',
        'purchase_orders' => 'PurchaseOrderController',
        'transfer_orders' => 'TransferOrderController',
        'stores' => 'StoreController',
    ]);
});