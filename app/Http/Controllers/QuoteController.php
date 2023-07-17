<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Quote\QuoteResource;
use App\Http\Requests\Quote\StoreQuoteRequest;
use App\Http\Requests\Quote\UpdateQuoteRequest;
use App\Http\Resources\NewsFeedResource;

class QuoteController extends Controller
{
	public function getQuote(Quote $quote): JsonResponse
	{
		$this->authorize('view', $quote);
		return response()->json(new QuoteResource($quote));
	}

	public function updateQuote(UpdateQuoteRequest $request, Quote $quote): JsonResponse
	{
		$this->authorize('update', $quote);
		$quote->update([
			...$request->validated(),
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

	public function deleteQuote(Quote $quote): JsonResponse
	{
		$this->authorize('delete', $quote);
		Storage::disk('public')->delete($quote->thumbnail);
		$quote->delete();
		return response()->json(['message' => 'Quote deleted successfully']);
	}

	public function StoreQuote(StoreQuoteRequest $request): JsonResponse
	{
		$thumbnailPath = $request->thumbnail->store('quotes', 'public');

		$quote = Quote::create([
			...$request->validated(),
			'user_id'    => auth()->id(),
			'thumbnail'  => '/storage/' . $thumbnailPath,
		]);

		return response()->json(new QuoteResource($quote));
	}

	public function getQuotes(int $page): JsonResponse
	{
		$quotes = Quote::orderByDesc('created_at')->paginate(5, ['*'], 'page', $page);
		$remainingPages = $quotes->lastPage() - $quotes->currentPage();
		return response()->json([
			'data'            => NewsFeedResource::collection($quotes),
			'remaining_pages' => $remainingPages,
		]);
	}
}
