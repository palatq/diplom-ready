<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Список товаров (для маршрута products.index)
     */
    public function index()
    {
        $products = Product::with('category')
            ->where('moderation_status', Product::MODERATION_APPROVED)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('dashboard', [
            'products' => $products,
            'categories' => Category::has('products')->orderBy('name')->get(),
            'selectedCategory' => null
        ]);
    }

    /**
     * Показ формы создания товара
     */
    public function create()
    {
        if (!Auth::user()->seller) {
            abort(403, 'Только продавцы могут добавлять товары');
        }

        $categories = Category::all();
        
        if ($categories->isEmpty()) {
            return back()->with('error', 'Нет доступных категорий. Обратитесь к администратору.');
        }

        return view('products.create', compact('categories'));
    }

    /**
     * Сохранение нового товара
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0.01',
            'image' => 'required|image|max:2048',
            'category_id' => 'required|exists:categories,id'
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'image_path' => $imagePath,
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id(),
            'moderation_status' => 0
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Товар успешно добавлен и ожидает модерации!');
    }

    /**
     * Просмотр товара
     */
    public function show(Product $product)
    {
        try {
            $product->load(['category']);
            
            $hasReviewsTable = Schema::hasTable('reviews');
            
            $reviewsData = [
                'avg_rating' => 0,
                'reviews_count' => 0
            ];

            if ($hasReviewsTable) {
                $product->load(['reviews.user']);
                $reviewsData['avg_rating'] = (float) $product->reviews->avg('rating') ?? 0;
                $reviewsData['reviews_count'] = $product->reviews->count();
            }

            $similarProducts = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->approved()
                ->limit(4)
                ->get();

            return view('products.show', array_merge(
                ['product' => $product, 'similarProducts' => $similarProducts],
                $reviewsData
            ));

        } catch (\Exception $e) {
            Log::error('Product show error: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Произошла ошибка при загрузке товара');
        }
    }
    public function destroy(Product $product)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Требуются права администратора');
        }
    
        // Простое удаление без сложных проверок
        $product->delete();
        
        return back()->with('success', 'Товар удалён');
    }
  public function addDiscount(Product $product, Request $request)
{
    $product->update([
        'discount' => $request->discount,
        'discounted_price' => $product->price * (1 - $request->discount / 100)
    ]);
    return back()->with('success', 'Скидка обновлена');
}
public function update(Request $request, Product $product)
{
    // Проверка прав
    if ($product->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
        abort(403);
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|max:2048'
    ]);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $validated['image_path'] = $path;
    }

    $product->update($validated);

    return redirect()->route('seller.office')
           ->with('success', 'Товар успешно обновлен');
}
public function edit(Product $product)
{
    // Проверяем, что пользователь - владелец товара или админ
    if ($product->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
        abort(403);
    }

    $categories = Category::all();
    return view('products.edit', compact('product', 'categories'));
}
}