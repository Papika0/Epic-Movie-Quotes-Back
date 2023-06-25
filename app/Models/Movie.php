<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Movie extends Model
{
	use HasFactory , HasTranslations;

	public $translatable = ['name', 'director', 'description'];

	protected $guarded = ['id'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function quotes()
	{
		return $this->hasMany(Quote::class);
	}

	public function genres()
	{
		return $this->belongsToMany(Genre::class, 'movie_genres');
	}
}
