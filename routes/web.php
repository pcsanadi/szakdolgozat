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

// Route::get('/home', 'HomeController@index')->name('home');

Route::view('/','auth.login');
Route::view('/login','auth.login');

Auth::routes();

Route::get('/users','UserController@index')->name('users');
Route::post('/users','Usercontroller@store');
Route::get('/users/create','Usercontroller@create')->name('createUser');
Route::get('/users/{id}','UserController@show')->where('id','[0-9]+')->name('showUser');
Route::put('/users/{id}','UserController@save')->where('id','[0-9]+');
Route::delete('/users/{id}','UserController@destroy')->where('id','[0-9]+');
Route::put('/users/{id}/restore','UserController@restore')->where('id','[0-9]+')->name('restoreUser');

Route::get('/venues','VenueController@index')->name('venues');
Route::post('/venues','VenueController@store');
Route::get('/venues/create','VenueController@create')->name('createVenue');
Route::get('/venues/{id}','VenueController@show')->where('id','[0-9]+')->name('showVenue');
Route::put('/venues/{id}','VenueController@save')->where('id','[0-9]+');
Route::delete('/venues/{id}','VenueController@destroy')->where('id','[0-9]+');
Route::put('/venues/{id}/restore','VenueController@restore')->where('id','[0-9]+')->name('restoreVenue');

Route::get('/tournaments','TournamentController@index')->name('tournaments');
Route::post('/tournaments','TournamentController@store');

Route::get('/tournaments/create','TournamentController@create')->name('createTournament');
Route::get('/tournaments/{id}','TournamentController@show')->where('id','[0-9]+')->name('showTournament');
Route::put('/tournaments/{id}','TournamentController@save')->where('id','[0-9]+');
Route::delete('/tournaments/{id}','TournamentController@destroy')->where('id','[0-9]+');
Route::put('/tournaments/{id}/restore','TournamentController@restore')->where('id','[0-9]+')->name('restoreTournament');
Route::get('/tournament-calendar/{id?}','TournamentController@showCalendar')->name('calendar');

