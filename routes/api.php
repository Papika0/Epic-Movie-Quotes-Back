<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\movie\MovieController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\auth\GoogleAuthController;
use App\Http\Controllers\profile\ProfileController;
use App\Http\Controllers\auth\ResetPasswordController;
use App\Http\Controllers\auth\EmailVerificationController;

Route::get('/set-locale/{locale}', [LocalizationController::class, 'setLanguage'])->name('set.locale')->middleware('web');

Route::controller(AuthController::class)->group(function () {
	Route::post('/register', 'register');
	Route::post('/login', 'login');
});

Route::controller(EmailVerificationController::class)->prefix('/email/verify')->group(function () {
	Route::get('/{id}/{hash}', 'verify')->middleware(['signed'])->name('verification.verify');
	Route::post('/resend', 'resend')->name('verification.resend');
});

Route::prefix('reset-password')->controller(ResetPasswordController::class)->group(function () {
	Route::post('/', 'sendResetLink')->name('password.send_reset_link');
	Route::post('/{token}', 'reset')->name('password.reset');
});

Route::controller(GoogleAuthController::class)->prefix('/auth/google')->group(function () {
	Route::get('/', 'redirectToGoogle')->name('google.redirect')->middleware('web');
	Route::get('/call-back', 'handleGoogleCallback')->name('google.callback')->middleware('web');
});

Route::middleware('auth:sanctum')->group(function () {
	Route::controller(AuthController::class)->group(function () {
		Route::post('/logout', 'logout')->middleware('web')->name('logout');
		Route::get('/user', 'user')->middleware('web')->name('user');
	});

	Route::prefix('profile')->controller(ProfileController::class)->group(function () {
		Route::post('/update-profile', 'updateProfile')->middleware('web')->name('profile.change_email');
		Route::post('/upload-thumbnail', 'uploadThumbnail')->middleware('web')->name('profile.upload_thumbnail');
	});

	Route::prefix('movies')->controller(MovieController::class)->group(function () {
		Route::get('/', 'getMovies')->middleware('web')->name('movies');
		Route::get('/{movie}', 'getMovie')->middleware('web')->name('movies.get');
		Route::get('/{movie}/edit', 'editMovie')->middleware('web')->name('movies.edit');
		Route::post('/create', 'createMovie')->middleware('web')->name('movies.create');
		Route::post('/{movie}/update', 'updateMovie')->middleware('web')->name('movies.update');
		Route::delete('/{movie}/delete', 'deleteMovie')->middleware('web')->name('movies.delete');
	});

	Route::get('/genres', [MovieController::class, 'getGenres'])->middleware('web')->name('movies.genres');
});
