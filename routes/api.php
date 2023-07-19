<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\auth\GoogleAuthController;
use App\Http\Controllers\auth\ResetPasswordController;
use App\Http\Controllers\auth\EmailVerificationController;

Route::get('/set-locale/{locale}', [LocalizationController::class, 'setLanguage'])->name('set.locale');

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
	Route::get('/', 'redirectToGoogle')->name('google.redirect');
	Route::get('/callback', 'handleGoogleCallback')->name('google.callback');
});

Route::middleware('auth:sanctum')->group(function () {
	Route::controller(AuthController::class)->group(function () {
		Route::post('/logout', 'logout')->name('logout');
		Route::get('/user', 'authorizedUser')->name('user');
	});

	Route::prefix('profile')->controller(UserController::class)->group(function () {
		Route::post('/update-profile', 'updateProfile')->name('profile.change_email');
		Route::post('/upload-thumbnail', 'uploadThumbnail')->name('profile.upload_thumbnail');
	});

	Route::prefix('movies')->controller(MovieController::class)->group(function () {
		Route::get('/', 'index')->name('movies.index');
		Route::post('/', 'store')->name('movies.create');
		Route::get('/movies/{movie}', 'get')->name('movies.get');
		Route::post('/movies/{movie}', 'update')->name('movies.update');
		Route::delete('/movies/{movie}', 'destroy')->name('movies.destroy');
	});

	Route::get('/genres', [GenreController::class, 'index'])->name('movies.genres');

	Route::prefix('quotes')->controller(QuoteController::class)->group(function () {
		Route::get('/page/{page}', 'index')->name('quotes.index');
		Route::post('/', 'store')->name('quotes.create');
		Route::get('/{quote}', 'get')->name('quotes.get');
		Route::post('/{quote}', 'update')->name('quotes.update');
		Route::delete('/{quote}', 'destroy')->name('quotes.destroy');

		Route::controller(LikeController::class)->group(function () {
			Route::post('/{quote}/like', 'like')->name('quotes.like');
			Route::post('/{quote}/unlike', 'unlike')->name('quotes.unlike');
		});
	});

	Route::post('/comment/{quote}/', [CommentController::class, 'store'])->name('quotes.comment.store');

	Route::prefix('notifications')->controller(NotificationController::class)->group(function () {
		Route::get('/{page}', 'index')->name('notifications.index');
		Route::post('/{notification}/mark-as-read', 'markAsRead')->name('notifications.mark_as_read');
		Route::post('/mark-all-as-read', 'markAllAsRead')->name('notifications.mark_all_as_read');
	});
});
