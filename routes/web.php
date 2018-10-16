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
Route::get('/profile/{id}', 'UserController@show')->name('profile');
Route::get('/profile/{id}/edit', 'UserController@edit')->name('profileedit');
Route::put('/profile/{id}', 'UserController@update')->name('profileupdate');
Route::get('/status/{id}', 'StatusController@show')->name('status');
Route::delete('/status/{id}', 'StatusController@destroy')->name('delstatus');
Route::post('/comments/submit', 'CommentController@store');
Route::delete('/comments/{id}', 'CommentController@destroy')->name('delcomment');
Route::get('/friends','FriendController@index')->name('friends.show');

Auth::routes();