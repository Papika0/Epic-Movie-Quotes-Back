<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'token'                 => 'required',
			'email'                 => 'required|email|exists:users,email',
			'password'              => 'required|min:8|max:15',
		];
	}
}
