<?php

namespace App\Jobs;

use App\Models\PopularMovie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CacheMovieDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct() {}


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $movies = PopularMovie::all();

        foreach ($movies as $movie) {
            $cacheKey = "movie_{$movie->title}";

            if (!Cache::has($cacheKey)) {
                $apiKey = env('OMDB_API_KEY');
                $response = Http::get("https://www.omdbapi.com/?apikey={$apiKey}&t={$movie->title}");

                if ($response->successful()) {
                    Cache::put($cacheKey, $response->json(), now()->addHours(6)); // Cache de 6 horas
                }
            }
        }
    }
}
