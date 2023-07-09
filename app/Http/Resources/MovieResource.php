<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'           => $this->id,
			'name'         => $this->name,
			'description'  => $this->description,
			'director'     => $this->director,
			'thumbnail'    => $this->thumbnail,
			'release_year' => $this->release_year,
			'quotes_count' => $this->quotes()->count(),
			'quotes'       => new QuoteCollection($this->quotes->sortByDesc('created_at')),
			'genres'       => GenreResource::collection($this->genres),
			'user_id'      => $this->user_id,
		];
	}
}
