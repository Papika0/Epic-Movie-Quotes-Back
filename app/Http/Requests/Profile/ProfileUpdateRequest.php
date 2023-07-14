<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'email'    => 'email|unique:users,email|nullable',
			'username' => 'string|unique:users,username|nullable',
			'password' => 'string|nullable',
		];
	}
}
