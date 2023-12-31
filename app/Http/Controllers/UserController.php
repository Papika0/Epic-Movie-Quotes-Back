<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ProfilePictureRequest;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
	public function updateProfile(ProfileUpdateRequest $request): JsonResponse
	{
		$user = User::find(auth()->user()->id);

		if ($request->has('email')) {
			$currentEmail = $user->email;
			$user->email = $request->email;
			$user->temporary_email = $request->email;
			$user->sendEmailVerificationNotification();
			$user->email = $currentEmail;
		}

		if ($request->has('username')) {
			$user->username = $request->username;
		}

		if ($request->has('password')) {
			$user->password = $request->password;
		}

		$user->save();
		return response()->json([
			'user'     => $user,
		], 200);
	}

	public function uploadThumbnail(ProfilePictureRequest $request): JsonResponse
	{
		$user = User::find(auth()->user()->id);

		if ($request->hasFile('thumbnail')) {
			if ($user->thumbnail != null) {
				Storage::disk('public')->delete($user->thumbnail);
			}
			$thumbnailPath = $request->thumbnail->store('thumbnails', 'public');
			$user->thumbnail = '/storage/' . $thumbnailPath;
			$user->save();
		}

		return response()->json([
			'user'    => $user,
		], 201);
	}
}
