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

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/submit', 'StatusController@store');
Route::get('/profile/{id}', 'HomeController@profile')->name('profile');
Route::get('/status/{id}', 'StatusController@show')->name('status');
Route::post('/comments/submit', 'CommentController@store');

Auth::routes();