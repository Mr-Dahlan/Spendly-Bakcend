<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckBanned
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && !$user->status) {
            return response()->json([
                'message' => 'This Account is banned.'
            ], 403);
        }

        return $next($request);
    }
}