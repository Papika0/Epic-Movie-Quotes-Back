<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieEditResource extends JsonResource
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
			'thumbnail'       => $this->thumbnail,
			'release_year'    => $this->release_year,
			'genres'          => GenreResource::collection($this->genres),
		];
	}
}
