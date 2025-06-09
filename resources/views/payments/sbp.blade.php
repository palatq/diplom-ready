<x-app-layout>
    <div class="py-12">
        <div class="max-w-md mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow text-center">
            <h2 class="text-xl font-bold mb-6">Оплата через СБП</h2>

            <!-- QR-код -->
            <div class="mb-6 p-4 bg-white inline-block">
                <img src="https://api.qrserver.com/v1/create-qr-code/?data= {{ urlencode("sbp://payment?amount={$total}") }}&size=200x200"
                     alt="QR-код для оплаты"
                     class="mx-auto">
            </div>

            <p class="mb-4">Или выберите банк в приложении</p>

            <!-- Отправка формы -->
            <form action="{{ route('checkout.complete') }}" method="POST">
                @csrf
                <input type="hidden" name="payment_method" value="sbp">

                <button type="submit" class="w-full bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">
                    Я оплатил
                </button>
            </form>
        </div>
    </div>
</x-app-layout>