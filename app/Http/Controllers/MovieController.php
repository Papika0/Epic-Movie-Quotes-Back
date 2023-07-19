<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Movie\MovieResource;
use App\Http\Requests\Movie\StoreMovieRequest;
use App\Http\Requests\Movie\UpdateMovieRequest;
use App\Http\Resources\Movie\MovieDetailResource;

class MovieController extends Controller
{
	public function index(): JsonResponse
	{
		return response()->json(MovieResource::collection(auth()->user()->movies->sortByDesc('created_at')));
	}

	public function get(Movie $movie): JsonResponse
	{
		$this->authorize('view', $movie);
		return response()->json(new MovieDetailResource($movie));
	}

	public function store(StoreMovieRequest $request): JsonResponse
	{
		$thumbnailPath = $request->thumbnail->store('movies', 'public');

		$movie = Movie::create([
			...$request->validated(),
			'user_id'      => auth()->id(),
			'thumbnail'    => '/storage/' . $thumbnailPath,
		]);

		$movie->genres()->sync($request->genre_ids);

		return response()->json(new MovieResource($movie));
	}

	public function update(UpdateMovieRequest $request, Movie $movie): JsonResponse
	{
		$this->authorize('update', $movie);
		$movie->update([
			...$request->validated(),
		]);
		if ($request->hasFile('thumbnail')) {
			Storage::disk('public')->delete($movie->thumbnail);
			$thumbnailPath = $request->thumbnail->store('movies', 'public');
			$movie->update([
				'thumbnail' => '/storage/' . $thumbnailPath,
			]);
		}

		$movie->genres()->sync($request->genre_ids);

		return response()->json(new MovieResource($movie));
	}

	public function destroy(Movie $movie): JsonResponse
	{
		$this->authorize('delete', $movie);
		$movie->delete();

		return response()->json(['message' => 'Movie deleted successfully'], 200);
	}
}
