<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
// Better to use explicit routes. Make the routes self documenting
// instead of having to go to the controller to see what's going where. 
Route::any('users/dashboard', 'UsersController@getDashboard');
Route::any('users/register', 'UsersController@getRegister');
Route::any('users/login', 'UsersController@getLogin');
Route::any('users/create', 'UsersController@postCreate');
Route::any('users/signin','UsersController@postSignin');
Route::any('users/login/fb', 'UsersController@fbLogin');
Route::any('users/login/fb/callback', 'UsersController@fbCallback');
Route::any('users/logout', 'UsersController@getLogout');
Route::any('users/resend', 'UsersController@getResend');
//Route::controller('users', 'UsersController');
Route::controller('/', 'HomeController');