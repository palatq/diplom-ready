<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Модерация товаров') }}
            </h2>
            
            <!-- Фильтр по категориям -->
            <div class="relative">
                <form method="GET" action="{{ route('product.moderation') }}">
                    <select 
                        name="category" 
                        onchange="this.form.submit()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                    >
                        <option value="">Все категории</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-100 rounded">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-100 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($products->isEmpty())
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            Нет товаров для модерации
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Изображение</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Название</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Категория</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Цена</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Действия</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($products as $product)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <!-- Изображение -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($product->image_path)
                                                <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="h-16 w-16 object-cover rounded">
                                            @else
                                                <span class="text-red-500 dark:text-red-300">Нет изображения</span>
                                            @endif
                                        </td>
                                        
                                        <!-- Название -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $product->name }}
                                            </div>
                                        </td>
                                        
                                        <!-- Категория -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($product->category)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-100">
                                                    {{ $product->category->name }}
                                                </span>
                                            @else
                                                <span class="text-red-500 dark:text-red-300">Не указана</span>
                                            @endif
                                        </td>
                                        
                                        <!-- Цена -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ number_format($product->price, 0, '', ' ') }} ₽
                                        </td>
                                        
                                        <!-- Действия -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <form method="POST" action="{{ route('product.approve', $product->id) }}">
                                                    @csrf
                                                    <x-primary-button>
                                                        Одобрить
                                                    </x-primary-button>
                                                </form>
                                                <form method="POST" action="{{ route('product.reject', $product->id) }}">
                                                    @csrf
                                                    <x-danger-button>
                                                        Отклонить
                                                    </x-danger-button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>