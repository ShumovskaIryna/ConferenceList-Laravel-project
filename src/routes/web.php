<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConferenceController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

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
    ->name('conferences_list');

Route::get('/users',UserController::class)->name('users');
require __DIR__.'/auth.php';

Route::get('/create-conference', function () {
    $isAnnouncer = Gate::allows('isAnnouncer');
    $isAdmin = Gate::allows('isAdmin');
    $canCreateConf = $isAnnouncer || $isAdmin;
    if (!$canCreateConf) {
        abort(403, 'Create conference can Admin and Announcer only' );
    }
    return Inertia::render('Conferences/Create');})
    ->name('conference_new');

Route::get('/conferences/{id}', [ConferenceController::class, 'detailConference'])
    ->name('conference_details');

Route::get('/conferences/{id}/edit', [ConferenceController::class, 'editConference'])
    ->name('conference_edit');

Route::post('/conferences/{id}/edit', [ConferenceController::class, 'editSaveConference'])
    ->name('edit_save');

Route::delete('/conferences/{id}/delete', [ConferenceController::class, 'deleteConference'])
    ->name('conference_delete');

Route::post('/conferences/{id}/join', [ConferenceController::class, 'joinConference'])
    ->name('join');

Route::get('/conferences/{id}/report-form', function () {
    return Inertia::render('Reports/ReportForm');
})->name('get_report_form');

Route::post('/conferences/{id}/report-create', [ReportController::class, 'create'])
    ->name('report_create');

Route::get('/conferences/{id}/reports-list', [ReportController::class, 'getReports'])
    ->name('reports_list');

Route::post('/conferences/{confId}/reports-list/{reportId}', [CommentController::class, 'create'])
    ->name('comment_create');

Route::post('/conferences/{confId}/reports-list/{reportId}/comment-delete/{commentId}',
    [CommentController::class, 'delete'])
    ->name('comment_delete');

Route::get('/conferences/{confId}/reports-list/{reportId}/comment-edit/{commentId}',
    [CommentController::class, 'edit'])
    ->name('comment_edit');

Route::post('/conferences/{confId}/reports-list/{reportId}/comment-edit/{commentId}',
    [CommentController::class, 'editSaveComment'])
    ->name('edit_save_comment');

Route::get('/conferences/{confId}/reports-list/{reportId}', [ReportController::class, 'detailReport'])
    ->name('report_details');

Route::get('/conferences/{confId}/reports-list/{reportId}/edit', [ReportController::class, 'editReport'])
    ->name('report_edit');

Route::post('/conferences/{confId}/reports-list/{reportId}/edit', [ReportController::class, 'editSaveReport'])
    ->name('edit_save_report');

Route::post('/conferences/{id}/unjoin', [ConferenceController::class, 'unjoinConference'])
    ->name('unjoin');

Route::get('get-countries', [RegisteredUserController::class, 'getCountries']);

Route::post('/conferences', [ConferenceController::class, 'create'])
    ->name('conference_create');

Route::get('/token', function () {
    return csrf_token();
});

Route::get('/user-profile', [RegisteredUserController::class, 'editUser'])
->name('user_profile');

Route::post('/user-profile', [RegisteredUserController::class, 'editSaveUser'])
->name('user_profile_update');
