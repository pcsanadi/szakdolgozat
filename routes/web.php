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

Auth::routes();

Route::get('/users','UserController@index')->name('users.index');
Route::post('/users','Usercontroller@store');
Route::get('/users/create','Usercontroller@create')->name('users.create');
Route::get('/users/{id}','UserController@show')->name('users.show');
Route::put('/users/{id}','UserController@update');
Route::delete('/users/{id}','UserController@destroy');
Route::put('/users/{id}/restore','UserController@restore')->name('users.restore');

Route::get('/venues','VenueController@index')->name('venues.index');
Route::post('/venues','VenueController@store');
Route::get('/venues/create','VenueController@create')->name('venues.create');
Route::get('/venues/{id}','VenueController@show')->name('venues.show');
Route::put('/venues/{id}','VenueController@update');
Route::delete('/venues/{id}','VenueController@destroy');
Route::put('/venues/{id}/restore','VenueController@restore')->name('venues.restore');

Route::get('/tournaments','TournamentController@index')->name('tournaments.index');
Route::post('/tournaments','TournamentController@store');
Route::get('/tournaments/create','TournamentController@create')->name('tournaments.create');
Route::get('/tournaments/{id}','TournamentController@show')->name('tournaments.show');
Route::put('/tournaments/{id}','TournamentController@update');
Route::delete('/tournaments/{id}','TournamentController@destroy');
Route::put('/tournaments/{id}/restore','TournamentController@restore')->name('tournaments.restore');

Route::match(['get','post'],'/tournament-calendar/{id?}','TournamentController@showCalendar')->name('calendar');

Route::put('/umpire/{id}','ApplicationController@addUmpire')->name('umpire');
Route::delete('/umpire/{id}','ApplicationController@removeUmpire');
Route::put('/referee/{id}','ApplicationController@addReferee')->name('referee');
Route::delete('/referee/{id}','ApplicationController@removeReferee');

Route::get('/applications/{id}','ApplicationController@show')->name('applications.show');
Route::put('/applications/{id}','ApplicationController@store')->name('applications.store');
