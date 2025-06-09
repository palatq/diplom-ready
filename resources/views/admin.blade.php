<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Главная страница') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Контент админки -->
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Добро пожаловать в админку, {{ auth()->user()->name }}!</h3>
                    <p class="mt-2">Здесь будут административные функции.</p>

                    <div class="mt-4">
                    <!-- Карусель -->
                    <x-nav-link href="{{ route('admin.carousels.index') }}" :active="request()->routeIs('admin.carousels.*')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                            {{ __('Карусель') }}
                        </x-nav-link>
                    <!-- Добавленная кнопка -->                  
                    <x-nav-link :href="route('admin.categories')" :active="request()->routeIs('admin.categories')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                        {{ __('Добавить категории') }}

                    </x-nav-link>     
                    <!-- Новая кнопка модерации -->
                    <x-nav-link :href="route('seller.moderation')" :active="request()->routeIs('seller.moderation')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:ring focus:ring-green-300 disabled:opacity-25 transition">
                                {{ __('Модерация продавцов') }}
                    </x-nav-link>
                    <!-- Кнопка модерации товаров-->
                    <x-nav-link :href="route('product.moderation')" :active="request()->routeIs('product.moderation')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:ring focus:ring-green-300 disabled:opacity-25 transition">
                                {{ __('Модерация товаров') }}
                    </x-nav-link>
                    <!-- Просмотр продавцов -->
                    <x-nav-link :href="route('admin.sellers.index')" :active="request()->routeIs('admin.sellers.index')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                    {{ __('Все продавцы') }}
                    </x-nav-link>
               </div>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>