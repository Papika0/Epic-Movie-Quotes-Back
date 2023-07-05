<?php

namespace App\Http\Controllers\like;

use App\Models\Quote;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
	public function like(Quote $quote)
	{
		$quote->likes()->attach(auth()->user()->id);

		return response()->json([
			'message'     => 'Quote liked successfully',
			'likes_count' => $quote->likes()->count(),
		]);
	}

	public function unLike(Quote $quote)
	{
		$quote->likes()->detach(auth()->user()->id);

		return response()->json([
			'message'     => 'Quote unliked successfully',
			'likes_count' => $quote->likes()->count(),
		]);
	}
}
