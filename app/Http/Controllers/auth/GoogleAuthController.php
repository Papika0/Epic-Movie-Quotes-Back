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
			'status' => 'success',
			'url'    => $url,
		]);
	}

	public function handleGoogleCallback(): JsonResponse
	{
		try {
			$googleUser = Socialite::driver('google')->user();

			$user = User::where('google_id', $googleUser->id)->first();

			if ($user) {
				auth()->login($user, true);
				return response()->json([
					'status'  => 'success',
					'message' => 'Login success',
				], 201);
			} else {
				$new_user = User::create([
					'username'          => $googleUser->GetName(),
					'email'             => $googleUser->getEmail(),
					'google_id'         => $googleUser->getId(),
					'email_verified_at' => Carbon::now()->toDateTimeString(),
					'password'          => bcrypt($googleUser->getId()),
				]);

				auth()->login($new_user, true);
				return response()->json([
					'status'  => 'success',
					'message' => 'Register success',
				], 201);
			}
		} catch (\Throwable $th) {
			return response()->json([
				'status'  => 'error',
				'message' => $th->getMessage(),
			]);
		}
	}
}
