<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', 'WelcomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/search', 'SearchController@index')->name('search');
Route::resource('channels', 'ChannelController');
Route::get('/upload', 'VideoUploadController@index')->name('upload');
Route::post('/upload', 'VideoUploadController@store')->name('upload.store');
Route::resource('videos', 'VideoController');
Route::post('/videos/{video}/views', 'VideoViewController@store')->name('videos.views');
Route::get('/videos/{video}/votes', 'VideoVoteController@show')->name('videos.votes');
Route::post('/videos/{video}/votes', 'VideoVoteController@create')->name('videos.votes.create');
Route::delete('/videos/{video}/votes', 'VideoVoteController@remove')->name('videos.votes.delete');
Route::get('/videos/{video}/comments', 'VideoCommentController@index')->name('videos.comments.index');
Route::post('/videos/{video}/comments', 'VideoCommentController@create')->name('videos.comments.create');
Route::delete('/videos/{video}/comments/{comment}', 'VideoCommentController@delete')->name('videos.comments.delete');
Route::get('/subscriptions/{channel}', 'ChannelSubscriptionController@show')->name('subscriptions.show');
Route::post('/subscriptions/{channel}', 'ChannelSubscriptionController@create')->name('subscriptions.create');
Route::delete('/subscriptions/{channel}', 'ChannelSubscriptionController@delete')->name('subscriptions.delete');
