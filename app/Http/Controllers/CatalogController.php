<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CatalogController extends Controller
{
    /**
     * Отображает все товары каталога.
     */
    public function index(Request $request)
{
    // Начинаем строить запрос
    $query = Product::query()
    ->with('category')
    ->where('moderation_status', Product::MODERATION_APPROVED)
    ->withAvg('reviews', 'rating')
    ->withCount('reviews');
    // Фильтр по категории
    $selectedCategory = null;
    if ($request->has('category')) {
        $categoryId = $request->input('category');
        $selectedCategory = Category::findOrFail($categoryId);
        $query->where('category_id', $categoryId);
    }

    // Сортировка
    if ($request->has('sort')) {
        switch ($request->input('sort')) {
    case 'price_asc':
        $query->orderBy('price', 'asc');
        break;
    case 'price_desc':
        $query->orderBy('price', 'desc');
        break;
    case 'rating_desc':
        $query->orderByDesc('reviews_avg_rating');
        break;
    case 'reviews_desc':
        $query->orderByDesc('reviews_count');
        break;
    case 'newest':
        $query->latest();
        break;
    default:
        $query->latest();
        break;
}
    }

    // Пагинация
    $products = $query->paginate(12);
    $categories = Category::has('products')->withCount('products')->get();

    return view('catalog', compact('products', 'categories', 'selectedCategory'));
}

    /**
     * Фильтрует товары по указанной категории.
     */
   public function filterByCategory(Request $request, Category $category)
{
    $products = Product::where('category_id', $category->id)
        ->where('moderation_status', Product::MODERATION_APPROVED)
        ->latest()
        ->paginate(12);

    $categories = Category::has('products')->withCount('products')->get();

    return view('catalog', array_merge(
        compact('products', 'categories'),
        ['selectedCategory' => $category]
    ));
}

    /**
     * Сортирует товары по указанному полю и направлению.
     */
    public function sort(Request $request, $field, $direction)
    {
        $allowedFields = ['price', 'created_at', 'reviews_avg_rating', 'reviews_count'];
        if (!in_array($field, $allowedFields)) {
            abort(404);
        }

        $query = Product::query()
            ->with('category')
            ->where('moderation_status', Product::MODERATION_APPROVED);

        // Применяем сортировку
        if ($direction === 'desc') {
            $query->orderByDesc($field);
        } else {
            $query->orderBy($field);
        }

        $products = $query->paginate(12);
        $categories = Category::has('products')->withCount('products')->get();

        return view('catalog', compact('products', 'categories'));
    }
}