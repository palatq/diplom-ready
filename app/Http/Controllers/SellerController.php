<?php

namespace App\Http\Controllers;
use App\Models\Product;
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
        ->where('status', 0) // Только те, которые на модерации
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
     public function office()
    {
        $user = Auth::user();
        $products = Product::with(['reviews', 'category'])
            ->where('user_id', $user->id)
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->paginate(10);

        return view('seller.office', [
            'products' => $products,
            'averageRating' => $products->avg('reviews_avg_rating'),
            'totalProducts' => $products->total()
        ]);
    }
     public function index()
    {
        $sellers = User::where('seller', 1)->get();
        return view('admin.sellers.index', compact('sellers'));
    }

    /**
     * Отклонить статус продавца у пользователя
     */
    public function reject(User $user)
{
    // Обновляем статус пользователя
    $user->update(['seller' => 0]);

    // Находим активные заявки и помечаем их как "отклонённые"
    $user->sellerApplications()
        ->whereIn('status', [0, 1])
        ->update(['status' => 2]); // 2 = rejected

    return back()->with('success', 'Продавец успешно отклонён');
}
}