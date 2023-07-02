<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'             => $this->id,
			'content_en'     => $this->getTranslation('content', 'en'),
			'content_ka'     => $this->getTranslation('content', 'ka'),
			'thumbnail'      => $this->thumbnail,
			'movie_id'       => $this->movie_id,
			'likes_count'    => $this->likes()->count(),
			'comments_count' => $this->comments()->count(),
			'comments'       => CommentResource::collection($this->comments),
		];
	}
}
