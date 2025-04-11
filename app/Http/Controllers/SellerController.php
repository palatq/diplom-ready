<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SellerApplication; // Добавлен импорт модели

class SellerController extends Controller
{
    public function create()
    {
        // Добавляем проверку аутентификации
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user(); // Получаем текущего пользователя
        
        if ($user->seller) {
            return redirect()->route('products.create');
        }
        
        // Проверяем есть ли активная заявка
        $existingApplication = SellerApplication::where('user_id', $user->id)
            ->whereIn('status', [0, 1])
            ->first();
            
        return view('become-seller', ['hasPendingApplication' => (bool)$existingApplication]);
    }

    // Удаляем дублированный метод store() и оставляем этот
    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'message' => 'nullable|string|max:500',
            'agree' => ['required', 'accepted']
        ]);

        // Создаем заявку
        SellerApplication::create([
            'user_id' => Auth::id(), // Используем Auth::id() вместо auth()->id()
            'phone' => $request->phone,
            'message' => $request->message,
            'status' => 0 // На модерации
        ]);

        return redirect()->route('dashboard')
            ->with('status', 'Ваша заявка отправлена на модерацию');
    }
}