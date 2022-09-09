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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/conferences', function () {
    return view('conferences');
});
Route::get('/create', function () {
    return view('create');
});

Auth::routes();

Route::get('/conferences', 'HomeController@index')->name('conferences');
