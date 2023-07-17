<?php

namespace App\Http\Requests\Quote;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuoteRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'content_en' => 'required|string',
			'content_ka' => 'required|string',
			'thumbnail'  => 'image',
		];
	}
}
