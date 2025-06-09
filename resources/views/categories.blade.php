<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Управление категориями') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Форма добавления -->
                    <form method="POST" action="{{ route('admin.categories.store') }}">
    @csrf
    <div class="flex gap-4">
        <x-text-input class="block w-full" name="name" required placeholder="Название категории" />
        <x-primary-button>Добавить</x-primary-button>
    </div>
</form>

                    <!-- Таблица категорий -->
                    <div class="mt-8 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Название</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y text-white">
                                @foreach($categories as $category)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $category->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $category->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>