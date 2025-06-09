<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'rating' => [
                'required',
                'numeric',
                'min:0.5',
                'max:5',
                function ($attribute, $value, $fail) {
                    if (fmod($value * 2, 1) != 0) {
                        $fail('Рейтинг должен быть кратен 0.5 (0.5, 1, 1.5, ..., 5)');
                    }
                }
            ],
            'comment' => 'required|string|max:1000'
        ]);

        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $validatedData['product_id'])
            ->first();

        if ($existingReview) {
            return back()
                ->withInput()
                ->withErrors(['review' => 'Вы уже оставляли отзыв на этот товар']);
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $validatedData['product_id'],
            'rating' => $validatedData['rating'],
            'comment' => $validatedData['comment']
        ]);

        return back()->with('success', 'Отзыв успешно опубликован!');
    }

    public function destroy($id)
{
    $review = Review::findOrFail($id);
    $user = Auth::user();

    if ($user->login === 'admin' || $user->id === $review->user_id) {
        $review->delete();
        return back()->with('success', 'Отзыв удалён');
    }

    abort(403);
}
}