<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Стать продавцом') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('seller.store') }}">
                        @csrf
                        <div class="flex items-center mb-6">
                            <input id="agree" name="agree" type="checkbox" required
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm">
                            <label for="agree" class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                                Я согласен с условиями платформы
                            </label>
                        </div>
                        <x-primary-button class="w-full justify-center">
                            {{ __('Подтвердить') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>