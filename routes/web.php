<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/search', 'SearchController@index')->name('search');
Route::resource('channels', 'ChannelController');
Route::get('/upload', 'VideoUploadController@index')->name('upload');
Route::post('/upload', 'VideoUploadController@store')->name('upload.store');
Route::resource('videos', 'VideoController');
Route::post('/videos/{video}/views', 'VideoViewController@store')->name('videos.views');
