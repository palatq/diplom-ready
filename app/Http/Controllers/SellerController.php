<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SellerController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        
        if ($user->seller) {
            return redirect()->route('products.create');
        }

        return view('become-seller');
    }

    public function store(Request $request)
    {
        $request->validate([
            'agree' => ['required', 'accepted']
        ]);

        User::where('id', Auth::id())->update(['seller' => true]);

        return redirect()->route('products.create')
            ->with('success', 'Теперь вы можете добавлять товары!');
    }
}