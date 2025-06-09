<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
{
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $cartItems = $user->cartItems()->with('product')->get();

    // Вычисляем общую сумму с учётом скидок
    $total = 0;
    foreach ($cartItems as $item) {
        if ($item->product->discount > 0) {
            $price = $item->product->price * (1 - $item->product->discount / 100);
        } else {
            $price = $item->product->price;
        }
        $item->final_price = $price; // Добавляем атрибут для использования в Blade
        $total += $price * $item->quantity;
    }

    return view('cart.index', [
        'cartItems' => $cartItems,
        'total' => $total
    ]);
}

    public function add(Request $request, Product $product)
{
    $request->validate([
        'quantity' => 'nullable|integer|min:1|max:10'
    ]);

    /** @var \App\Models\User $user */
    $user = Auth::user();
    
    // Проверяем, не добавлен ли уже товар
    $cartItem = $user->cartItems()->firstOrNew(
        ['product_id' => $product->id],
        ['quantity' => 0]
    );
    
    $quantity = $request->input('quantity', 1);
    $cartItem->quantity += $quantity;
    $cartItem->save();

    if ($request->wantsJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Товар добавлен в корзину',
            'cart_count' => $user->cartItems()->count(),
            'item' => $cartItem->load('product')
        ]);
    }

    return back()->with('success', 'Товар добавлен в корзину');
}

    public function remove(CartItem $cartItem)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Проверка прав доступа
        if ($cartItem->user_id !== $user->id) {
            return request()->wantsJson() 
                ? response()->json(['error' => 'Unauthorized'], 403)
                : abort(403);
        }
        
        $itemId = $cartItem->id;
        $cartItem->delete();
        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Товар удалён из корзины',
                'cart_count' => $user->cartItems()->count(),
                'item_id' => $itemId
            ]);
        }

        return back()->with('success', 'Товар удалён из корзины');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if ($cartItem->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $cartItem->update(['quantity' => $validated['quantity']]);

        return response()->json([
            'success' => true,
            'message' => 'Количество обновлено',
            'total' => $user->cartItems()->with('product')
                ->get()
                ->sum(fn($item) => $item->product->price * $item->quantity)
        ]);
    }
}