<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsFeedResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		return [
			'id'                 => $this->id,
			'content'            => $this->content,
			'thumbnail'          => $this->thumbnail,
			'user'               => new UserResource($this->user),
			'comments'           => CommentResource::collection($this->comments),
			'liked_by_user'      => $this->likes()->where('user_id', auth()->user()->id)->exists(),
			'movie_name'         => $this->movie->name,
			'movie_release_date' => $this->movie->release_year,
			'likes_count'        => $this->likes()->count(),
		];
	}
}
