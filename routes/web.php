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
Route::get('/stillonline', 'UserController@stillonline')->name('stillonline');

//Messages routes
Route::get('/messages','MessageController@index')->name('messages.index');
Route::get('/messages/new/{userid}','MessageController@create')->name('messages.new');
Route::get('/messages/reply/{messageid}','MessageController@reply')->name('messages.reply');
Route::post('/messages/new/{userid}','MessageController@store');
Route::get('/messages/{messageid}','MessageController@show')->name('messages.show');
Route::delete('/messages/{id}/delete','MessageController@delete')->name('messages.delete');

//Status routes
Route::post('/submit', 'StatusController@store');
Route::post('/submitimage', 'StatusController@storeimage')->name('submitimage');
Route::post('/submitvideo', 'StatusController@storevideo')->name('submitvideo');
Route::get('/status/{id}', 'StatusController@show')->name('status');
Route::delete('/status/{id}', 'StatusController@destroy')->name('delstatus');
Route::get('/status/{id}/edit', 'StatusController@edit')->name('editstatus');
Route::put('/status/{id}/edit', 'StatusController@update')->name('statusupdate');
Route::get('/status/start/{start}', 'StatusController@getstatuseshome')->name('getstatuseshome');
Route::get('/status/user/{id}/start/{start}', 'StatusController@getstatusesprofile')->name('getstatusesprofile');

//Comments routes
Route::post('/comments/submit', 'CommentController@store')->name('submitcomment');
//Route::delete('/comments/{id}', 'CommentController@destroy')->name('delcomment');
Route::get('/comments/{id}', 'CommentController@destroy')->name('delcomment');
Route::get('/comments/post/{id}/start/{start}', 'CommentController@getcomments')->name('getcomments');

//Friendships routes
Route::get('/friends','FriendController@index')->name('friends.show');
Route::get('/addfriend/{id}','FriendController@addfriend')->name('friends.add');
Route::get('/cancelrequest/{id}','FriendController@cancelrequest')->name('friends.cancel');
Route::get('/acceptrequest/{id}','FriendController@acceptrequest')->name('friends.accept');
Route::delete('/unfriend/{id}','FriendController@unfriend')->name('friends.unfriend');
Route::get('/onlinefriends','FriendController@onlinefriends')->name('friends.online');

Auth::routes();