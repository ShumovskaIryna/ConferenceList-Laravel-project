<?php

use App\Http\Controllers\UserController;
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

Route::get('/Conferences', function () {
    return Inertia::render('Conferences');
})->middleware(['auth', 'verified'])->name('Conferences');
Route::get('/users',UserController::class)->name('users');
require __DIR__.'/auth.php';

Route::get('/Create', function () {
    return Inertia::render('Create');
})->middleware(['auth', 'verified'])->name('Create');
