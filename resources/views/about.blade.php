<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('О нашей компании') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="space-y-8">
                    <div class="text-center">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">О нашей компании</h1>
                        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                            ТехноХаб - современная компания, специализирующаяся на продаже качественных товаров. 
                            Наша миссия - предоставлять клиентам лучший сервис и продукцию.
                        </p>
                    </div>

                    <div class="grid md:grid-cols-2 gap-8 items-center">
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Наша история</h2>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Компания была основана в 2020 году с целью предоставления качественных товаров по доступным ценам.
                            </p>
                            <p class="text-gray-600 dark:text-gray-300">
                                За годы работы мы заслужили доверие тысяч клиентов и продолжаем развиваться.
                            </p>
                        </div>
                        <div class="h-64 bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c" 
                                 alt="Наша команда"
                                 class="w-full h-full object-cover">
                        </div>
                    </div>

                    <!-- Яндекс.Карта -->
                    <div class="mt-8">
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Мы находимся здесь</h2>
                        <div class="h-96 w-full rounded-lg overflow-hidden shadow-lg">
                            <!-- Контейнер для карты -->
                            <div id="yandex-map" style="width: 100%; height: 100%;"></div>
                            
                            <!-- Подключаем API Яндекс.Карт -->
                            <script src="https://api-maps.yandex.ru/2.1/?apikey=ваш_api_ключ&lang=ru_RU" type="text/javascript"></script>
                            
                            <!-- Инициализация карты -->
                            <script type="text/javascript">
    ymaps.ready(init);

    function init() {
        // Создаем карту без стандартных элементов управления
        var myMap = new ymaps.Map("yandex-map", {
            center: [55.738739, 52.481227], // Координаты вашего офиса
            zoom: 14,
            controls: [] // Пустой массив — убирает ВСЕ кнопки
        });

        // Добавляем метку
        var myPlacemark = new ymaps.Placemark([55.738739, 52.481227], {
            hintContent: 'ТехноХаб',
            balloonContent: 'Приходите к нам в гости!'
        });

        myMap.geoObjects.add(myPlacemark);
    }
</script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>