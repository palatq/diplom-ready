<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Toast уведомление -->
            <div id="toast" class="hidden fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50"></div>

            <!-- Основная информация о товаре -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 grid md:grid-cols-2 gap-8">
                    <!-- Изображение товара -->
                    <div class="flex justify-center bg-gray-100 dark:bg-gray-800 rounded-lg p-4">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-96 object-contain">
                    </div>
                    
                    <!-- Информация о товаре -->
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
                            {{ $product->name }}
                        </h1>
                        
                        <!-- Рейтинг -->
                        <div class="flex items-center mb-4">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($product->avg_rating))
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @elseif($i - 0.5 <= $product->avg_rating)
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <defs>
                                                <linearGradient id="half-star" x1="0" x2="100%" y1="0" y2="0">
                                                    <stop offset="50%" stop-color="currentColor"/>
                                                    <stop offset="50%" stop-color="#d1d5db"/>
                                                </linearGradient>
                                            </defs>
                                            <path fill="url(#half-star)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endif
                                @endfor
                                <span class="ml-2 text-gray-600 dark:text-gray-300 text-sm">
                                    {{ number_format($product->avg_rating, 1) }} ({{ $product->reviews_count }} отзывов)
                                </span>
                            </div>
                        </div>
                        
                        <!-- Цена и категория -->
                        <div class="mb-6">
                            <span class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                                {{ $product->formatted_price }}
                            </span>
                            <span class="text-sm text-gray-500 ml-2">
                                {{ $product->category->name ?? 'Без категории' }}
                            </span>
                        </div>
                        
                        <!-- Описание -->
                        <div class="prose dark:prose-invert max-w-none mb-8 text-white">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                        
                       <!-- Исправленный блок с кнопками (замените текущий блок) -->
<div class="flex flex-col space-y-4 mt-8">
    <!-- Кнопка добавления в корзину -->
    @auth
        <form id="add-to-cart-form" action="{{ route('cart.add', $product) }}" method="POST">
            @csrf
            <div class="flex items-center space-x-4">
                <div class="flex items-center border rounded-lg overflow-hidden">
                    <button type="button" class="px-3 py-2 bg-gray-200 hover:bg-gray-300" onclick="changeQuantity(-1)">-</button>
                    <input type="number" name="quantity" value="1" min="1" max="10" 
                           class="w-12 text-center border-0 focus:ring-0">
                    <button type="button" class="px-3 py-2 bg-gray-200 hover:bg-gray-300" onclick="changeQuantity(1)">+</button>
                </div>
                <button type="submit" id="add-to-cart-btn" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-6 rounded-lg font-medium transition-colors">
                    Добавить в корзину
                </button>
            </div>
        </form>
    @else
        <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-6 rounded-lg font-medium transition-colors inline-block text-center">
            Войдите, чтобы купить
        </a>
    @endauth
    
    <!-- Кнопка "Задать вопрос продавцу" -->
    @auth
        <button onclick="openQuestionModal()" 
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-lg font-medium transition-colors text-sm">
            Задать вопрос продавцу
        </button>
    @else
        <a href="{{ route('login') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-lg font-medium transition-colors inline-block text-center text-sm">
            Войдите, чтобы задать вопрос
        </a>
    @endauth
</div>
                    </div>
                </div>
            </div>
            
            <!-- Карусель похожих товаров -->
            @if($similarProducts->isNotEmpty())
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8 p-6">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Похожие товары</h3>
                <div class="relative">
                    <div class="similar-products-carousel flex space-x-4 overflow-x-auto pb-4 scrollbar-hide">
                        @foreach($similarProducts as $similar)
                            <div class="flex-none w-48 bg-white dark:bg-gray-700 rounded-lg shadow-sm overflow-hidden border border-gray-100 dark:border-gray-600">
                                <a href="{{ route('products.show', $similar) }}" class="block h-full flex flex-col">
                                    <!-- Контейнер для изображения -->
                                    <div class="h-36 w-full flex items-center justify-center bg-gray-50 dark:bg-gray-600 p-2">
                                        <img src="{{ $similar->image_url }}" alt="{{ $similar->name }}" 
                                             class="max-h-full max-w-full object-contain">
                                    </div>
                                    <!-- Контент карточки -->
                                    <div class="p-3 flex-1 flex flex-col">
                                        <h4 class="font-medium text-gray-800 dark:text-white text-sm line-clamp-2 mb-1">{{ $similar->name }}</h4>
                                        
                                        <!-- Блок с рейтингом -->
                                        <div class="flex items-center mb-1">
                                            <div class="flex items-center mr-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= floor($similar->avg_rating))
                                                        <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                    @else
                                                        <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="text-xs text-gray-500">{{ number_format($similar->avg_rating, 1) }}</span>
                                        </div>
                                        
                                        <!-- Цена на отдельной строке -->
                                        <p class="text-indigo-600 dark:text-indigo-400 font-semibold text-sm mt-auto">{{ $similar->formatted_price }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Отзывы -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Отзывы</h3>
                        @auth
                            <button id="show-review-form" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg text-sm">
                                Написать отзыв
                            </button>
                        @endauth
                    </div>
                    
                    <!-- Форма добавления отзыва (скрыта по умолчанию) -->
                    @auth
                        <div id="review-form" class="hidden mb-8">
                            <form action="{{ route('reviews.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <div class="mb-4">
                                    <label class="block text-gray-700 dark:text-gray-300 mb-2">Ваша оценка</label>
                                    <div class="rating-stars flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden" {{ $i == 5 ? 'checked' : '' }}>
                                            <label for="star{{ $i }}" class="text-2xl cursor-pointer">
                                                <svg class="w-8 h-8 text-gray-300 star-icon" data-rating="{{ $i }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                </svg>
                                            </label>
                                        @endfor
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="comment" class="block text-gray-700 dark:text-gray-300 mb-2">Ваш отзыв</label>
                                    <textarea name="comment" id="comment" rows="4" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                                </div>
                                
                                <div class="flex justify-end">
                                    <button type="button" id="cancel-review" class="mr-2 px-4 py-2 text-gray-600 dark:text-gray-300 rounded-lg border border-gray-300 dark:border-gray-600">
                                        Отмена
                                    </button>
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg">
                                        Отправить отзыв
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endauth
                    
                    <!-- Список отзывов -->
                    @if($product->reviews->isNotEmpty())
                        <div class="space-y-6">
                            @foreach($product->reviews as $review)
                                <div class="border-b border-gray-200 dark:border-gray-700 pb-6 last:border-0 last:pb-0">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-medium text-gray-800 dark:text-white">{{ $review->user->name }}</h4>
                                            <div class="flex items-center mt-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                    @else
                                                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                    @endif
                                                @endfor
                                                <span class="ml-2 text-sm text-gray-500">{{ $review->created_at->format('d.m.Y') }}</span>
                                            </div>
                                        </div>
                                        @if(Auth::check() && (Auth::user()->isAdmin() || Auth::id() === $review->user_id))
                                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="inline">
                                        @csrf
                                            @method('DELETE')
                                                <button type="submit" 
                                                    class="text-red-500 hover:text-red-700 text-sm"
                                                    onclick="return confirm('Вы уверены, что хотите удалить этот отзыв?')">
                                                    Удалить
                                                </button>
                                        </form>
                                        @endif
                                    </div>
                                    <p class="mt-3 text-gray-600 dark:text-gray-300">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">Пока нет отзывов. Будьте первым!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно для вопроса -->
    <div id="question-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md">
            <div class="p-4 border-b dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-semibold">Задать вопрос о товаре</h3>
                <button onclick="closeQuestionModal()" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
            
            <form id="question-form" action="{{ route('product.messages.store', $product) }}" method="POST" class="p-4">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $product->user_id }}">
                
                <div class="mb-4">
                    <label for="question-text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Ваш вопрос
                    </label>
                    <textarea id="question-text" name="message" rows="4" 
                              class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500"
                              required></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeQuestionModal()"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                        Отмена
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
                        Отправить вопрос
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Функции для модального окна вопроса
        function openQuestionModal() {
            document.getElementById('question-modal').classList.remove('hidden');
        }
        
        function closeQuestionModal() {
            document.getElementById('question-modal').classList.add('hidden');
        }

        // Обработка отправки формы вопроса
        document.getElementById('question-form')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                        'Accept': 'application/json'
                    }
                });
                
                if (response.ok) {
                    closeQuestionModal();
                    showToast('Ваш вопрос успешно отправлен!');
                    form.reset();
                } else {
                    const error = await response.json();
                    throw new Error(error.message || 'Ошибка при отправке вопроса');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast(error.message, 'error');
            }
        });

        // Остальные функции (корзина, отзывы и т.д.)
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = `hidden fixed top-5 right-5 text-white px-4 py-2 rounded-lg shadow-lg z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            toast.classList.remove('hidden');
            
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }

        function changeQuantity(change) {
            const input = document.querySelector('input[name="quantity"]');
            let value = parseInt(input.value) + change;
            if (value < 1) value = 1;
            if (value > 10) value = 10;
            input.value = value;
        }

        document.getElementById('add-to-cart-form')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            const button = document.getElementById('add-to-cart-btn');
            const originalText = button.innerHTML;
            
            button.innerHTML = '<span class="animate-spin">↻</span>';
            button.disabled = true;
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    showToast(data.message);
                    const cartCountElements = document.querySelectorAll('.cart-count');
                    cartCountElements.forEach(el => {
                        el.textContent = data.cart_count;
                    });
                } else {
                    throw new Error(data.message || 'Ошибка при добавлении в корзину');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast(error.message, 'error');
            } finally {
                button.innerHTML = originalText;
                button.disabled = false;
            }
        });

        // Управление формой отзыва
        document.getElementById('show-review-form')?.addEventListener('click', function() {
            document.getElementById('review-form').classList.remove('hidden');
            this.classList.add('hidden');
        });

        document.getElementById('cancel-review')?.addEventListener('click', function() {
            document.getElementById('review-form').classList.add('hidden');
            document.getElementById('show-review-form').classList.remove('hidden');
        });

        // Рейтинг в форме отзыва
        const starIcons = document.querySelectorAll('.star-icon');
        starIcons.forEach(icon => {
            icon.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                document.querySelector(`input[name="rating"][value="${rating}"]`).checked = true;
                
                starIcons.forEach((star, index) => {
                    if (index < rating) {
                        star.classList.add('text-yellow-400');
                        star.classList.remove('text-gray-300');
                    } else {
                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-gray-300');
                    }
                });
            });
        });

        // Инициализация звезд рейтинга
        const initialRating = document.querySelector('input[name="rating"]:checked')?.value || 5;
        starIcons.forEach((star, index) => {
            if (index < initialRating) {
                star.classList.add('text-yellow-400');
                star.classList.remove('text-gray-300');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });

        // Плавная прокрутка карусели похожих товаров
        const carousel = document.querySelector('.similar-products-carousel');
        if (carousel) {
            let isDown = false;
            let startX;
            let scrollLeft;

            carousel.addEventListener('mousedown', (e) => {
                isDown = true;
                startX = e.pageX - carousel.offsetLeft;
                scrollLeft = carousel.scrollLeft;
            });

            carousel.addEventListener('mouseleave', () => {
                isDown = false;
            });

            carousel.addEventListener('mouseup', () => {
                isDown = false;
            });

            carousel.addEventListener('mousemove', (e) => {
                if(!isDown) return;
                e.preventDefault();
                const x = e.pageX - carousel.offsetLeft;
                const walk = (x - startX) * 2;
                carousel.scrollLeft = scrollLeft - walk;
            });
        }
    </script>
</x-app-layout>