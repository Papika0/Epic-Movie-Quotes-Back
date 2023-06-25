<?php

namespace App\Http\Controllers\auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
	public function register(RegisterRequest $request): JsonResponse
	{
		$user = User::create([
			'username' => $request->username,
			'email'    => $request->email,
			'password' => Hash::make($request->password),
		]);

		event(new Registered($user));

		return response()->json([
			'status'       => true,
			'email'        => $user->email,
		], 201);
	}

	public function login(LoginRequest $request): JsonResponse
	{
		$credentials = $request->only(['password']);
		$username = $request->email;

		if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
			$credentials['email'] = $username;
		} else {
			$credentials['username'] = $username;
		}

		$user = User::where('email', $username)
			->orWhere('username', $username)
			->first();

		if (!Auth::attempt($credentials, $request->has('remember'))) {
			return response()->json([
				'message' => 'Invalid credentials',
			], 401);
		}

		if (!$user->hasVerifiedEmail()) {
			return response()->json([
				'email'		       => $user->email,
				'message'       => 'Email not verified',
			], 403);
		}

		$request->session()->regenerate();

		return response()->json([
			'status'       => true,
		], 200);
	}

	public function user(): JsonResponse
	{
		return response()->json([
			'status'       => true,
			'user'         => Auth::user(),
		], 200);
	}

	public function logout(): JsonResponse
	{
		Auth::guard('web')->logout();
		Session::flush();
		return response()->json([
			'status'  => true,
			'message' => 'Logout success',
		]);
	}
}