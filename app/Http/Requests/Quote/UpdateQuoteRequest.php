<?php

namespace App\Http\Requests\Quote;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuoteRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'content.en' => 'required|string',
			'content.ka' => 'required|string',
			'thumbnail'  => 'image',
		];
	}
}
