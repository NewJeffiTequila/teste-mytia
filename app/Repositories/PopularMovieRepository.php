<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PopularMovieRepositoryInterface;
use App\Models\PopularMovie;
use Illuminate\Database\Eloquent\Collection;

class PopularMovieRepository implements PopularMovieRepositoryInterface
{
    public function getAll(): Collection
    {
        return PopularMovie::all();
    }

    public function findByTitle(string $title): ?PopularMovie
    {
        return PopularMovie::where('title', $title)->first();
    }

    public function save(string $title): PopularMovie
    {
        return PopularMovie::firstOrCreate(['title' => $title]);
    }
}
