<?php


use Illuminate\Support\Facades\Route;

Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');


Route::group(['prefix' => 'panel', 'middleware' => 'auth:api'], function () {
    Route::post('store', 'BusController@store');
    Route::put('edit/{id}', 'BusController@edit');
    Route::delete('delete/{id}', 'BusController@destroy');
    Route::post('store', 'BusController@store');
    Route::post('store/ride', 'RideController@store');
    Route::post('edit/ride/{id}', 'RideController@edit');
});

Route::get('/', 'UserController@landingPageInfo');
Route::post('rides','RideController@show');
Route::post('ticket','ReserveController@show');
Route::post('receipt', 'ReserveController@store')->middleware('auth:api');

Route::post('receipt/{reserve}/purchase', 'PurchaseController@purchase');
Route::post('receipt/{reserve}/purchase/result', 'PurchaseController@result');

//Route::get('test','ReserveController@test');

