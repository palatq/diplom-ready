<x-app-layout>
    <div class="py-12">
        <div class="max-w-md mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-6">Оплата картой</h2>

            <!-- Форма номера карты -->
            <form action="{{ route('checkout.complete') }}" method="POST">
                @csrf
                <input type="hidden" name="payment_method" value="card">

                <div class="space-y-4">
                    <div>
                        <label class="block mb-1">Номер карты</label>
                        <input type="text" class="w-full p-2 border rounded" placeholder="1234 5678 9012 3456">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1">Срок действия</label>
                            <input type="text" class="w-full p-2 border rounded" placeholder="MM/ГГ">
                        </div>
                        <div>
                            <label class="block mb-1">CVV</label>
                            <input type="text" class="w-full p-2 border rounded" placeholder="123">
                        </div>
                    </div>

                    <!-- Кнопка отправки формы -->
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        Оплатить {{ number_format($total, 2) }} ₽
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>