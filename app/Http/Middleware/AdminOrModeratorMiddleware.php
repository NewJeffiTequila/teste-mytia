<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOrModeratorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!in_array($request->user()->role, ['admin', 'moderator'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
