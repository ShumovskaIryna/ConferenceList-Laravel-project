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

// when we click on some conference & see "Details"
Route::get('/conferences/all/{id}', 'ConfByIdController@showConferenceById')
    ->name('detail');
// when we click on "Edit" conference & see Edit Page
Route::get('/conferences/all/{id}/edit', 'EditByIdController@editConferenceById')
    ->name('edit_form');
// when we click on "Delete" conference &
Route::get('/conferences/all/{id}/delete', 'DeleteByIdController@deleteConferenceById')
    ->name('conference_delete');
// when we click on "Save" conference (in the edit form) & see edited conference
Route::post('/conferences/all/{id}/edit', 'EditByIdController@editConferenceByIdSave')
    ->name('edit_form_save');
// we get all Countries from DB & see dropdown on Create page
Route::get('/create', 'CreateFormController@index')
    ->name('create');
// we get all Countries from DB & see dropdown on Edit page
Route::get('/conferences/all/{id}/edit', 'EditByIdController@index')
    ->name('edit_form');
// we get all Data from DB & see table of Conference List
Route::get('/conferences/all', 'ConfListController@allData')
    ->name('conferences_all');
// we post conference which we created & see it in table of Conference List
Route::post('/conferences/all', 'CreateFormController@create')
    ->name('conferences_all');

Auth::routes();

Route::get('/conferences', 'HomeController@index')
    ->name('conferences');
