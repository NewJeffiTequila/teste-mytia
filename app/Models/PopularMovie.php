<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopularMovie extends Model
{
    use HasFactory;
    protected $table = 'popular_movies';
    protected $fillable = ['title'];
    public $timestamps = true;
}
