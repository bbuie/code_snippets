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

// authentication routes
Route::put('/create-account', 'Auth\RegisterController@register');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/login/refresh', 'Auth\LoginController@refresh');
Route::post('/forgot-password', 'Auth\ForgotPasswordController@requestReset');
Route::post('/reset-password', 'Auth\ResetPasswordController@resetPassword');

// main route returned from the server
Route::get('/{vue_paths?}', function(){
    return view('main');
})->where('vue_paths', '[\/\w\.-]*');
