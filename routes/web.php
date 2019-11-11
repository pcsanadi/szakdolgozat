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

Route::view('/','auth.login');
Route::view('/login','auth.login');
Route::get('/users','UserController@index')->name('users');
Route::get('/users/{id}','UserController@show')->name('showUser');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

