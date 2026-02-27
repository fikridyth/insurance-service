<?php

namespace App\Interfaces\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                "success" => false,
                "message" => "Unauthenticated"
            ], 401);
        }

        if (!in_array($user->role, $roles)) {
            return response()->json([
                "success" => false,
                "message" => "You do not have permission to perform this action"
            ], 403);
        }

        return $next($request);
    }
}