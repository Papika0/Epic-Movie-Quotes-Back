<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Events\CommentAdded;
use App\Models\Notification;
use App\Events\NotificationSend;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CommentResource;
use App\Http\Resources\NotificationResource;
use App\Http\Requests\Comment\StoreCommentRequest;

class CommentController extends Controller
{
	public function store(StoreCommentRequest $request, Quote $quote): JsonResponse
	{
		$comment = $quote->comments()->create([
			...$request->validated(),
			'user_id'  => auth()->id(),
			'quote_id' => $quote->id,
		]);

		event(new CommentAdded(
			new CommentResource($comment)
		));

		$notification = Notification::create([
			'to'       => $quote->user->id,
			'from'     => auth()->user()->id,
			'quote_id' => $quote->id,
			'type'     => 'comment',
			'read'     => 0,
		]);

		event(new NotificationSend(new NotificationResource($notification)));

		return response()->json(new CommentResource($comment));
	}
}
