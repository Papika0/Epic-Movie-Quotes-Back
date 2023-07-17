<?php

namespace App\Http\Requests\Movie;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'name.en'                 => 'required|string',
			'name.ka'                 => 'required|string',
			'description.en'          => 'required|string',
			'description.ka'          => 'required|string',
			'director.en'             => 'required|string',
			'director.ka'             => 'required|string',
			'release_year'            => 'required|integer',
			'genre_ids'               => 'required',
			'thumbnail'               => 'required|image',
		];
	}
}
