<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('channels', 'ChannelController');
Route::get('/upload', 'VideoUploadController@index')->name('upload')->middleware('auth');
Route::post('/upload', 'VideoUploadController@store')->name('upload.store')->middleware('auth');
Route::resource('videos', 'VideoController')->only(['store','update'])->middleware('auth');
