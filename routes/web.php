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

//Main routes
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

//Search routes
Route::get('/search/{searchQuery}', 'HomeController@search')->name('search');
Route::post('/searchprocess', 'HomeController@processSearchForm')->name('processSearchForm');

//Profiles routes
Route::get('/profile/{id}', 'UserController@show')->name('profile');
Route::get('/profile/{id}/edit', 'UserController@edit')->name('profileedit');
Route::put('/profile/{id}', 'UserController@update')->name('profileupdate');

//Status routes
Route::post('/submit', 'StatusController@store');
Route::get('/status/{id}', 'StatusController@show')->name('status');
Route::delete('/status/{id}', 'StatusController@destroy')->name('delstatus');

//Comments routes
Route::post('/comments/submit', 'CommentController@store');
Route::delete('/comments/{id}', 'CommentController@destroy')->name('delcomment');
Route::get('/comments/post/{id}/start/{start}', 'CommentController@getcomments')->name('getcomments');

//Friendships routes
Route::get('/friends','FriendController@index')->name('friends.show');
Route::get('/addfriend/{id}','FriendController@addfriend')->name('friends.add');
Route::get('/cancelrequest/{id}','FriendController@cancelrequest')->name('friends.cancel');
Route::get('/acceptrequest/{id}','FriendController@acceptrequest')->name('friends.accept');
Route::delete('/unfriend/{id}','FriendController@unfriend')->name('friends.unfriend');

Auth::routes();