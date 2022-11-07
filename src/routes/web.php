<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CategoryController;
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
    ->name('conferences_list');

Route::get('/users',UserController::class)->name('users');
require __DIR__.'/auth.php';

Route::get('/create-conference', [ConferenceController::class, 'create'])
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

Route::get('/conferences/{id}/report-form/{categoryId}', [ReportController::class, 'create'])
    ->name('get_report_form');

Route::post('/conferences/{id}/report-create', [ReportController::class, 'store'])
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

Route::get('/conferences/{confId}/reports-list/{reportId}/edit/{categoryId}', [ReportController::class, 'editReport'])
    ->name('report_edit');

Route::post('/conferences/{confId}/reports-list/{reportId}/edit/{categoryId}', [ReportController::class, 'editSaveReport'])
    ->name('edit_save_report');

Route::post('/conferences/{id}/unjoin', [ConferenceController::class, 'unjoinConference'])
    ->name('unjoin');

Route::post('/conferences', [ConferenceController::class, 'store'])
    ->name('conference_create');

Route::get('/token', function () {
    return csrf_token();
});

Route::get('/user-profile', [RegisteredUserController::class, 'editUser'])
->name('user_profile');

Route::post('/user-profile', [RegisteredUserController::class, 'editSaveUser'])
->name('user_profile_update');

Route::post('/conferences/{confId}/reports-list/{reportId}/like', [ReportController::class, 'likeReport'])
    ->name('report_like');

Route::delete('/conferences/{confId}/reports-list/{reportId}/like', [ReportController::class, 'unlikeReport'])
    ->name('report_unlike');

Route::get('/reports-fav-list', [ReportController::class, 'getFavReports'])
    ->name('reports_fav_list');

Route::get('/category-create', [CategoryController::class, 'create'])
    ->name('category_new');

Route::post('/category-create', [CategoryController::class, 'store'])
    ->name('category_create');

Route::get('/category-list', [CategoryController::class, 'getCategories'])
    ->name('category_list');

Route::get('/category-list/{categoryId}/delete', [CategoryController::class, 'deleteCategory'])
    ->name('category_delete');

Route::get('/category-list/{categoryId}/edit', [CategoryController::class, 'editCategory'])
    ->name('category_edit');

Route::post('/category-list/{categoryId}/edit', [CategoryController::class, 'editSaveCategory'])
    ->name('category_save_edit');

Route::get('/search-list', [Controller::class, 'getSearchList'])
    ->name('search_list');
    
Route::get('conferences-export', [ConferenceController::class,'export'])
    ->name('conferences_export');