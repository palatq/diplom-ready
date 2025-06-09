<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string|max:2000',
    ]);

    // Сохраняем feedback
    $feedback = Feedback::create($validated);
    
    // Перенаправляем с сообщением об успехе
    return redirect()->route('contacts')
           ->with('success', 'Спасибо! Ваше сообщение отправлено.');
}

    public function index()
    {
        $feedback = Feedback::latest()->get();
        return view('admin.feedback', compact('feedback'));
    }
}