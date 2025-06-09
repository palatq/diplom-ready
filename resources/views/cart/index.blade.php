<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Корзина (<span class="cart-count text-indigo-600">{{ $cartItems->count() }}</span>)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Toast уведомление -->
            <div id="toast" class="hidden fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50"></div>

            @if($cartItems->isEmpty())
                <div class="bg-white dark:bg-gray-800 p-6 text-center rounded-lg">
                    <p class="text-white dark:text-white">Ваша корзина пуста</p>
                    <a href="{{ route('catalog') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">
                        Вернуться к покупкам
                    </a>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                        <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-4" id="cart-item-{{ $item->id }}">
                            <div class="flex items-center space-x-4">
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded">
                                <div class="text-white dark:text-white">
                                    <h3 class="font-medium">{{ $item->product->name }}</h3>
                                    @if($item->product->discount > 0)
    <p class="text-red-500 font-bold">
        {{ number_format($item->final_price, 2, ',', ' ') }} ₽ × 
        <span class="text-gray-500 line-through text-sm">
            {{ $item->product->formatted_price }}
        </span>
    </p>
@else
    <p>
        {{ $item->product->formatted_price }} × 
    </p>
@endif
<input type="number" value="{{ $item->quantity }}" min="1" max="10" 
       class="w-18 text-center border rounded bg-gray-700 text-indigo-600" 
       onchange="updateQuantity({{ $item->id }}, this.value)">
                                </div>
                            </div>
                            <form action="{{ route('cart.remove', $item) }}" method="POST" class="remove-item-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    Удалить
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex justify-between items-center text-white dark:text-white">
                        <p class="text-lg font-bold">Итого: <span class="text-indigo-600">{{ number_format($total, 2) }}</span> ₽</p>
                        <form action="{{ route('checkout.prepare') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cart_items" value="{{ $cartItems->map(function($item) {
                                return [
                                    'product_id' => $item->product_id,
'quantity' => $item->quantity,
'name' => $item->product->name,
'original_price' => $item->product->price,
'final_price' => $item->final_price,
'has_discount' => $item->product->discount > 0 ? true : false
                                ];
                            })->toJson() }}">
                            
                            <input type="hidden" name="total" value="{{ $total }}">
                            
                            <button type="submit" 
                                    class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-300">
                                Оформить заказ →
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Функция для показа toast уведомлений
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = `fixed top-5 right-5 text-white px-4 py-2 rounded-lg shadow-lg z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            toast.classList.remove('hidden');
            
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }

        // Обновление количества товара
        async function updateQuantity(itemId, quantity) {
            try {
                const response = await fetch(`/cart/update/${itemId}`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ quantity })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    showToast('Количество обновлено');
                    window.location.reload();
                } else {
                    throw new Error(data.message || 'Ошибка при обновлении количества');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast(error.message, 'error');
            }
        }

        // Удаление товара из корзины
        document.querySelectorAll('.remove-item-form').forEach(form => {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const button = this.querySelector('button');
                const originalText = button.innerHTML;
                button.innerHTML = '<span class="animate-spin">↻</span>';
                button.disabled = true;
                
                try {
                    const response = await fetch(this.action, {
                        method: 'POST',
                        body: new FormData(this),
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok) {
                        showToast(data.message);
                        document.getElementById(`cart-item-${data.item_id}`)?.remove();
                        const cartCountElements = document.querySelectorAll('.cart-count');
                        cartCountElements.forEach(el => {
                            el.textContent = data.cart_count;
                        });
                        if (data.cart_count == 0) {
                            window.location.reload();
                        }
                    } else {
                        throw new Error(data.message || 'Ошибка при удалении товара');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast(error.message, 'error');
                } finally {
                    button.innerHTML = originalText;
                    button.disabled = false;
                }
            });
        });
    </script>
</x-app-layout>