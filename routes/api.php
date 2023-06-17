<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\EmailVerificationController;

Route::controller(AuthController::class)->group(function () {
	Route::post('/register', 'register');
	Route::post('/login', 'login');
});

Route::controller(EmailVerificationController::class)->group(function () {
	Route::get('/email/verify/{id}/{hash}', 'verify')->middleware(['signed'])->name('verification.verify');
	Route::post('/email/verify/resend', 'resend')->name('verification.resend');
});

Route::prefix('reset-password')->controller(ResetPasswordController::class)->group(function () {
	Route::post('/', 'sendResetLink')->name('password.send_reset_link');
	Route::post('/{token}', 'reset')->name('password.reset');
});

Route::controller(GoogleAuthController::class)->group(function () {
	Route::get('/auth/google', 'redirectToGoogle')->name('google.redirect')->middleware('web');
	Route::get('/auth/google/call-back', 'handleGoogleCallback')->name('google.callback')->middleware('web');
});

Route::middleware('auth:sanctum')->group(function () {
	Route::controller(AuthController::class)->group(function () {
		Route::post('/logout', 'logout')->middleware('web')->name('logout');
		Route::get('/user', 'user')->middleware('web')->name('user');
	});
});
