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
                    @if($hasPendingApplication)
                        <div class="mb-4 p-4 bg-blue-100 text-blue-800 rounded-lg">
                            Ваша заявка на рассмотрении. Мы уведомим вас о результате.
                        </div>
                    @else
                        <form method="POST" action="{{ route('seller.store') }}">
                            @csrf
                            <div class="mb-4">
                                <x-input-label for="phone" value="Телефон для связи"/>
                                <x-text-input id="phone" class="block w-full mt-1" name="phone" required/>
                            </div>
                            
                            <div class="mb-4">
                                <x-input-label for="message" value="Дополнительная информация"/>
                                <textarea id="message" name="message" rows="3" 
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"></textarea>
                            </div>
                            
                            <div class="mb-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="agree" required class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Я согласен с условиями</span>
                                </label>
                            </div>
                            
                            <x-primary-button class="w-full justify-center">
                                Отправить заявку
                            </x-primary-button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>