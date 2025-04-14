<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        $roleList = array_map('trim', explode('|', $roles));
        if (!auth()->check() || !in_array(auth()->user()->role, (array)$roleList)) {
            abort(403, 'Unauthorized.');
        }
        return $next($request);
    }
}
