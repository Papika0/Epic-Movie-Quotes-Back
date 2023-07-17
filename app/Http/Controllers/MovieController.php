<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Movie\MovieResource;
use App\Http\Resources\Movie\MoviesResource;
use App\Http\Requests\Movie\StoreMovieRequest;
use App\Http\Requests\Movie\UpdateMovieRequest;
use App\Http\Resources\Movie\MovieEditResource;

class MovieController extends Controller
{
	public function getMovies(): JsonResponse
	{
		return response()->json(MoviesResource::collection(auth()->user()->movies->sortByDesc('created_at')));
	}

	public function getMovie(Movie $movie): JsonResponse
	{
		$this->authorize('view', $movie);
		return response()->json(new MovieResource($movie));
	}

	public function StoreMovie(StoreMovieRequest $request): JsonResponse
	{
		$thumbnailPath = $request->thumbnail->store('movies', 'public');

		$movie = Movie::create([
			...$request->validated(),
			'user_id'      => auth()->id(),
			'thumbnail'    => '/storage/' . $thumbnailPath,
		]);

		$movie->genres()->sync($request->genre_ids);

		return response()->json(new MoviesResource($movie));
	}

	public function editMovie(Movie $movie): JsonResponse
	{
		return response()->json(new MovieEditResource($movie));
	}

	public function updateMovie(UpdateMovieRequest $request, Movie $movie): JsonResponse
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

		return response()->json(new MoviesResource($movie));
	}

	public function deleteMovie(Movie $movie): JsonResponse
	{
		$this->authorize('delete', $movie);
		$movie->delete();

		return response()->json(['message' => 'Movie deleted successfully']);
	}
}
