<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Faker\Factory as Faker;
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

		$faker = Faker::create();
		$firstName = strtoupper(substr($user->username, 0, 1));
		$thumbnail = $faker->image(public_path('storage/thumbnails'), 180, 180, null, false, false, $firstName);
		$user->thumbnail = '/storage/thumbnails/' . pathinfo($thumbnail, PATHINFO_BASENAME);
		$user->save();

		return response()->json([
			'status'       => true,
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

		return response()->json([
			'status'       => true,
		], 200);
	}

	public function authorizedUser(): JsonResponse
	{
		return response()->json([
			'status'             => true,
			'user'               => Auth::user(),
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
