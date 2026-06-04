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

        // Force Content-Type to application/json for POST/PUT/PATCH requests
        // so third-party clients don't need to set it explicitly
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH']) && !$request->headers->has('Content-Type')) {
            $request->headers->set('Content-Type', 'application/json');
        }

        return $next($request);
    }
}
