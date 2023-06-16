<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The model to policy mappings for the application.
	 *
	 * @var array<class-string, class-string>
	 */
	protected $policies = [
	];

	/**
	 * Register any authentication / authorization services.
	 */
	public function boot(): void
	{
		VerifyEmail::toMailUsing(function ($notifiable, $url) {
			$verifyUrl = str_replace(url('/api'), config('app.front_url'), $url) . '?email=' . $notifiable->getEmailForVerification();
			return (new MailMessage)
				->subject('Verify Email Address')
				->markdown('email.verify-email', ['url' => $verifyUrl, 'user' => $notifiable]);
		});

		ResetPassword::toMailUsing(function ($notifiable, $url) {
			$verify = route('password.reset', $url) . '?email=' . $notifiable->getEmailForPasswordReset();
			$verifyUrl = str_replace(url('/api'), config('app.front_url'), $verify);
			return (new MailMessage)
				->subject('Reset Password')
				->markdown('email.reset-password', ['url' => $verifyUrl, 'user' => $notifiable]);
		});
	}
}
