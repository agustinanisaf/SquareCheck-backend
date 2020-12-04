<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  String $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // Pre-Middleware Action
        if (!$request->user()->can($role)) {
            return response()->json([
                'code' => 403,
                'message' => 'Forbidden',
                'description' => 'User insufficient permissions.',
            ], 403);
        }

        $response = $next($request);

        // Post-Middleware Action

        return $response;
    }
}
