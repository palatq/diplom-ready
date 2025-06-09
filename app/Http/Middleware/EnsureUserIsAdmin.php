<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class EnsureUserIsAdmin
{
    /**
     * Проверяет, является ли пользователь администратором
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User|null $user */
        $user = Auth::user();
        
        if (!$user || !$user->isAdmin()) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Доступ запрещен. Требуются права администратора');
        }
    
        return $next($request);
    }
}