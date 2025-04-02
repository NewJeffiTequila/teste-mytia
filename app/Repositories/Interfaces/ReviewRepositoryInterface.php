<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Review;

interface ReviewRepositoryInterface
{
    public function getByTitle(string $title): Collection;
    public function save(array $data): Review;
    public function delete(int $id): bool;
}
