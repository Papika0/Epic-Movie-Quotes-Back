<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('genres_movies', function (Blueprint $table) {
			$table->foreignId('movie_id')->constrained()->onDelete('cascade');
			$table->foreignId('genre_id')->constrained()->onDelete('cascade');
			$table->primary(['movie_id', 'genre_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('genres_movies');
	}
};
