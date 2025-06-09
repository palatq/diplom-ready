<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Главная') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($carousels->isNotEmpty())
                <!-- Карусель -->
                <div id="carousel" class="relative h-100 overflow-hidden bg-gray-100 rounded-lg group mb-12">
                    <div id="carousel-track" class="flex h-full transition-transform duration-500 ease-in-out">
                        @foreach($carousels as $carousel)
                            <div class="carousel-slide min-w-full relative">
                                <img 
                                    src="{{ asset('storage/' . $carousel->image_path) }}" 
                                    class="w-full h-full object-cover"
                                    alt="{{ $carousel->title }}"
                                >
                                @if($carousel->title || $carousel->description)
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6 text-white">
                                    @if($carousel->title)
                                        <h3 class="text-2xl font-bold">{{ $carousel->title }}</h3>
                                    @endif
                                    @if($carousel->description)
                                        <p class="mt-2">{{ $carousel->description }}</p>
                                    @endif
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <button id="carousel-prev" class="carousel-btn absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 text-white rounded-full w-10 h-10 flex items-center justify-center hover:bg-black/70 transition opacity-0 group-hover:opacity-100 z-20"><</button>
                    <button id="carousel-next" class="carousel-btn absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 text-white rounded-full w-10 h-10 flex items-center justify-center hover:bg-black/70 transition opacity-0 group-hover:opacity-100 z-20">></button>

                    <div class="absolute bottom-4 left-0 right-0 flex justify-center z-20">
                        <div id="carousel-dots" class="flex gap-1 bg-black/20 rounded-full p-1">
                            @foreach($carousels as $index => $carousel)
                                <button class="carousel-dot h-2 w-2 rounded-full bg-white/50 transition-all duration-300 overflow-hidden" data-index="{{ $index }}">
                                    <span class="block h-full bg-white rounded-full transform origin-left transition-all duration-300 scale-x-0"></span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

           <!-- Почему мы? -->
<section class="mb-16">
    <h2 class="text-3xl font-bold text-center mb-10 text-gray-800 dark:text-white" style="margin-bottom:30px">Почему выбирают нас?</h2>
    <div class="flex flex-wrap justify-center gap-4" style="margin-bottom:30px">
        <!-- Карточка 1 -->
        <div class="w-64 bg-white dark:bg-gray-900 rounded-xl shadow-lg overflow-hidden  transition-all hover:shadow-xl hover:-translate-y-1">
            <div class="p-5 text-center">
                <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Низкие цены</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">Мы предлагаем самые выгодные цены на товары благодаря прямым поставкам.</p>
            </div>
        </div>
        
        <!-- Карточка 2 -->
        <div class="w-64 bg-white dark:bg-gray-900 rounded-xl shadow-lg overflow-hidden transition-all hover:shadow-xl hover:-translate-y-1">
            <div class="p-5 text-center">
                <div class="w-14 h-14 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Быстрая доставка</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">Доставляем заказы в кратчайшие сроки по всей стране.</p>
            </div>
        </div>
        
        <!-- Карточка 3 -->
        <div class="w-64 bg-white dark:bg-gray-900 rounded-xl shadow-lg overflow-hidden transition-all hover:shadow-xl hover:-translate-y-1">
            <div class="p-5 text-center">
                <div class="w-14 h-14 bg-blue-100 dark:bg-purple-900/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Стань продавцом</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">Регистрируйся и начни продавать свои товары на нашей площадке уже сегодня!</p>
            </div>
        </div>
    </div>
</section>

<!-- Акции -->
<section class="mb-16">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Акционные предложения</h2>
        <p class="text-gray-500 dark:text-gray-400" style="margin-bottom:10px">Специальные условия для наших клиентов</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Акция 1 -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 transition-all hover:shadow-xl" style="border-radius: 10px;">
            <div class="relative h-48 overflow-hidden">
                <img src="https://sun9-55.userapi.com/impf/c629412/v629412899/4957a/qX6-ZW2dW48.jpg?size=400x200&quality=96&sign=b44201cd5febcacd4924cb4f4bbf8552&type=album" 
                     alt="Акция 1" 
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="absolute top-4 right-4 bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-full shadow-md">
                    -30%
                </div>
            </div>
            <div class="p-5" >
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Скидка 30% на всё!</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">Успей купить по акции товары для дачи и сада до конца месяца.</p>
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                    Подробнее
                </button>
            </div>
        </div>
        
        <!-- Акция 2 -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 transition-all hover:shadow-xl" style="border-radius: 10px;" >
            <div class="relative h-48 overflow-hidden">
                <img src="https://fb.ru/misc/i/thumb/a/2/2/4/9/5/8/1/2249581.jpg" 
                     alt="Акция 2" 
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="absolute top-4 right-4 bg-yellow-500 text-white text-sm font-bold px-3 py-1 rounded-full shadow-md">
                    1+1
                </div>
            </div>
            <div class="p-5">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Подарочный набор за полцены</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">Купи один товар — получи второй бесплатно. Акция действует до конца этой недели</p>
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                    Подробнее
                </button>
            </div>
        </div>
        
        <!-- Акция 3 -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 transition-all hover:shadow-xl" style="border-radius: 10px;">
            <div class="relative h-48 overflow-hidden">
                <img src="https://static.vecteezy.com/system/resources/thumbnails/012/774/484/small/winter-sale-banner-template-snowman-with-offer-sign-board-in-snow-background-vector.jpg" 
                     alt="Акция 3" 
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="absolute top-4 right-4 bg-blue-500 text-white text-sm font-bold px-3 py-1 rounded-full shadow-md">
                    NEW
                </div>
            </div>
            <div class="p-5">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Распродажа зимней коллекции</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">Только до весны! Выгодные предложения на зимние товары.</p>
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                    Подробнее
                </button>
            </div>
        </div>
    </div>
</section>

            <!-- Погода -->
           <section class="mb-12">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4 text-center">Цитата дня</h2>
    <div class="bg-gradient-to-r from-blue-50 to-indigo-100 dark:from-gray-700 dark:to-gray-800 shadow-md rounded-lg p-6 max-w-2xl mx-auto text-center">
        <p id="daily-quote" class="text-lg italic text-gray-700 dark:text-gray-300">
                            </p>
                        </div>
                    </section>

            <!-- Добро пожаловать -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Добро пожаловать в наш магазин!</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Используйте каталог для просмотра товаров</p>
            </div>
        </div>
    </div>

    <!-- Скрипт для погоды -->
    <script>
       // Список цитат (можно добавить свои)
                        const quotes = [
                            "Успех — это движение от неудачи к неудаче без потери энтузиазма.", // Черчилль
                            "Если ты хочешь, чтобы что-то было сделано, попроси того, кто всегда занят.", // Изабелла Берд
                            "Лучший способ предсказать будущее — создать его.", // Авраам Линкольн
                            "Медленный, но постоянный выигрывает гонку.", // Эзоп
                            "Даже если ты на правильном пути, тебя всё равно снесут, если ты просто сидишь на месте.", // Уилл Роджерс
                        ];

                        document.addEventListener("DOMContentLoaded", () => {
                            const quoteElement = document.getElementById("daily-quote");
                            const randomIndex = Math.floor(Math.random() * quotes.length);
                            quoteElement.textContent = `"${quotes[randomIndex]}"`;
                        });

        document.addEventListener('DOMContentLoaded', () => {
            const carousel = document.getElementById('carousel');
            const track = document.getElementById('carousel-track');
            const prevBtn = document.getElementById('carousel-prev');
            const nextBtn = document.getElementById('carousel-next');
            const dots = document.querySelectorAll('.carousel-dot');
            const dotSpans = document.querySelectorAll('.carousel-dot span');
            
            let currentIndex = 0;
            let intervalId;
            const slideCount = document.querySelectorAll('.carousel-slide').length;

            // Автопрокрутка
            function startAutoSlide() {
                intervalId = setInterval(nextSlide, 5000);
            }

            // Переключение слайдов
            function goToSlide(index) {
                currentIndex = (index + slideCount) % slideCount;
                track.style.transform = `translateX(-${currentIndex * 100}%)`;
                
                // Обновляем индикаторы
                dotSpans.forEach((span, i) => {
                    span.classList.toggle('scale-x-0', i !== currentIndex);
                    span.classList.toggle('scale-x-100', i === currentIndex);
                });
            }

            function nextSlide() {
                goToSlide(currentIndex + 1);
            }

            function prevSlide() {
                goToSlide(currentIndex - 1);
            }

            // Клик по индикаторам
            dots.forEach(dot => {
                dot.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const index = parseInt(dot.dataset.index);
                    if (index !== currentIndex) {
                        clearInterval(intervalId);
                        goToSlide(index);
                        startAutoSlide();
                    }
                });
            });

            // Клик по левой/правой части слайда
            carousel.addEventListener('click', (e) => {
                const rect = carousel.getBoundingClientRect();
                const clickX = e.clientX - rect.left;
                const halfWidth = rect.width / 2;
                
                clearInterval(intervalId);
                if (clickX < halfWidth) prevSlide();
                else nextSlide();
                startAutoSlide();
            });

            // Кнопки
            prevBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                clearInterval(intervalId);
                prevSlide();
                startAutoSlide();
            });

            nextBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                clearInterval(intervalId);
                nextSlide();
                startAutoSlide();
            });

            // Пауза при наведении
            carousel.addEventListener('mouseenter', () => clearInterval(intervalId));
            carousel.addEventListener('mouseleave', startAutoSlide);

            // Запуск
            if (slideCount > 0) {
                dotSpans[currentIndex].classList.add('scale-x-100');
                startAutoSlide();
            }
        });
    </script>
</x-app-layout>