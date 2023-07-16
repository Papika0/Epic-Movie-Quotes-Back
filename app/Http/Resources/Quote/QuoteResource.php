<?php

namespace App\Http\Resources\Quote;

use App\Http\Resources\Comment\CommentResource;
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
			'id'                 => $this->id,
			'content_en'         => $this->getTranslation('content', 'en'),
			'content_ka'         => $this->getTranslation('content', 'ka'),
			'thumbnail'          => $this->thumbnail,
			'movie_id'           => $this->movie_id,
			'likes_count'        => $this->likes()->count(),
			'liked_by_user'      => $this->likes()->where('user_id', auth()->user()->id)->exists(),
			'comments_count'     => $this->comments()->count(),
			'comments'           => CommentResource::collection($this->comments),
			'user_id'            => $this->user_id,
		];
	}
}
