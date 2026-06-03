<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureJsonResponse
{
    public function handle(Request $request, Closure $next): Response
    {
        // Ensure API requests expect JSON responses
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
