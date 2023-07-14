<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\like\LikeController;
use App\Http\Controllers\movie\MovieController;
use App\Http\Controllers\quote\QuoteController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\auth\GoogleAuthController;
use App\Http\Controllers\profile\ProfileController;
use App\Http\Controllers\auth\ResetPasswordController;
use App\Http\Controllers\auth\EmailVerificationController;
use App\Http\Controllers\notification\NotificationController;

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
	Route::get('/call-back', 'handleGoogleCallback')->name('google.callback');
});

Route::middleware('auth:sanctum')->group(function () {
	Route::controller(AuthController::class)->group(function () {
		Route::post('/logout', 'logout')->name('logout');
		Route::get('/user', 'user')->name('user');
	});

	Route::prefix('profile')->controller(ProfileController::class)->group(function () {
		Route::post('/update-profile', 'updateProfile')->name('profile.change_email');
		Route::post('/upload-thumbnail', 'uploadThumbnail')->name('profile.upload_thumbnail');
	});

	Route::prefix('movies')->controller(MovieController::class)->group(function () {
		Route::prefix('{movie}')->group(function () {
			Route::get('/', 'getMovie')->name('movies.get');
			Route::get('/edit', 'editMovie')->name('movies.edit');
			Route::post('/update', 'updateMovie')->name('movies.update');
			Route::delete('/delete', 'deleteMovie')->name('movies.delete');
		});

		Route::get('/', 'getMovies')->name('movies');
		Route::post('/create', 'createMovie')->name('movies.create');
	});

	Route::get('/genres', [MovieController::class, 'getGenres'])->name('movies.genres');

	Route::prefix('quotes')->controller(QuoteController::class)->group(function () {
		Route::prefix('{quote}')->group(function () {
			Route::get('/', 'getQuote')->name('quotes.get');
			Route::post('/update', 'updateQuote')->name('quotes.update');
			Route::delete('/delete', 'deleteQuote')->name('quotes.delete');
			Route::post('/create-comment', 'createComment')->name('quotes.create_comment');

			Route::controller(LikeController::class)->group(function () {
				Route::post('/like', 'like')->name('quotes.like');
				Route::post('/unlike', 'unlike')->name('quotes.unlike');
			});
		});

		Route::get('/{page}/get-quotes', 'getQuotes')->name('quotes');
		Route::post('/create', 'createQuote')->name('quotes.create');
	});

	Route::prefix('notifications')->controller(NotificationController::class)->group(function () {
		Route::get('/{page}', 'getNotifications')->name('notifications.get');
		Route::post('/{id}/mark-as-read', 'markAsRead')->name('notifications.mark_as_read');
		Route::post('/mark-all-as-read', 'markAllAsRead')->name('notifications.mark_all_as_read');
	});
});
