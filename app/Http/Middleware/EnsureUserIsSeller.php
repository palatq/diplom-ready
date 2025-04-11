<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsSeller
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->seller) {
            return redirect()->route('dashboard')
                ->with('error', 'Для доступа необходимо стать продавцом');
        }

        return $next($request);
    }
}