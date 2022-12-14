<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('/conferences', [ConferenceController::class, 'create'])
        ->name('conference_create');

    Route::get('/conferences/{id}', [ConferenceController::class, 'detailConference'])
        ->name('conference_details');

    Route::get('/conferences/{id}/edit', [ConferenceController::class, 'editConference'])
        ->name('conference_edit');

    Route::post('/conferences/{id}/edit', [ConferenceController::class, 'editSaveConference'])
        ->name('edit_save');

    Route::get('/conferences/{id}/delete', [ConferenceController::class, 'deleteConference'])
        ->name('conference_delete');

    Route::post('/conferences/{id}/join', [ConferenceController::class, 'joinConference'])
        ->name('join');

    Route::post('/conferences/{id}/report-create', [ReportController::class, 'create'])
        ->name('report-create');

    Route::get('/conferences/{id}/reports-list', [ReportController::class, 'getReports']);

    Route::post('/conferences/{id}/unjoin', [ConferenceController::class, 'unjoinConference'])
        ->name('unjoin');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

    Route::get('/user-profile', [RegisteredUserController::class, 'editUser'])
                ->name('user_profile');
    
    Route::post('/user-profile', [RegisteredUserController::class, 'editSaveUser'])
                ->name('user_profile_update');
});
