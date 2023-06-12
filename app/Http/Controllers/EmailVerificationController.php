<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Events\Verified;
use App\Http\Requests\VerifyEmailRequest;

class EmailVerificationController extends Controller
{
	public function verify(VerifyEmailRequest $request): JsonResponse
	{
		$user = User::findOrFail($request->id);

		if (!hash_equals((string) $user->getKey(), (string) $request->id) ||
			!hash_equals(sha1($user->getEmailForVerification()), (string) $request->hash)) {
			abort(403);
		}

		if (!$user->hasVerifiedEmail()) {
			$user->markEmailAsVerified();
			event(new Verified($user));
		}

		return response()->json('Email verified successfully !');
	}
}
