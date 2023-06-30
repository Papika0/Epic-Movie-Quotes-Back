<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class QuoteCollection extends ResourceCollection
{
	/**
	 * Transform the resource collection into an array.
	 *
	 * @return array<int|string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return $this->collection->map(function ($quote) {
			return [
				'id'              => $quote->id,
				'content'         => $quote->content,
				'thumbnail'       => $quote->thumbnail,
				'likes_count'     => $quote->likes()->count(),
				'comments_count'  => $quote->comments()->count(),
			];
		})->all();
	}
}
