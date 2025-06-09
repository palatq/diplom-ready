<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
class CheckoutController extends Controller
{
    public function index()
{
    /** @var \App\Models\User $user */
    $user = Auth::user();
    
    // Явно загружаем продукт с нужными полями
    $cartItems = $user->cartItems()->with(['product' => function($query) {
        $query->select('id', 'name', 'description', 'price', 'image_path');
    }])->get();
    
    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Ваша корзина пуста');
    }

    // Добавляем image_url вручную для каждого товара
    $cartItems->each(function ($item) {
        $item->product->image_url = $item->product->image_path 
            ? asset('storage/' . $item->product->image_path)
            : null;
    });

    $total = $cartItems->sum(function($item) {
        return $item->product->price * $item->quantity;
    });

    return view('products.checkout', [
        'cartItems' => $cartItems,
        'total' => $total,
        'pickupPoints' => $this->getStaticPickupPoints()
    ]);
}

   public function processCheckout(Request $request)
{
    $validated = $request->validate([
        'pickup_point_id' => 'required|integer',
        'payment_method' => 'required|in:card,sbp'
    ]);

    session([
        'checkout.pickup_point_id' => $request->input('pickup_point_id'),
        'checkout.payment_method' => $request->input('payment_method')
    ]);

    return redirect()->route('checkout.' . $validated['payment_method']);
}
    public function cardPayment()
    {
        if (!$this->validateCheckoutSession()) {
            return redirect()->route('checkout.index');
        }

        return view('payments.card', [
            'total' => session('checkout.total')
        ]);
    }

    public function sbpPayment()
    {
        if (!$this->validateCheckoutSession()) {
            return redirect()->route('checkout.index');
        }

        return view('payments.sbp', [
            'qrCode' => $this->generateQrCode(),
            'total' => session('checkout.total')
        ]);
    }

    public function completePayment(Request $request)
    {
        if (!$this->validateCheckoutSession()) {
            return redirect()->route('checkout.index');
        }

        Session::forget(['cart.items', 'checkout']);
        return redirect()->route('checkout.success');
    }

    public function success()
    {
        return view('payments.success');
    }

    // Вспомогательные методы
    private function validateCheckoutSession(): bool
    {
        return Session::has('cart.items') && 
               !empty(Session::get('cart.items')) && 
               Session::has('checkout.payment_method');
    }

    private function calculateTotal(array $items): float
    {
        return array_reduce($items, 
            fn($sum, $item) => $sum + ($item['price'] * $item['quantity']), 
            0
        );
    }

    private function generateQrCode(): string
    {
        $total = session('checkout.total');
        return 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . 
               urlencode('payment:amount='.$total.'&currency=RUB');
    }

    private function getStaticPickupPoints(): array
    {
        return [
            [
            'id' => 1,
            'name' => 'Пункт выдачи',
            'address' => 'Набережные Челны, Моторная ул., 13А',
            'work_hours' => '8:00-16:00',
            'coords' => [55.738730, 52.481222],
            
            ],
             [
            'id' => 2,
            'name' => 'Пункт выдачи',
            'address' => 'Набережные Челны, просп. Мира, 88/20',
            'work_hours' => '9:00-22:00',
            'coords' => [55.754971, 52.430677],
            
            ],
             [
            'id' => 3,
            'name' => 'Пункт выдачи',
            'address' => 'Набережные Челны, просп. Мира, 49А',
            'work_hours' => '9:00-22:00',
            'coords' => [55.739869, 52.405040],
            
            ],
             [
            'id' => 4,
            'name' => 'Пункт выдачи',
            'address' => 'Набережные Челны, просп. Мира, 3',
            'work_hours' => '9:00-22:00',
            'coords' => [55.724895, 52.381305],
            
            ],
             [
            'id' => 5,
            'name' => 'Пункт выдачи',
            'address' => 'Набережные Челны, Набережночелнинский просп., 13А',
            'work_hours' => '9:00-22:00',
            'coords' => [55.704853, 52.342716],
            
            ]
        ];
    }
    public function prepare(Request $request)
{
    $validated = $request->validate([
        'cart_items' => 'required|json',
        'total' => 'required|numeric'
    ]);

    $items = json_decode($request->input('cart_items'), true);

    // Получаем товары из БД
    $productIds = array_column($items, 'product_id');
    $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

    // Формируем $cartItems с актуальными данными
    $cartItems = collect($items)->map(function ($item) use ($products) {
        $product = $products->get($item['product_id']);
        return (object) [
            'product' => $product,
            'quantity' => $item['quantity']
        ];
    });

    return view('products.checkout', [
        'cartItems' => $cartItems,
        'total' => $validated['total'],
        'pickupPoints' => $this->getStaticPickupPoints()
    ]);
}

}