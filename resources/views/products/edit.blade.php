<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Редактировать товар') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Название -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Название товара')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" 
                                    :value="old('name', $product->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Описание -->
                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Описание')" />
                        <textarea id="description" name="description" rows="4"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    required>{{ old('description', $product->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Категория -->
                    <div class="mb-4">
                        <x-input-label for="category_id" :value="__('Категория')" />
                        <select id="category_id" name="category_id"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <!-- Цена -->
                    <div class="mb-4">
                        <x-input-label for="price" :value="__('Цена')" />
                        <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" 
                                    :value="old('price', $product->price)" required />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    <!-- Скидка -->
                    <div class="mb-4">
                        <x-input-label for="discount" :value="__('Скидка (%)')" />
                        <x-text-input id="discount" class="block mt-1 w-full" type="number" name="discount" 
                                    :value="old('discount', $product->discount)" min="0" max="99" />
                        <x-input-error :messages="$errors->get('discount')" class="mt-2" />
                    </div>

                    <!-- Изображение -->
                    <div class="mb-4">
                        <x-input-label for="image" :value="__('Изображение')" />
                        <input id="image" class="block mt-1 w-full" type="file" name="image" />
                        <div class="mt-2">
                            <img src="{{ $product->image_url }}" alt="Текущее изображение" class="h-20">
                        </div>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Обновить товар') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>