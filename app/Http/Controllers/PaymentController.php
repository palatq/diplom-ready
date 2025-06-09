<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Страница оплаты картой
    public function cardPayment()
    {
        $total = request()->session()->get('checkout.total', 0);
        return view('payments.card', compact('total'));
    }

    // Страница оплаты через СБП
    public function sbpPayment()
    {
        $total = request()->session()->get('checkout.total', 0);
        return view('payments.sbp', compact('total'));
    }

    // Подтверждение оплаты
    public function completePayment(Request $request)
    {
        if (!session()->has('checkout')) {
            return redirect()->route('checkout.index')->with('error', 'Данные о заказе не найдены');
        }

        // Очистка сессии
        session()->forget(['cart.items', 'checkout']);

        return view('payments.success');
    }
}