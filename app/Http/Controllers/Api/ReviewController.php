<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'rating' => 'required|integer|min:1|max:10',
            'comment' => 'nullable|string',
        ]);

        $review = Review::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        Cache::forget("reviews_{$request->title}");

        return response()->json(['message' => 'Avaliação criada com sucesso!', 'review' => $review], 201);
    }

    public function listByTitle($title)
    {
        $cacheKey = "reviews_{$title}";

        $reviews = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($title) {
            $data = Review::where('title', $title)->get();
            return $data->isEmpty() ? null : $data;
        });

        if (empty($reviews)) {
            return response()->json(['message' => 'Nenhuma avaliação encontrada para este título'], 404);
        }

        return response()->json($reviews);
    }

    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Avaliação não encontrada'], 404);
        }

        if (Auth::id() !== $review->user_id && Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Ação não permitida'], 403);
        }

        $title = $review->title;
        $review->delete();

        Cache::forget("reviews_{$title}");

        return response()->json(['message' => 'Avaliação excluída com sucesso!']);
    }
}
