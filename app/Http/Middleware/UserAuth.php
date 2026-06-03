<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('user.login')->withErrors(['error' => 'Silakan login terlebih dahulu']);
        }

        return $next($request);
    }
}
