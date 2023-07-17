<?php

namespace App\Http\Controllers\like;

use App\Events\NotificationSend;
use App\Events\QuoteLikeUpdated;
use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationResource;
use App\Models\Notification;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
	public function like(Quote $quote): JsonResponse
	{
		$quote->likes()->attach(auth()->user()->id);

		event(new QuoteLikeUpdated(
			[
				'quote_id'    => $quote->id,
				'likes_count' => $quote->likes()->count(),
			]
		));

		$notification = Notification::create([
			'to'       => $quote->user->id,
			'from'     => auth()->user()->id,
			'quote_id' => $quote->id,
			'type'     => 'like',
			'read'     => 0,
		]);

		event(new NotificationSend(new NotificationResource($notification)));

		return response()->json([
			'message'     => 'Quote liked successfully',
		]);
	}

	public function unLike(Quote $quote): JsonResponse
	{
		$quote->likes()->detach(auth()->user()->id);

		event(new QuoteLikeUpdated(
			[
				'quote_id'    => $quote->id,
				'likes_count' => $quote->likes()->count(),
			]
		));

		Notification::where('to', $quote->user->id)->where('from', auth()->user()->id)->where('type', 'like')->delete();

		return response()->json([
			'message'     => 'Quote unliked successfully',
		]);
	}
}
