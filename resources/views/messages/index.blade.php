<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Мои диалоги
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="flex h-[70vh]">
                    <!-- Список диалогов -->
                    <div class="w-full border-r dark:border-gray-700 overflow-y-auto">
                        @foreach($conversations as $key => $conversation)
                            @php
                                $firstMessage = $conversation->first();
                                $otherUser = auth()->id() == $firstMessage->sender_id 
                                    ? $firstMessage->receiver 
                                    : $firstMessage->sender;
                            @endphp
                            <a href="{{ route('messages.show', ['product' => $firstMessage->product_id, 'user' => $otherUser->id]) }}"
                               class="block p-4 hover:bg-gray-100 dark:hover:bg-gray-700 border-b dark:border-gray-700">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                        {{ substr($otherUser->name, 0, 1) }}
                                    </div>
                                    <div class="ml-3 overflow-hidden">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            {{ $otherUser->name }} - {{ $firstMessage->product->name }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                            {{ $conversation->last()->message }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>