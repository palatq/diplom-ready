<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('create', compact('categories'));
        // Обратите внимание - просто 'create' без префикса 'products.'
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|max:2048',
            'category_id' => 'required|exists:categories,id'
        ]);

        // Проверка аутентификации
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'image_path' => $imagePath,
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id() // Используем фасад Auth вместо глобальной функции auth()
        ]);

        return redirect()->route('products.create')
            ->with('success', 'Товар успешно добавлен!');
    }
}