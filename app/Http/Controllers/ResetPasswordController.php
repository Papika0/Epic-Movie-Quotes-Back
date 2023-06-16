<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\SendPasswordResetLinkRequest;
use Illuminate\Http\JsonResponse;

class ResetPasswordController extends Controller
{
	public function sendResetLink(SendPasswordResetLinkRequest $request): JsonResponse
	{
		$status = Password::sendResetLink(
			$request->validated()
		);

		return $status === Password::RESET_LINK_SENT
		? response()->json(['message' => 'Email was sent successfully !',
			'email'                      => $request->email], 200)
		: response()->json('Email hasnt verified successfully !', 400);
	}

	public function reset(PasswordResetRequest $request): JsonResponse
	{
		$status = Password::reset(
			$request->validated(),
			function (User $user, $password) {
				$user->forceFill([
					'password' => $password,
				])->setRememberToken(Str::random(60));
				$user->save();

				event(new PasswordReset($user));
			}
		);

		return $status === Password::PASSWORD_RESET
		? response()->json('password has reseted successfully !', 200)
		: response()->json('password hasnt reseted successfully !', 400);
	}
}
