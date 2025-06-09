<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Управление каруселью
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <a href="{{ route('admin.carousels.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Добавить изображение
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-700">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-600">Изображение</th>
                                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-600">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carousels as $carousel)
                            <tr>
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-600">
                                    <img src="{{ asset('storage/' . $carousel->image_path) }}" alt="Carousel image" class="h-32 object-cover">
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-600">
                                    <form action="{{ route('admin.carousels.destroy', $carousel) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Удалить это изображение?')">
                                            Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>