<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMovieRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'name_en'                 => 'required|string',
			'name_ka'                 => 'required|string',
			'description_en'          => 'required|string',
			'description_ka'          => 'required|string',
			'director_en'             => 'required|string',
			'director_ka'             => 'required|string',
			'release_year'            => 'required|integer',
			'genre_ids'               => 'required',
			'thumbnail'               => 'required|image',
		];
	}
}
