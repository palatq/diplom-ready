<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Получаем только карусель
        $carousels = Carousel::where('is_active', true)->orderBy('order')->get();

        return view('dashboard', compact('carousels'));
    }
}