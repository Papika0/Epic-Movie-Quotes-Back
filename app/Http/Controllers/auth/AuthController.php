<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
	public function register(RegisterRequest $request): JsonResponse
	{
		$user = User::create([
			...$request->validated(), ]);

		event(new Registered($user));

		return response()->json([
			'email'        => $user->email,
		], 201);
	}

	public function login(LoginRequest $request): JsonResponse
	{
		$user = User::where('email', $request->email)
			->orWhere('username', $request->username)
			->first();

		if (!Auth::attempt($request->validated(), $request->has('remember'))) {
			return response()->json([
				'message' => __('auth.failed'),
			], 401);
		}

		if (!$user->hasVerifiedEmail()) {
			return response()->json([
				'email'		       => $user->email,
				'message'       => __('auth.not_verified'),
			], 403);
		}

		$request->session()->regenerate();

		return response()->json([], 204);
	}

	public function authorizedUser(): JsonResponse
	{
		return response()->json([
			'user'               => Auth::user(),
		], 200);
	}

	public function logout(): JsonResponse
	{
		Auth::guard('web')->logout();
		Session::flush();
		return response()->json([], 204);
	}
}
