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

Route::get('/users','UserController@index')->name('users');
Route::post('/users','Usercontroller@store');
Route::get('/users/create','Usercontroller@create')->name('createUser');
Route::get('/users/{id}','UserController@show')->name('showUser');
Route::put('/users/{id}','UserController@save');
Route::delete('/users/{id}','UserController@destroy');
Route::put('/users/{id}/restore','UserController@restore')->name('restoreUser');

Route::get('/venues','VenueController@index')->name('venues');
Route::post('/venues','VenueController@store');
Route::get('/venues/create','VenueController@create')->name('createVenue');
Route::get('/venues/{id}','VenueController@show')->name('showVenue');
Route::put('/venues/{id}','VenueController@save');
Route::delete('/venues/{id}','VenueController@destroy');
Route::put('/venues/{id}/restore','VenueController@restore')->name('restoreVenue');

Route::get('/tournaments','TournamentController@index')->name('tournaments');
Route::post('/tournaments','TournamentController@store');

Route::get('/tournaments/create','TournamentController@create')->name('createTournament');
Route::get('/tournaments/{id}','TournamentController@show')->name('showTournament');
Route::put('/tournaments/{id}','TournamentController@save');
Route::delete('/tournaments/{id}','TournamentController@destroy');
Route::put('/tournaments/{id}/restore','TournamentController@restore')->name('restoreTournament');
Route::match(['get','post'],'/tournament-calendar/{id?}','TournamentController@showCalendar')->name('calendar');

Route::put('/umpire/{id}','ApplicationController@addUmpire')->name('umpire');
Route::delete('/umpire/{id}','ApplicationController@removeUmpire');
Route::put('/referee/{id}','ApplicationController@addReferee')->name('referee');
Route::delete('/referee/{id}','ApplicationController@removeReferee');

Route::get('/applications/{id}','ApplicationController@show')->name('applications');
Route::put('/applications/{id}','ApplicationController@save')->name('saveApplications');
