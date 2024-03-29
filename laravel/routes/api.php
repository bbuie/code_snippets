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

        // GET: /api/v1/credentials
        Route::get('credentials', 'Api\V1\Guest\GuestController@getClientEnv');
    });

    // Authenticated routes
    Route::group(['middleware' => 'auth:api'], function(){

        Route::group(['prefix' => 'user'], function () {
            // GET: /api/v1/user
            Route::get('', 'Api\V1\Authorized\UserController@getUser');
            // PUT: /api/v1/user/change-password
            Route::put('change-password', 'Api\V1\Authorized\UserController@changePassword');
            // PUT: /api/v1/user/change-email
            Route::put('change-email', 'Api\V1\Authorized\UserController@changeEmail');
        });

        Route::group(['prefix' => 'admin', 'middleware' => 'require-super-user-access'], function() {
            //put admin routes here
        });

        // /api/v1/logout
        Route::post('/logout', 'Api\V1\Guest\User\LoginController@logout');

        // /api/v1/account
        Route::group(['prefix' => 'account', 'middleware' => 'check-account'], function() {
            //all routes that need an account

            Route::get('/test', 'Api\V1\Authorized\UserController@checkAccountAccess');
        });
    });
});
