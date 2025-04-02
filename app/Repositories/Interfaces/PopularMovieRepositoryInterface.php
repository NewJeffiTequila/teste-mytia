<?php
namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use App\Models\PopularMovie;

interface PopularMovieRepositoryInterface
{
    public function getAll(): Collection;
    public function findByTitle(string $title): ?PopularMovie;
    public function save(string $title): PopularMovie;
}
