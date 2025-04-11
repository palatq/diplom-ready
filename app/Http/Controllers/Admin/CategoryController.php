<?php

namespace App\Http\Controllers\Admin;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
{
    $categories = Category::all();
    return view('categories', compact('categories')); // Убрали 'admin.'
}

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:categories,name'
    ]);
    
    Category::create($validated);
    
    return redirect()->route('admin.categories')
           ->with('success', 'Категория успешно добавлена');
}
}
