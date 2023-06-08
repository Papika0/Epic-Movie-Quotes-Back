<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyEmailRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'id'   => 'nullable|integer',
			'hash' => 'nullable',
		];
	}
}
