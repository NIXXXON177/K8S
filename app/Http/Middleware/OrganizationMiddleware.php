<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrganizationMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isTenant()) {
            if ($request->expectsJson()) {
                abort(403);
            }
            return redirect()->route('login');
        }

        return $next($request);
    }
}
