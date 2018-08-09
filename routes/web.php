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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('sendEmail', 'TestController@sendEmail');
Route::post('sendGetRequest', 'TestController@sendGetRequest');
Route::post('getUserLibsOne', 'TestController@getUserLibsOne');

Route::get('test', 'TestController@test');
Route::get('test2', 'TestController@test2');
Route::get('login', 'TestController@login');

Route::get('valid', 'API\Login\LoginController@valid');
Route::get('login', 'API\Login\LoginController@login');
Route::get('getCode', 'API\Login\LoginController@getCode');
Route::get('getToken', 'API\Login\LoginController@getToken');
Route::get('getInfo', 'API\Login\LoginController@getInfo');
