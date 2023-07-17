<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return[
			'id'       => $this->id,
			'from'     => new UserResource($this->sender),
			'to'       => $this->receiver->id,
			'quote_id' => $this->quote_id,
			'type'     => $this->type,
			'read'     => $this->read,
			'created'  => $this->created_at->diffForHumans(),
		];
	}
}
