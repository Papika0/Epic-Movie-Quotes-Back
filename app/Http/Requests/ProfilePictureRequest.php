<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfilePictureRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
		];
	}
}
