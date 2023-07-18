<?php

namespace App\Http\Controllers\auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
	public function redirectToGoogle(): JsonResponse
	{
		$url = Socialite::driver('google')->redirect()->getTargetUrl();
		return response()->json([
			'url'    => $url,
		], 200);
	}

	public function handleGoogleCallback(): JsonResponse
	{
		try {
			$googleUser = Socialite::driver('google')->user();

			$user = User::where('google_id', $googleUser->id)->first();

			if ($user) {
				auth()->login($user, true);
				return response()->json([
					'message' => 'Login success',
				], 200);
			} else {
				$newUser = User::create([
					'username'          => $googleUser->GetName(),
					'email'             => $googleUser->getEmail(),
					'google_id'         => $googleUser->getId(),
					'email_verified_at' => Carbon::now()->toDateTimeString(),
					'password'          => bcrypt($googleUser->getId()),
				]);

				auth()->login($newUser, true);
				return response()->json([
					'message' => 'Register success',
				], 201);
			}
		} catch (\Throwable $error) {
			return response()->json([
				'message' => $error->getMessage(),
			], 500);
		}
	}
}
