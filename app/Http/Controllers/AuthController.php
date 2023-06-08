<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
	use HttpResponses;

	public function register(RegisterRequest $request): JsonResponse
	{
		$user = User::create([
			'username' => $request->username,
			'email'    => $request->email,
			'password' => Hash::make($request->password),
		]);

		$token = $user->createToken('auth_token')->plainTextToken;

		event(new Registered($user));

		return response()->json([
			'user'		       => $user,
			'status'       => true,
			'access_token' => $token,
		]);
	}

	public function login()
	{
		return response()->json([
			'status' => true,
			'data'   => 'this is login',
		]);
	}
}
