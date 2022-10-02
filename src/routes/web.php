<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ConferenceController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/conferences', [ConferenceController::class, 'getConferences'])
    ->name('Conferences');

Route::get('/users',UserController::class)->name('users');
require __DIR__.'/auth.php';

Route::get('/create', function () {
    return Inertia::render('Create');})
    ->name('Create');

Route::get('/conferences/{id}', [ConferenceController::class, 'detailConference'])
    ->name('Details');

Route::get('/conferences/{id}/edit', [ConferenceController::class, 'editConference'])
    ->name('Edit');

Route::post('/conferences/{id}/edit', [ConferenceController::class, 'editSaveConference'])
    ->name('edit_save');

Route::get('/conferences/{id}/delete', [ConferenceController::class, 'deleteConference'])
    ->name('Delete');

Route::post('/conferences/{id}/join', [ConferenceController::class, 'joinConference'])
    ->name('join');

Route::post('/conferences/{id}/unjoin', [ConferenceController::class, 'unjoinConference'])
    ->name('unjoin');

Route::get('get-countries', [\App\Http\Controllers\Auth\RegisteredUserController::class,
    'getCountries']);

Route::post('/conferences', [ConferenceController::class, 'create'])->name('conferences');

Route::get('/token', function () {
    return csrf_token();
});
