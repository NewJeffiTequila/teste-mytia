<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Favorite;
use App\Models\PopularMovie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MoviesController extends Controller
{
    // Buscar filme/série na OMDb API
    public function searchMovie(Request $request)
    {
        $request->validate(['title' => 'required|string']);

        $apiKey = env('OMDB_API_KEY');
        $title = $request->title;
        $cacheKey = "movie_{$title}";

        $response = Http::get("http://www.omdbapi.com/?apikey={$apiKey}&t=" . urlencode($title));

        if ($response->failed()) {
            return response()->json(['error' => 'Erro ao buscar filme'], 500);
        }


        $data = $response->json();

        // Salva em cache
        Cache::put($cacheKey, $data, now()->addHours(6));

        // Salva no banco se ainda não estiver lá
        PopularMovie::firstOrCreate(['title' => $title]);

        return $data;


        return response()->json($response->json());
    }

    // Adicionar aos favoritos
    public function addFavorite(Request $request)
    {
        $request->validate([
            'imdb_id' => 'required|string',
            'title' => 'required|string',
            'year' => 'required|string',
            'type' => 'required|string',
            'poster' => 'nullable|string',
        ]);

        $user = Auth::user();

        // Evitar duplicação
        if (Favorite::where('user_id', $user->id)->where('imdb_id', $request->imdb_id)->exists()) {
            return response()->json(['message' => 'Já está nos favoritos'], 400);
        }

        $favorite = Favorite::create([
            'user_id' => $user->id,
            'imdb_id' => $request->imdb_id,
            'title' => $request->title,
            'year' => $request->year,
            'type' => $request->type,
            'poster' => $request->poster,
        ]);

        return response()->json(['message' => 'Adicionado aos favoritos', 'data' => $favorite], 201);
    }

    // Listar favoritos do usuário autenticado
    public function listFavorites()
    {
        $favorites = Auth::user()->favorites;
        return response()->json($favorites);
    }

    // Remover favorito
    public function removeFavorite($imdb_id)
    {
        $user = Auth::user();
        $favorite = Favorite::where('user_id', $user->id)->where('imdb_id', $imdb_id)->first();

        if (!$favorite) {
            return response()->json(['message' => 'Filme não encontrado nos favoritos'], 404);
        }

        $favorite->delete();

        return response()->json(['message' => 'Removido dos favoritos'], 200);
    }
}
