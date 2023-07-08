<?php

namespace App\Http\Controllers\like;

use App\Models\Quote;
use App\Events\QuoteLiked;
use App\Events\NotificationSend;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Notifications;

class LikeController extends Controller
{
	public function like(Quote $quote)
	{
		$quote->likes()->attach(auth()->user()->id);

		event(new QuoteLiked(
			[
				'quote_id'    => $quote->id,
				'likes_count' => $quote->likes()->count(),
			]
		));

		$notification = Notifications::create([
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

	public function unLike(Quote $quote)
	{
		$quote->likes()->detach(auth()->user()->id);

		event(new QuoteLiked(
			[
				'quote_id'    => $quote->id,
				'likes_count' => $quote->likes()->count(),
			]
		));

		Notifications::where('to', $quote->user->id)->where('from', auth()->user()->id)->where('type', 'like')->delete();

		return response()->json([
			'message'     => 'Quote unliked successfully',
		]);
	}
}
