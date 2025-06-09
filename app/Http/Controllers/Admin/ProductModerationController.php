<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductModerationController extends Controller
{
    public function index(Request $request)
    {
        // Получаем все категории, у которых есть товары на модерации
        $categories = Category::whereHas('products', function($query) {
            $query->where('moderation_status', Product::MODERATION_PENDING);
        })->orderBy('name')->get();

        // Фильтрация товаров
        $products = Product::with('category')
            ->where('moderation_status', Product::MODERATION_PENDING)
            ->when($request->category, function($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.product-moderation', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $request->category
        ]);
    }

    public function approve($id)
    {
        $product = Product::with('category')->findOrFail($id);

        if (!$product->category_id) {
            return redirect()
                ->route('product.moderation')
                ->with('error', "Товар '{$product->name}' не может быть одобрен: не указана категория");
        }

        if (!$product->image_path) {
            return redirect()
                ->route('product.moderation')
                ->with('error', "Товар '{$product->name}' не может быть одобрен: отсутствует изображение");
        }

        $product->update(['moderation_status' => Product::MODERATION_APPROVED]);

        return redirect()
            ->route('product.moderation', ['category' => request('category')])
            ->with('success', "Товар '{$product->name}' успешно одобрен");
    }

    public function reject($id)
    {
        $product = Product::findOrFail($id);
        
        $product->update(['moderation_status' => Product::MODERATION_REJECTED]);

        return redirect()
            ->route('product.moderation', ['category' => request('category')])
            ->with('success', "Товар '{$product->name}' отклонен");
    }

    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $productIds = $request->input('product_ids', []);
    
        if (!in_array($action, ['approve', 'reject'])) { // Была пропущена закрывающая скобка
            return back()->with('error', 'Неверное действие');
        }
    
        $products = Product::whereIn('id', $productIds)->get();
    
        foreach ($products as $product) {
            $product->update([
                'moderation_status' => $action === 'approve' 
                    ? Product::MODERATION_APPROVED 
                    : Product::MODERATION_REJECTED
            ]);
        }
    
        return back()
            ->with('success', "Выполнено массовое действие: " . 
                  ($action === 'approve' ? 'одобрено' : 'отклонено') . 
                  " {$products->count()} товаров");
    }
}