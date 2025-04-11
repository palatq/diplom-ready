<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\EnsureUserIsSeller;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Основные маршруты
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/admin', function () {
        return view('admin');
    })->name('admin.dashboard');

    // Профиль
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Маршруты продавца
    Route::controller(SellerController::class)->group(function () {
        Route::get('/become-seller', 'create')->name('become.seller');
        Route::post('/become-seller', 'store')->name('seller.store');
    });

    // Маршруты товаров (только для продавцов)
    Route::middleware('seller')->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    });
});

require __DIR__.'/auth.php';