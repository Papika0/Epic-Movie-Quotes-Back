<?php

namespace App\Http\Resources\Movie;

use App\Http\Resources\Genre\GenreResource;
use App\Http\Resources\Quote\QuoteCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieDetailResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'              => $this->id,
			'name_en'         => $this->getTranslation('name', 'en'),
			'name_ka'         => $this->getTranslation('name', 'ka'),
			'director_en'     => $this->getTranslation('director', 'en'),
			'director_ka'     => $this->getTranslation('director', 'ka'),
			'description_en'  => $this->getTranslation('description', 'en'),
			'description_ka'  => $this->getTranslation('description', 'ka'),
			'name'            => $this->name,
			'description'     => $this->description,
			'director'        => $this->director,
			'thumbnail'       => $this->thumbnail,
			'release_year'    => $this->release_year,
			'quotes_count'    => $this->quotes()->count(),
			'quotes'          => new QuoteCollection($this->quotes->sortByDesc('created_at')),
			'genres'          => GenreResource::collection($this->genres),
			'user_id'         => $this->user_id,
		];
	}
}
