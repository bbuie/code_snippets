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

# v1.0 API
Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function(){

    // /api/v1/logout
    Route::get('/get-user', 'Api\Authorized\UserController@getUser');

    // /api/v1/logout
    Route::post('/logout', 'Api\Guest\User\LoginController@logout');
});
