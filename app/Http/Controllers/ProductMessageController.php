<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductMessage;
use Illuminate\Http\Request;

class ProductMessageController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'receiver_id' => 'required|exists:users,id'
        ]);

        $product->messages()->create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        return back()->with('success', 'Сообщение отправлено!');
    }

    public function index()
    {
        $conversations = ProductMessage::with(['product', 'sender', 'receiver'])
            ->where(function($query) {
                $query->where('sender_id', auth()->id())
                      ->orWhere('receiver_id', auth()->id());
            })
            ->whereNull('parent_id')
            ->latest()
            ->get()
            ->groupBy(function($item) {
                return $item->product_id . '-' . 
                       min($item->sender_id, $item->receiver_id) . '-' . 
                       max($item->sender_id, $item->receiver_id);
            });

        return view('messages.index', compact('conversations'));
    }

    public function show(Product $product, $userId)
    {
        $currentChatUser = User::findOrFail($userId);
        
        $messages = ProductMessage::where('product_id', $product->id)
            ->where(function($query) use ($userId) {
                $query->where(function($q) use ($userId) {
                    $q->where('sender_id', auth()->id())
                      ->where('receiver_id', $userId);
                })->orWhere(function($q) use ($userId) {
                    $q->where('sender_id', $userId)
                      ->where('receiver_id', auth()->id());
                });
            })
            ->orderBy('created_at')
            ->get();

        $conversations = ProductMessage::with(['product', 'sender', 'receiver'])
            ->where(function($query) {
                $query->where('sender_id', auth()->id())
                      ->orWhere('receiver_id', auth()->id());
            })
            ->whereNull('parent_id')
            ->latest()
            ->get()
            ->groupBy(function($item) {
                return $item->product_id . '-' . 
                       min($item->sender_id, $item->receiver_id) . '-' . 
                       max($item->sender_id, $item->receiver_id);
            });

        return view('messages.show', [
            'product' => $product,
            'messages' => $messages,
            'userId' => $userId,
            'currentChatUser' => $currentChatUser,
            'conversations' => $conversations
        ]);
    }
}