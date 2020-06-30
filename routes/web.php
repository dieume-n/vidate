<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('channels', 'ChannelController');
Route::get('/upload', 'VideoUploadController@index')->name('upload')->middleware('auth');
Route::post('/upload', 'VideoUploadController@store')->name('upload.store')->middleware('auth');
Route::resource('videos', 'VideoController')->middleware('auth');
