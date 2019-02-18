<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// user authentication routes
Route::group(['prefix' => 'user'], function(){

    // PUT:/user/register
    Route::put('/register', 'Api\Guest\User\RegisterController@register');

    // /user/login
    Route::group(['prefix' => 'login'], function(){

        // POST:/user/login
        Route::post('/', 'Api\Guest\User\LoginController@login')->name('login');
        // POST:/user/login/refresh
        Route::post('/refresh', 'Api\Guest\User\LoginController@refresh');
    });

    // POST: /user/forgot-password
    Route::post('forgot-password', 'Api\Guest\User\ForgotPasswordController@requestReset');
    // POST: /user/reset
    Route::post('reset', 'Api\Guest\User\ResetPasswordController@resetPassword');
    // N/A
    Route::post('reset-password', 'Api\Guest\User\ResetPasswordController@resetPassword')->name('password.reset'); //this is a dummy route. It's only purpose is to tell the laravel password reset functionality where the front-end route is it should include in the reset email.
});

// main route returned from the server
Route::get('/{vue_paths?}', 'ViewController@renderVueView')->where('vue_paths', '[\/\w\.-]*');
