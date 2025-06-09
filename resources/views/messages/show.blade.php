<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Диалог о товаре: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="flex h-[70vh]">
                    <!-- Список диалогов -->
                    <div class="w-1/3 border-r dark:border-gray-700 overflow-y-auto">
                        @foreach($conversations as $key => $conversation)
                            @php
                                $firstMessage = $conversation->first();
                                $otherUser = auth()->id() == $firstMessage->sender_id 
                                    ? $firstMessage->receiver 
                                    : $firstMessage->sender;
                            @endphp
                            <a href="{{ route('messages.show', ['product' => $firstMessage->product_id, 'user' => $otherUser->id]) }}"
                               class="block p-4 hover:bg-gray-100 dark:hover:bg-gray-700 border-b dark:border-gray-700 {{ $product->id == $firstMessage->product_id && $userId == $otherUser->id ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
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

                    <!-- Окно чата -->
                    <div class="w-full flex flex-col">
                        <!-- Заголовок чата -->
                        <div class="p-4 border-b dark:border-gray-700 flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                {{ substr($currentChatUser->name, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $currentChatUser->name }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $product->name }}
                                </p>
                            </div>
                        </div>

                        <!-- Сообщения -->
                        <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4">
                            @foreach($messages as $message)
                                <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                                    <div class="{{ $message->sender_id == auth()->id() ? 'bg-indigo-100 dark:bg-indigo-900' : 'bg-gray-100 dark:bg-gray-700' }} rounded-lg p-3 max-w-xs lg:max-w-md">
                                        <p style="color: white;">{{ $message->message }}</p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $message->created_at->format('d.m.Y H:i') }}
                                            @if($message->sender_id == auth()->id())
                                                @if($message->is_read)
                                                    <span class="text-green-500">✓✓</span>
                                                @else
                                                    <span>✓</span>
                                                @endif
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Форма отправки -->
                        <form action="{{ route('product.messages.store', $product) }}" method="POST" class="p-4 border-t dark:border-gray-700">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $currentChatUser->id }}">
                            <div class="flex">
                                <input type="text" name="message" placeholder="Напишите сообщение..." class="flex-1 rounded-l-lg border-r-0 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-r-lg">
                                    Отправить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Прокрутка вниз при загрузке
        window.addEventListener('load', () => {
            const chat = document.getElementById('chat-messages');
            if (chat) chat.scrollTop = chat.scrollHeight;
        });
    </script>
</x-app-layout>