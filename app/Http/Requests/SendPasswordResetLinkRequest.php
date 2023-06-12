<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendPasswordResetLinkRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'email' => 'nullable|email|exists:users,email',
		];
	}
}
