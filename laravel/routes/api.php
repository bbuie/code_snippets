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

Route::group(['prefix' => 'v1'], function(){
    // Unauthenticated API Routes:
    Route::group([], function(){
        //add unauthenticated api routes, it should be rare to need this.
    });

    // Authenticated routes
    Route::group(['middleware' => 'auth:api'], function(){

        Route::group(['prefix' => 'user'], function () {
            // GET: /api/v1/user
            Route::get('', 'Api\Authorized\UserController@getUser');
            // PUT: /api/v1/user/change-password
            Route::put('change-password', 'Api\Authorized\UserController@changePassword');
            // PUT: /api/v1/user/change-email
            Route::put('change-email', 'Api\Authorized\UserController@changeEmail');
        });

        // /api/v1/logout
        Route::post('/logout', 'Api\Guest\User\LoginController@logout');

        // /api/v1/account
        Route::group(['prefix' => 'account', 'middleware' => 'check-account'], function() {
            //all routes that need an account

            Route::get('/test', 'Api\Authorized\UserController@checkAccountAccess');
        });
    });
});
