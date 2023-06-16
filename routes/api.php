<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\EmailVerificationController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});

Route::controller(AuthController::class)->group(function () {
	Route::post('/register', 'register');
	Route::post('/login', 'login');
});

Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware(['signed'])->name('verification.verify');
Route::post('/email/verify/resend', [EmailVerificationController::class, 'resend'])->name('verification.resend');

Route::prefix('reset-password')->controller(ResetPasswordController::class)->group(function () {
	Route::post('/', 'sendResetLink')->name('password.send_reset_link');
	Route::post('/{token}', 'reset')->name('password.reset');
});
