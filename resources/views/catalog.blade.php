<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Каталог товаров') }}
        </h2>
        
    </x-slot>
<!-- Toast уведомление -->
<div id="toast" class="hidden fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50"></div>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Каталог товаров -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Заголовок и фильтры -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Все товары
                    </h3>
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <!-- Выпадающий список фильтра по категориям -->
<select id="categoryFilter" class="bg-gray-800 text-white rounded-md px-3 py-2 text-sm border border-gray-600 focus:border-indigo-500 focus:ring-indigo-500">
    <option value="{{ route('catalog') }}" {{ !$selectedCategory ? 'selected' : '' }}>
        Все категории
    </option>
    @foreach($categories as $category)
        <option value="{{ route('catalog') }}?category={{ $category->id }}" 
            {{ $selectedCategory && $selectedCategory->id == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
        </option>
    @endforeach
</select>
                        <select id="sortFilter" class="bg-gray-800 text-white rounded-md px-3 py-2 text-sm border border-gray-600 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="default">Сортировка</option>
                            <option value="price_asc">Цена: по возрастанию</option>
                            <option value="price_desc">Цена: по убыванию</option>
                            <option value="rating_desc">По рейтингу</option>
                            <option value="reviews_desc">По количеству отзывов</option>
                            <option value="newest">Сначала новые</option>
                        </select>
                    </div>
                </div>

                <!-- Список товаров -->
                <div class="products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px;">
                    @if($products->isEmpty())
                        <p class="text-gray-400 text-center py-10">Товары не найдены</p>
                    @else
                        @foreach($products as $product)
                            <div class="product-card-container group" data-product-id="{{ $product->id }}" style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.05); cursor: pointer; position: relative; display: flex; flex-direction: column; height: 100%; transition: all 0.3s ease;">
                                <!-- Бейдж скидки/новинки -->
                                @if($product->discount > 0)
                                    <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded z-10">
                                        -{{ $product->discount }}%
                                    </div>
                                @elseif($product->created_at->diffInDays() < 30)
                                    <div class="absolute top-2 left-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded z-10">
                                        NEW
                                    </div>
                                @endif
                                <!-- Изображение товара -->
                                <div style="padding: 0px; height: 180px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; flex-shrink: 0; position: relative; overflow: hidden;">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;" class="group-hover:scale-105">
                                </div>
                                <!-- Информация о товаре -->
                                <div style="padding: 16px; background: #364050; flex-grow: 1; display: flex; flex-direction: column;">
                                    <h3 style="font-size: 16px; font-weight: 500; margin-bottom: 6px; line-height: 1.3; color: #fff; flex-shrink: 0;">
                                        {{ $product->name }}
                                    </h3>
                                    <p style="font-size: 12px; color: #9ca3af; margin-bottom: 6px; flex-shrink: 0;">
                                        {{ $product->category->name ?? 'Без категории' }}
                                    </p>
                                    <!-- Блок с рейтингом -->
                                    <div style="display: flex; align-items: center; margin-bottom: 8px; flex-shrink: 0;">
                                        <div style="display: flex; margin-right: 4px;">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($product->avg_rating))
                                                    <svg style="width: 14px; height: 14px; fill: #fbbf24;" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @else
                                                    <svg style="width: 14px; height: 14px; fill: #d1d5db;" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endif
                                            @endfor
                                        </div>
                                        <span style="font-size: 12px; color: #9ca3af;">
                                            {{ number_format($product->avg_rating, 1) }} ({{ $product->reviews_count }})
                                        </span>
                                    </div>
                                    <!-- Цена и кнопка -->
                                    <div style="margin-top: auto; flex-shrink: 0;">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <div>
                                                @if($product->discount > 0)
                                                    <p style="font-size: 14px; font-weight: bold; color: rgb(199, 196, 253);">
                                                        {{ $product->formatted_discounted_price }}
                                                    </p>
                                                    <p style="font-size: 12px; color: #9ca3af; text-decoration: line-through;">
                                                        {{ $product->formatted_price }}
                                                    </p>
                                                @else
                                                    <p style="font-size: 14px; font-weight: bold; color: rgb(199, 196, 253);">
                                                        {{ $product->formatted_price }}
                                                    </p>
                                                @endif
                                            </div>
                                            <button class="buy-button no-product-redirect" data-product-id="{{ $product->id }}" style="background: #4f46e5; color: white; border: none; padding: 6px 12px; border-radius: 4px; font-size: 13px; cursor: pointer; position: relative; z-index: 2; transition: background 0.2s ease;" onmouseover="this.style.background='#4338ca'" onmouseout="this.style.background='#4f46e5'">
                                                Купить
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Пагинация -->
                @if(!$products->isEmpty())
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Здесь можно подключить JS из dashboard если нужна полная функциональность -->
     <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Обработчик кликов по карточкам (если они есть)
        document.querySelectorAll('.product-card-container').forEach(card => {
            card.addEventListener('click', function(e) {
                if (!e.target.closest('.no-product-redirect') && 
                    !e.target.closest('form[action*="destroy"]') &&
                    !e.target.closest('.quick-view-btn')) {
                    const productId = this.dataset.productId;
                    window.location.href = `/products/${productId}`;
                }
            });
        });

        // Обработчик кнопок "Купить"
       document.querySelectorAll('.no-product-redirect').forEach(button => {
    button.addEventListener('click', async function(e) {
        e.stopPropagation();
        e.preventDefault();
        const productId = this.dataset.productId;
        const buttonEl = this;

        // Анимация загрузки
        buttonEl.innerHTML = '<span class="animate-spin">↻</span>';
        buttonEl.disabled = true;

        try {
            const response = await fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();

           if (response.ok) {
    showToast(data.message);

    // Обновляем все элементы с классом .cart-count
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(el => {
        el.textContent = data.cart_count;
    });

    // Если нет таких элементов — создаём их
    if (cartCountElements.length === 0 && data.cart_count > 0) {
        const cartLink = document.querySelector('a[href="{{ route("cart.index") }}"]');
        if (cartLink) {
            let badge = cartLink.querySelector('.bg-red-500');

            if (!badge) {
                badge = document.createElement('span');
                badge.className = "ml-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center";
                badge.textContent = data.cart_count;
                cartLink.querySelector('.flex').appendChild(badge);
            } else {
                badge.textContent = data.cart_count;
            }
        }
    }

            } else {
                throw new Error(data.message || 'Ошибка при добавлении в корзину');
            }

        } catch (error) {
            console.error('Ошибка:', error);
            showToast(error.message, 'error');
        } finally {
            buttonEl.innerHTML = 'Купить';
            buttonEl.disabled = false;
        }
    });
});

        // Показывает сообщение
        function showToast(message) {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.textContent = message;
                toast.classList.remove('hidden');
                setTimeout(() => {
                    toast.classList.add('hidden');
                }, 3000);
            }
        }

        // Обновляет счетчик корзины
        function updateCartCount(count) {
            document.querySelectorAll('.cart-count').forEach(el => {
                el.textContent = count;
            });
        }
    });

document.addEventListener('DOMContentLoaded', function () {
    const categoryFilter = document.getElementById('categoryFilter');
    const sortFilter = document.getElementById('sortFilter');

    // Фильтр по категории
    if (categoryFilter) {
        categoryFilter.addEventListener('change', function () {
            window.location.href = this.value;
        });
    }

    // Сортировка
    if (sortFilter) {
        sortFilter.addEventListener('change', function () {
            const selectedValue = this.value;
            if (selectedValue !== 'default') {
                const url = new URL(window.location.href);
                url.searchParams.set('sort', selectedValue);
                window.location.href = url.toString();
            }
        });

        // Устанавливаем текущее значение из URL
        const urlParams = new URLSearchParams(window.location.search);
        const sortParam = urlParams.get('sort');
        if (sortParam) {
            sortFilter.value = sortParam;
        }
    }
});
</script>
</x-app-layout>