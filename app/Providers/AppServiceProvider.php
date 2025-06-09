<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                /** @var User $user */
                $user = Auth::user();
                $cartCount = $user->cartItems()->sum('quantity');
                $view->with('cartCount', $cartCount);
            }
        });
    }
}