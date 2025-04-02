<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function getByTitle(string $title): Collection
    {
        return Review::where('title', $title)->get();
    }

    public function save(array $data): Review
    {
        return Review::create($data);
    }

    public function delete(int $id): bool
    {
        return Review::where('id', $id)->delete();
    }
}
