<?php

use Illuminate\Http\Request;

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

Route::post('login', 'Api\AuthController@login');
Route::get('logout', 'Api\AuthController@logout');

Route::get('open', 'Api\AuthController@open');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('closed', 'Api\AuthController@closed');
    Route::get('me', 'Api\AuthController@me');
});


Route::group(['prefix' => '', 'middleware' => ['jwt.verify']], function () {
	Route::apiResource('users', '\App\Http\Controllers\Api\UserAPIController');
	Route::post('/reset-attend', '\App\Http\Controllers\Api\AttendAPIController@reset');
	Route::post('/save-attend', '\App\Http\Controllers\Api\AttendAPIController@store');
	Route::get('/sync-today-data/{user_id}/{year}/{month}/{day}', '\App\Http\Controllers\Api\AttendAPIController@sync_today_data');

	Route::get('/get-attend/{user_id}/{year}/{month}', '\App\Http\Controllers\Api\AttendAPIController@get');
	Route::post('/update-attend/{user_id}/{year}/{month}/{day}', '\App\Http\Controllers\Api\AttendAPIController@update');

    Route::apiResource('attends', '\App\Http\Controllers\Api\AttendAPIController');
});