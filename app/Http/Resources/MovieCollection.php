<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MovieCollection extends ResourceCollection
{
	/**
	 * Transform the resource collection into an array.
	 *
	 * @return array<int|string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return $this->collection->sortByDesc('created_at')->map(function ($movie) {
			return [
				'id'           => $movie->id,
				'name'         => $movie->name,
				'release_year' => $movie->release_year,
				'thumbnail'    => $movie->thumbnail,
				'quotes_count' => $movie->quotes()->count(),
			];
		})->all();
	}
}
