<?php
use Illuminate\Support\Facades\Route;

// Home Route
Route::get('/', 'MoviesController@index')->name('movies.index');

// Movies Routes
Route::get('/movies/{id}', 'MoviesController@show')->name('movies.show');

// TV Shows Routes
Route::get('/tv', 'TvController@index')->name('tv.index');
Route::get('/tv/{id}', 'TvController@show')->name('tv.show');

// Actors Routes
Route::get('/actors', 'ActorsController@index')->name('actors.index');
Route::get('/actors/page/{page?}', 'ActorsController@index');
Route::get('/actors/{id}', 'ActorsController@show')->name('actors.show');




