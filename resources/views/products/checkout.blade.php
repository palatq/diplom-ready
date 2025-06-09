<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Оформление заказа
        </h2>
    </x-slot>

    <div class="py-4 md:py-8 min-h-screen">
        <div class="mx-auto px-4 sm:px-6 lg:px-8" style="max-width: 1800px;">
            @if($cartItems->isEmpty())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg max-w-4xl mx-auto">
                    <p>Нет товаров для отображения</p>
                    <a href="{{ route('cart.index') }}" class="text-blue-500 hover:text-blue-700">Вернуться в корзину</a>
                </div>
            @else
                <div class="flex flex-col lg:flex-row gap-4 md:gap-8 w-full">
                    <!-- Левая колонка - Товары -->
                    <div class="lg:w-[75%] w-full bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                        <div class="p-4 md:p-8">
                            <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white mb-4 md:mb-8">Ваш заказ</h2>
                            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($cartItems as $item)
                                    <div class="py-4 md:py-6 flex items-start gap-4">
                                        <!-- Блок изображения -->
                                        <div class="flex-shrink-0 w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                                            @if($item->product->image_path)
                                                <img src="{{ asset('storage/' . $item->product->image_path) }}" 
                                                     alt="{{ $item->product->name }}"
                                                     class="w-full h-full object-cover"
                                                     onerror="this.style.display='none'">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                        <polyline points="21 15 16 10 5 21"></polyline>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Инфо о товаре -->
                                        <div class="flex-1 min-w-0 flex flex-col justify-between h-full">
                                            <div>
                                                <h3 class="font-medium text-lg md:text-xl text-gray-800 dark:text-gray-200 mb-1 line-clamp-2">
                                                    {{ $item->product->name }}
                                                </h3>
                                                @if($item->product->description)
                                                    <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base mb-2 line-clamp-2">
                                                        {{ Str::limit($item->product->description, 100) }}
                                                    </p>
                                                @endif
                                            </div>

                                            <!-- Цена -->
                                            <div class="flex flex-col sm:flex-row sm:justify-between gap-1 mt-2">
                                                @php
                                                    $originalPrice = $item->product->price;
                                                    $hasDiscount = $item->product->discount > 0;
                                                    $discountedPrice = $hasDiscount ? $originalPrice * (1 - $item->product->discount / 100) : $originalPrice;
                                                    $totalPerItem = $discountedPrice * $item->quantity;
                                                @endphp

                                                @if($hasDiscount)
                                                    <div class="space-y-1">
                                                        <p class="text-red-500 font-bold">
                                                            {{ number_format($discountedPrice, 2, ',', ' ') }} ₽ × {{ $item->quantity }} шт.
                                                        </p>
                                                        <p class="line-through text-gray-500 text-sm">
                                                            {{ number_format($originalPrice, 2, ',', ' ') }} ₽
                                                        </p>
                                                    </div>
                                                @else
                                                    <span class="text-gray-600 dark:text-gray-400 text-base">
                                                        {{ number_format($originalPrice, 2, ',', ' ') }} ₽ × {{ $item->quantity }} шт.
                                                    </span>
                                                @endif

                                                <!-- Общая цена по товару -->
                                                <span class="font-medium text-lg text-right ml-auto sm:ml-0" style="font-weight: bold; color: rgb(199, 196, 253)" >
                                                    {{ number_format($totalPerItem, 2, ',', ' ') }} ₽
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Правая колонка - Оформление -->
                    <div class="lg:w-[25%] w-full space-y-4 md:space-y-6">
                        <!-- Блок итого -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-4 md:p-6">
                            <h3 class="text-lg md:text-xl font-bold mb-3 md:mb-4 text-gray-200">Итого</h3>
                            <div class="flex justify-between items-center font-bold text-lg md:text-xl">
                                <span class="text-gray-200">К оплате:</span>
                                <span class="text-gray-200 text-xl md:text-2xl" style="font-weight: bold; color: rgb(199, 196, 253)">
                                    {{ number_format($total, 2, ',', ' ') }} ₽
                                </span>
                            </div>
                        </div>

                        <!-- Блок ПВЗ -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-4 md:p-6">
                            <h3 class="text-lg md:text-xl font-bold mb-3 md:mb-4 text-gray-200">Выберите пункт выдачи</h3>
                            <div class="relative w-full" style="height: 250px; min-height: 250px;">
                                <div id="pickup-map" class="absolute inset-0 rounded-lg overflow-hidden"></div>
                                <div id="map-loader" class="absolute inset-0 flex items-center justify-center bg-white dark:bg-gray-700 bg-opacity-80 rounded-lg">
                                    <div class="animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-blue-500"></div>
                                </div>
                            </div>
                            <div id="selected-point-info" class="mt-3 md:mt-4 p-3 md:p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border-2 border-blue-400">
                                <div class="font-semibold text-gray-200 md:text-lg mb-1 md:mb-2">Выбранный пункт:</div>
                                <div id="point-address" class="text-gray-700 dark:text-gray-300 text-sm md:text-base">Выберите пункт на карте</div>
                                <input type="hidden" id="pickup-point-id" name="pickup_point_id">
                            </div>
                        </div>

                        <!-- Блок оплаты -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-4 md:p-6">
                            <h3 class="text-lg md:text-xl font-bold mb-3 md:mb-4 text-gray-200">Способ оплаты</h3>
                            <div class="space-y-3 md:space-y-4">
                                <label class="flex items-center space-x-3 p-3 border-2 border-gray-200 dark:border-gray-600 rounded-lg hover:border-blue-400 transition-colors cursor-pointer">
                                    <input type="radio" name="payment_method" value="card" checked class="h-5 w-5 md:h-6 md:w-6 text-blue-500">
                                    <div>
                                        <span class="font-medium text-gray-200 md:text-lg">Картой онлайн</span>
                                        <p class="text-gray-500 text-sm md:text-base mt-1">Visa, Mastercard, Мир</p>
                                    </div>
                                </label>
                                <label class="flex items-center space-x-3 p-3 border-2 border-gray-200 dark:border-gray-600 rounded-lg hover:border-blue-400 transition-colors cursor-pointer">
                                    <input type="radio" name="payment_method" value="sbp" class="h-5 w-5 md:h-6 md:w-6 text-blue-500">
                                    <div>
                                        <span class="font-medium text-gray-200   md:text-lg">СБП</span>
                                        <p class="text-gray-500 text-sm md:text-base mt-1">Оплата через Систему Быстрых Платежей</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Кнопка оформления -->
                        <form action="{{ route('checkout.process') }}" method="POST" class="w-full">
                            @csrf
                                <input type="hidden" name="pickup_point_id" id="form-pickup-point-id" required>
                                <input type="hidden" name="payment_method" id="form-payment-method" value="card">
                                <input type="hidden" name="total" value="{{ $total }}"> <!-- Эта строка важна -->

                            <button type="submit" 
                                    class="w-full bg-green-500 hover:bg-green-600 text-white py-3 px-4 md:py-4 md:px-6 rounded-lg font-bold text-lg md:text-xl transition-colors duration-300 flex items-center justify-center">
                                <span>Подтвердить заказ</span>
                                <svg class="w-5 h-5 md:w-6 md:h-6 ml-2 md:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Карта Яндекс -->
    @if(!$cartItems->isEmpty())
        <script src="https://api-maps.yandex.ru/2.1/?apikey= {{ config('services.yandex.maps_key') }}&lang=ru_RU" type="text/javascript"></script>
        <script>
            let map;
            let selectedPointId = null;

            function initMap() {
                document.getElementById('map-loader').style.display = 'none';
                try {
                    ymaps.ready(function () {
                        map = new ymaps.Map("pickup-map", {
                            center: [55.738733, 52.481216],
                            zoom: 10,
                            controls: ['zoomControl', 'typeSelector']
                        });

                        const pickupPoints = @json($pickupPoints);
                        const objectManager = new ymaps.ObjectManager({
                            clusterize: false,
                            gridSize: 64
                        });

                        objectManager.add({
                            type: "FeatureCollection",
                            features: pickupPoints.map(point => ({
                                type: "Feature",
                                id: point.id,
                                geometry: {
                                    type: "Point",
                                    coordinates: point.coords
                                },
                                properties: {
                                    balloonContent: `
                                        <div class="p-3">
                                            <h4 class="font-bold text-lg">${point.name}</h4>
                                            <p class="my-2 text-base">${point.address}</p>
                                            <p class="text-gray-600 text-sm">Часы работы: ${point.work_hours}</p>
                                        </div>
                                    `,
                                    hintContent: point.name
                                },
                                options: {
                                    preset: 'islands#blueShoppingIcon',
                                    iconColor: '#3b82f6'
                                }
                            }))
                        });

                        map.geoObjects.add(objectManager);

                        objectManager.objects.events.add('click', function(e) {
                            const objectId = e.get('objectId');
                            const point = pickupPoints.find(p => p.id == objectId);
                            if (point) {
                                selectedPointId = point.id;
                                document.getElementById('point-address').textContent = `${point.name}, ${point.address}`;
                                document.getElementById('pickup-point-id').value = point.id;
                                document.getElementById('form-pickup-point-id').value = point.id;
                                document.getElementById('selected-point-info').classList.add('border-blue-500');
                            }
                        });

                        // Автовыбор первого пункта
                        if (pickupPoints.length > 0) {
                            selectedPointId = pickupPoints[0].id;
                            document.getElementById('point-address').textContent = `${pickupPoints[0].name}, ${pickupPoints[0].address}`;
                            document.getElementById('pickup-point-id').value = pickupPoints[0].id;
                            document.getElementById('form-pickup-point-id').value = pickupPoints[0].id;
                            document.getElementById('selected-point-info').classList.add('border-blue-500');
                            map.setCenter(pickupPoints[0].coords, 15);
                            objectManager.objects.balloon.open(pickupPoints[0].id);
                        }

                        // Обработчики радиокнопок способов оплаты
                        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
                            radio.addEventListener('change', function () {
                                document.getElementById('form-payment-method').value = this.value;
                            });
                        });

                        // Проверка перед отправкой формы
                        document.querySelector('form').addEventListener('submit', function(e) {
                            if (!selectedPointId) {
                                e.preventDefault();
                                alert('Пожалуйста, выберите пункт выдачи на карте');
                            }
                        });

                        // Адаптация карты под размеры окна
                        const resizeObserver = new ResizeObserver(() => {
                            if (map) map.container.fitToViewport();
                        });
                        resizeObserver.observe(document.getElementById('pickup-map'));
                    });
                } catch (error) {
                    console.error('Ошибка инициализации карты:', error);
                    document.getElementById('map-loader').innerHTML = `
                        <div class="text-center p-3 text-red-500 text-base">
                            Ошибка загрузки карты. Пожалуйста, обновите страницу.
                        </div>
                    `;
                }
            }

            window.addEventListener('DOMContentLoaded', () => setTimeout(loadYandexMap, 50));
            window.addEventListener('resize', () => {
                if (typeof ymaps !== 'undefined' && map) {
                    map.container.fitToViewport();
                }
            });

            function loadYandexMap() {
                if (typeof ymaps === 'undefined') {
                    setTimeout(loadYandexMap, 100);
                } else {
                    ymaps.ready(initMap);
                }
            }
        </script>
    @endif
</x-app-layout>