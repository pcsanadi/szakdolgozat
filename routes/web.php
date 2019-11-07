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
Route::view('/users','users')->middleware('admin')->name('users');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

