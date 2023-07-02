<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddQuoteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
			'content_en' => 'required|string',
			'content_ka' => 'required|string',
			'thumbnail'  => 'image',
            'movie_id'   => 'required|exists:movies,id',
		];
    }
}
