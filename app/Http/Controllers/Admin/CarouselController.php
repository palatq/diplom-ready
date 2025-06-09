<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{
    public function index()
    {
        $carousels = Carousel::orderBy('order')->get();
        return view('admin.carousels.index', compact('carousels'));
    }

    public function create()
    {
        return view('admin.carousels.create');
    }

   public function store(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'link' => 'nullable|url'
    ]);

    $imagePath = $request->file('image')->store('carousels', 'public');

    Carousel::create([
        'image_path' => $imagePath,
        'order' => Carousel::max('order') + 1,
        'title' => $request->title,
        'description' => $request->description,
        'link' => $request->link,
        'is_active' => $request->has('is_active')
    ]);

    return redirect()->route('admin.carousels.index')
                   ->with('success', 'Изображение успешно добавлено');
}

    public function destroy(Carousel $carousel)
    {
        Storage::disk('public')->delete($carousel->image_path);
        $carousel->delete();

        return back()->with('success', 'Изображение удалено');
    }
}