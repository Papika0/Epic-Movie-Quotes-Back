<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Http\Requests\Auth\SendPasswordResetLinkRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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
		: response()->json("Email hasn't verified successfully !", 400);
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
