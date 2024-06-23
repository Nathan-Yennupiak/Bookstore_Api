<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if the authenticated user's role is within the allowed roles
        if (!in_array($request->user()->role, $roles)) {
            // User's role is not authorized, return an error response
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // User's role is authorized, proceed to the next middleware or controller
        return $next($request);
    }

}
