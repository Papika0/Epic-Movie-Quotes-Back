<?php

namespace App\Http\Controllers\quote;

use App\Models\Quote;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuoteResource;
use App\Http\Requests\AddQuoteRequest;
use App\Http\Requests\EditQuoteRequest;
use App\Http\Resources\CommentResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AddCommentRequest;
use App\Http\Resources\QuotesNewsFeedResource;

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

		return response()->json(new CommentResource($comment));
	}

	public function getQuotes($page)
	{
		$quotes = Quote::orderByDesc('created_at')->paginate(5, ['*'], 'page', $page);
		return response()->json(QuotesNewsFeedResource::collection($quotes));
	}
}
