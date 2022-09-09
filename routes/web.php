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
})->name('welcome');

Route::get('/conferences', function () {
    return view('conferences');
})->name('conferences');

Route::get('/create', function () {
    return view('create');
})->name('conferences');

Route::get('/conferences/all', 'ConferenceController@allData')
    ->name('conferences_all');

Route::post('/conferences', 'ConferenceController@create')
    ->name('conferences');

Auth::routes();

Route::get('/conferences', 'HomeController@index')
    ->name('conferences');
