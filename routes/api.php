<?php


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');


Route::group(['prefix' => 'panel', 'middleware' => ['auth:api']], function () {
    Route::post('store', 'BusController@store');
    Route::put('edit/{id}', 'BusController@edit');
    Route::delete('delete/{id}', 'BusController@destroy');
    Route::post('store', 'BusController@store');
    Route::post('store/ride', 'RideController@store');
});
