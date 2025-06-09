<x-app-layout>
    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center">
                <div class="text-green-500 mb-4">
                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                
                <h2 class="text-2xl font-bold mb-4">Заказ успешно оплачен!</h2>
                <p class="mb-6">Подробности доставки будут отправлены на email: <strong>{{ Auth::user()->email }}</strong></p>
                
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
                    <p class="font-medium">Примерный срок доставки: 2-3 рабочих дня</p>
                </div>
                
                <a href="{{ route('dashboard') }}" class="inline-block bg-blue-500 text-white px-6 py-3 rounded-lg">
                    Вернуться в магазин
                </a>
            </div>
        </div>
    </div>
</x-app-layout>