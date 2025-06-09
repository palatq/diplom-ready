<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductMessageController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\SellerModerationController;
use App\Http\Controllers\Admin\ProductModerationController;
use App\Http\Controllers\Admin\CarouselController;
use App\Http\Controllers\PaymentController;
use App\Models\Product;
use App\Models\Category;

// Главная страница
Route::get('/', function () {
    return view('welcome');
});

// Public product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Защищённые маршруты (требуется вход)
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard — только категории, баннеры и преимущества
    Route::get('/dashboard', function () {
        $categories = Category::has('products')->withCount('products')->orderBy('name')->get();
        $carousels = \App\Models\Carousel::orderBy('order')->get();

        return view('dashboard', compact('categories', 'carousels'));
    })->name('dashboard');

    // Каталог товаров — вся логика с фильтрацией, сортировкой и пагинацией
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');

    // Фильтрация по категории
    Route::get('/catalog/category/{category}', [CatalogController::class, 'filterByCategory'])
        ->name('catalog.category');

    // Сортировка через URL параметры
    Route::get('/catalog/sort/{field}/{direction}', [CatalogController::class, 'sort'])
        ->where(['field' => 'price|created_at|avg_rating|reviews_count', 'direction' => 'asc|desc'])
        ->name('catalog.sort');

    // Профиль пользователя
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // Заявка на стать продавцом
    Route::controller(SellerController::class)->group(function () {
        Route::get('/become-seller', 'create')->name('become.seller');
        Route::post('/become-seller', 'store')->name('seller.store');
    });

    // Продавец
    Route::prefix('seller')->middleware('seller')->group(function () {
        Route::get('/office', [SellerController::class, 'office'])->name('seller.office');

        // Товары
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Скидки
        Route::post('/products/{product}/update-discount', [ProductController::class, 'addDiscount'])
            ->name('seller.products.update-discount');
    });

    // Корзина
    Route::controller(CartController::class)->group(function () {
        Route::get('/cart', 'index')->name('cart.index');
        Route::post('/cart/add/{product}', 'add')->name('cart.add');
        Route::delete('/cart/{cartItem}', 'remove')->name('cart.remove');
        Route::patch('/cart/update/{cartItem}', 'update')->name('cart.update');
    });

    // Отзывы
    Route::controller(ReviewController::class)->group(function () {
        Route::post('/reviews', 'store')->name('reviews.store');
        Route::delete('/reviews/{review}', 'destroy')->name('reviews.destroy');
    });

    // Админка
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/', function () {
            return view('admin');
        })->name('admin.dashboard');

        // Категории
        Route::controller(CategoryController::class)->group(function () {
            Route::get('/categories', 'index')->name('admin.categories');
            Route::post('/categories', 'store')->name('admin.categories.store');
        });

        // Модерация продавцов
        Route::controller(SellerModerationController::class)->group(function () {
            Route::get('/seller-moderation', 'index')->name('seller.moderation');
            Route::post('/approve-seller/{user}', 'approve')->name('seller.approve');
            Route::post('/reject-seller/{user}', 'reject')->name('seller.reject');
        });

        // Модерация товаров
        Route::controller(ProductModerationController::class)->group(function () {
            Route::get('/product-moderation', 'index')->name('product.moderation');
            Route::post('/products/{product}/approve', 'approve')->name('product.approve');
            Route::post('/products/{product}/reject', 'reject')->name('product.reject');
        });

        // Карусели
        Route::prefix('carousels')->group(function () {
            Route::get('/', [CarouselController::class, 'index'])->name('admin.carousels.index');
            Route::get('/create', [CarouselController::class, 'create'])->name('admin.carousels.create');
            Route::post('/', [CarouselController::class, 'store'])->name('admin.carousels.store');
            Route::delete('/{carousel}', [CarouselController::class, 'destroy'])->name('admin.carousels.destroy');
        });
    });

    // Статичные страницы
    Route::get('/about', function () {
        return view('about');
    })->name('about');

    Route::get('/contacts', function () {
        return view('contacts');
    })->name('contacts');

    // Обратная связь
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/admin/feedback', [FeedbackController::class, 'index'])->name('admin.feedback');

    // Сообщения к товарам
    Route::post('/products/{product}/messages', [ProductMessageController::class, 'store'])
        ->name('product.messages.store');
    Route::get('/messages', [ProductMessageController::class, 'index'])->name('messages.index');
    Route::get('/products/{product}/messages/{user}', [ProductMessageController::class, 'show'])
        ->name('messages.show');

    // Оформление заказа
    Route::prefix('checkout')->group(function () {
        Route::post('/prepare', [CheckoutController::class, 'prepare'])->name('checkout.prepare');
        Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
        Route::get('/card', [CheckoutController::class, 'cardPayment'])->name('checkout.card');
        Route::get('/sbp', [CheckoutController::class, 'sbpPayment'])->name('checkout.sbp');
        Route::post('/complete', [CheckoutController::class, 'completePayment'])->name('checkout.complete');
        Route::get('/success', [CheckoutController::class, 'success'])->name('checkout.success');
    });
});

// API для быстрого просмотра товара
Route::get('/api/products/{product}/quickview', function (\App\Models\Product $product) {
    return response()->json([
        'id' => $product->id,
        'name' => $product->name,
        'description' => $product->description,
        'price' => $product->price,
        'formatted_price' => number_format($product->price, 2),
        'discount' => $product->discount,
        'formatted_discounted_price' => number_format($product->price * (1 - $product->discount / 100), 2),
        'avg_rating' => round($product->reviews_avg_rating ?? 0, 1),
        'reviews_count' => $product->reviews_count ?? 0,
        'image_url' => $product->image_url,
        'specifications' => json_decode($product->specifications, true) ?? [],
    ]);
})->name('product.quickview');
Route::middleware(['auth'])->group(function () {
    Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');

    // Страницы оплаты — эти методы должны быть в PaymentController
    Route::get('/checkout/card', [PaymentController::class, 'cardPayment'])->name('checkout.card');
    Route::get('/checkout/sbp', [PaymentController::class, 'sbpPayment'])->name('checkout.sbp');
    
    // Обработка завершения оплаты
    Route::post('/checkout/complete', [PaymentController::class, 'completePayment'])->name('checkout.complete');
});
Route::get('/dashboard', function () {
    $carousels = \App\Models\Carousel::orderBy('order')->get();
    
    return view('dashboard', [
        'carousels' => $carousels
    ]);
})->name('dashboard');
// Продавцы — просмотр и отклонение
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/sellers', [SellerController::class, 'index'])->name('admin.sellers.index');
    Route::patch('/sellers/{user}', [SellerController::class, 'reject'])->name('admin.sellers.reject');
});
require __DIR__.'/auth.php';