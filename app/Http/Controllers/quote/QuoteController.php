<?php

namespace App\Http\Controllers\quote;

use App\Events\CommentAdded;
use App\Events\NotificationSend;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCommentRequest;
use App\Http\Requests\Quote\AddQuoteRequest;
use App\Http\Requests\Quote\EditQuoteRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\QuoteResource;
use App\Http\Resources\QuotesNewsFeedResource;
use App\Models\Notification;
use App\Models\Quote;
use Illuminate\Support\Facades\Storage;

class QuoteController extends Controller
{
	public function getQuote(Quote $quote)
	{
		return response()->json(new QuoteResource($quote));
	}

	public function updateQuote(Quote $quote, EditQuoteRequest $request)
	{
		$quote->update([
			'content'    => [
				'en' => $request->content_en,
				'ka' => $request->content_ka,
			],
		]);
		if ($request->hasFile('thumbnail')) {
			Storage::disk('public')->delete($quote->thumbnail);
			$thumbnailPath = $request->thumbnail->store('quotes', 'public');
			$quote->update([
				'thumbnail' => '/storage/' . $thumbnailPath,
			]);
		}
		return response()->json(new QuoteResource($quote));
	}

	public function deleteQuote(Quote $quote)
	{
		Storage::disk('public')->delete($quote->thumbnail);
		$quote->delete();
		return response()->json(['message' => 'Quote deleted successfully']);
	}

	public function createQuote(AddQuoteRequest $request)
	{
		$thumbnailPath = $request->thumbnail->store('quotes', 'public');

		$quote = Quote::create([
			'user_id'    => auth()->id(),
			'content'    => [
				'en' => $request->content_en,
				'ka' => $request->content_ka,
			],
			'movie_id'   => $request->movie_id,
			'thumbnail'  => '/storage/' . $thumbnailPath,
		]);

		return response()->json(new QuoteResource($quote));
	}

	public function createComment(Quote $quote, AddCommentRequest $request)
	{
		$comment = $quote->comments()->create([
			'user_id'  => auth()->id(),
			'content'  => $request->content,
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

	public function getQuotes($page)
	{
		$quotes = Quote::orderByDesc('created_at')->paginate(5, ['*'], 'page', $page);
		$remainingPages = $quotes->lastPage() - $quotes->currentPage();
		return response()->json([
			'data'            => QuotesNewsFeedResource::collection($quotes),
			'remaining_pages' => $remainingPages,
		]);
	}
}
