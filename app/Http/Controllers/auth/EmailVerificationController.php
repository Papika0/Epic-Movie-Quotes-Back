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
				$user->update([
					'email'           => $user->temporary_email,
					'temporary_email' => null,
				]);
				return response()->json([], 204);
			}
			return response()->json(['message' => 'Email verification failed !', 'email' => $user->getEmailForVerification()], 401);
		}

		if (!$user->hasVerifiedEmail()) {
			$user->markEmailAsVerified();
			event(new Verified($user));
		}

		return response()->json([], 204);
	}

	public function resend(ResendEmailRequest $request): JsonResponse
	{
		$user = User::where('email', $request->email)->firstOrFail();

		if ($user->hasVerifiedEmail()) {
			return response()->json([], 204);
		}

		$user->sendEmailVerificationNotification();

		return response()->json([], 204);
	}
}
