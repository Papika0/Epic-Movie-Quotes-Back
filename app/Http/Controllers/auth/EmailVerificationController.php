<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResendEmailRequest;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;

class EmailVerificationController extends Controller
{
	public function verify(VerifyEmailRequest $request): JsonResponse
	{
		$user = User::findOrFail($request->id);

		if (!hash_equals((string) $user->getKey(), (string) $request->id) ||
			!hash_equals(sha1($user->getEmailForVerification()), (string) $request->hash)) {
			if ($user->temporary_email != null && $user->hasVerifiedEmail()) {
				$user->email = $user->temporary_email;
				$user->temporary_email = null;
				$user->save();
				return response()->json('Email has updated successfully !');
			}
			return response()->json(['message' => 'Email verification failed !', 'email' => $user->getEmailForVerification()], 401);
		}

		if (!$user->hasVerifiedEmail()) {
			$user->markEmailAsVerified();
			event(new Verified($user));
		}

		return response()->json('Email verified successfully !');
	}

	public function resend(ResendEmailRequest $request): JsonResponse
	{
		$user = User::where('email', $request->email)->firstOrFail();

		if ($user->hasVerifiedEmail()) {
			return response()->json('Email already verified!', 200);
		}

		$user->sendEmailVerificationNotification();

		return response()->json('Email verification link resent!', 200);
	}
}
