<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ProfilePictureRequest;

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
			$thumbnail = $request->file('thumbnail');
			$filename = $thumbnail->store('thumbnails', 'public');
			$user->thumbnail = $filename;
			$user->save();
		}

		return response()->json([
			'message' => 'Thumbnail uploaded successfully',
		]);
	}
}
