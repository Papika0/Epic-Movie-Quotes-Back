<?php

namespace App\Http\Resources\Movie;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
	/**
	 * Transform the resource collection into an array.
	 *
	 * @return array<int|string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'           => $this->id,
			'name'         => $this->name,
			'release_year' => $this->release_year,
			'thumbnail'    => $this->thumbnail,
			'quotes_count' => $this->quotes()->count(),
		];
	}
}
