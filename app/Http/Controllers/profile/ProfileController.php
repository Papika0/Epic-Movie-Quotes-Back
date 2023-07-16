<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ProfilePictureRequest;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
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
			$user->password = Hash::make($request->password);
		}

		$user->save();
		return response()->json([
			'message'  => 'Profile updated successfully',
			'user'     => $user,
		]);
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
			'message' => 'Thumbnail uploaded successfully',
			'user'    => $user,
		]);
	}
}
