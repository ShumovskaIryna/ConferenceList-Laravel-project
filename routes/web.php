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

//Route::get('/create', function () {
//    return view('create');
//})->name('conferences');

Route::get('/create', 'CreateFormController@index')->name('create');

Route::get('/conferences/all', 'ConfListController@allData')
    ->name('conferences_all');

Route::post('/conferences/all', 'CreateFormController@create')
    ->name('conferences_all');

Auth::routes();

Route::get('/conferences', 'HomeController@index')
    ->name('conferences');
