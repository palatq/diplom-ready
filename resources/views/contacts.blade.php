<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Контакты') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Свяжитесь с нами</h1>
                        
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Адрес</h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    Моторная ул., 13А<br>
                                    г. Набережные Челны, 420111<br>
                                    Республика Татарстан
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Телефон</h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <a href="tel:+78432345678" class="hover:text-indigo-600">+7 (987) 654-32-10</a>
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Email</h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <a href="mailto:info@kazan.example.com" class="hover:text-indigo-600">cheepandquality@example.com</a>
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Часы работы</h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    Пн-Пт: 9:00 - 18:00<br>
                                    Сб: 10:00 - 15:00<br>
                                    Вс: выходной
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Напишите нам</h2>
                        <form action="{{ route('feedback.store') }}" method="POST" class="space-y-4">
    @csrf
    
    @if($errors->any())
        <div class="p-4 mb-4 text-red-700 bg-red-100 rounded-lg">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @if(session('success'))
        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ваше имя</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required
               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
    </div>
    
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required
               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
    </div>
    
    <div>
        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Сообщение</label>
        <textarea id="message" name="message" rows="4" required
                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">{{ old('message') }}</textarea>
    </div>
    
    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Отправить сообщение
    </button>
</form>
                    </div>
                </div>
                
                <!-- Яндекс.Карта -->
                <div class="mt-12">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Мы на карте</h2>
                    <div class="h-96 w-full rounded-lg overflow-hidden shadow-lg">
                        <!-- Контейнер для карты -->
                        <div id="yandex-map-contacts" style="width: 100%; height: 100%;"></div>
                        
                        <!-- Подключаем API Яндекс.Карт -->
                        <script src="https://api-maps.yandex.ru/2.1/?apikey=ваш_api_ключ&lang=ru_RU" type="text/javascript"></script>
                        
                        <!-- Инициализация карты -->
                        <script type="text/javascript">
                            document.addEventListener('DOMContentLoaded', function() {
                                ymaps.ready(init);
                                
                                function init() {
                                    // Создаем карту без лишних элементов
                                    var myMap = new ymaps.Map("yandex-map-contacts", {
                                        center: [55.738739, 52.481227], // Центр Казани (Кремль)
                                        zoom: 15,
                                        controls: [] // Убираем все кнопки
                                    });
                                    
                                    // Добавляем метку с кастомной иконкой
                                    var myPlacemark = new ymaps.Placemark([55.738739, 52.481227], {
                                        hintContent: 'Наш офис в Набережных Челнах',
                                        balloonContent: `
                                            <div style="padding: 10px;">
                                                <h3 style="margin: 0 0 10px 0;">Главный офис</h3>
                                                <p><b>Адрес:</b>Моторная ул., 13А</p>
                                                <p><b>Телефон:</b> +7 (843) 234-56-78</p>
                                            </div>
                                        `
                                    }, {
                                        preset: 'islands#redIcon' // Стиль метки
                                    });
                                    
                                    myMap.geoObjects.add(myPlacemark);
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>