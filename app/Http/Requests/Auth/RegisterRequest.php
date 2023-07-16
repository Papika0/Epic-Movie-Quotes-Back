<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'username' => 'required|string|unique:users|min:3|max:15',
			'email'    => 'required|email|unique:users',
			'password' => 'required|string|min:8|max:15',
		];
	}
}
