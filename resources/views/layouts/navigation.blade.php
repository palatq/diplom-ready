<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="font-sans antialiased">
<nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700" x-data="{ profileOpen: false }">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
                
                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-8">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Главная') }}
                    </x-nav-link>
                    <x-nav-link :href="route('catalog')" :active="request()->routeIs('catalog')">
                        {{ __('Каталог') }}
                    </x-nav-link>
                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                        {{ __('О нас') }}
                    </x-nav-link>

                    <x-nav-link :href="route('contacts')" :active="request()->routeIs('contacts')">
                        {{ __('Контакты') }}
                    </x-nav-link>
                    
                    @auth
                        @if(auth()->user()->login === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Админ-панель') }}
                        </x-nav-link>

                         <x-nav-link :href="route('admin.feedback')" :active="request()->routeIs('admin.feedback')" class="ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Обратная связь
                        </x-nav-link>
                        @endif

                        @if(auth()->user()->seller == 1)
                        <x-nav-link :href="route('products.create')" :active="request()->routeIs('products.create')">
                            {{ __('Добавить товар') }}
                        </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Side Navigation -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                <!-- Cart Link -->
                <div class="relative">
                    <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>Корзина</span>
                            @auth
                                @if($cartCount = Auth::user()->cartItems()->sum('quantity'))
                                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            @endauth
                        </div>
                    </x-nav-link>
                </div>

                <!-- Settings Dropdown -->
                <div class="ml-4 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button @click="profileOpen = !profileOpen" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name ?? 'Гость' }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content" x-show="profileOpen" @click.outside="profileOpen = false" x-transition>
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Профиль') }}
                            </x-dropdown-link>

                             <!-- Кнопка сообщений -->
                    <x-dropdown-link :href="route('messages.index')" >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                            Сообщения
                    </x-dropdown-link>
                            @auth
                                @if(auth()->user()->seller != 1)
                                <x-dropdown-link :href="route('become.seller')">
                                    {{ __('Стать продавцом') }}
                                </x-dropdown-link>
                                @endif
                            @endauth
                            @if(auth()->user()->seller == 1)
                        <x-dropdown-link :href="route('seller.office')" >
                            {{ __('Кабинет продавца') }}
                        </x-dropdown-link>
                        @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Выйти') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button id="mobileMenuBtn" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path id="menuIconOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path id="menuIconClose" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div id="mobileMenu" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Главная') }}
            </x-responsive-nav-link>
            
            @auth
                @if(auth()->user()->login === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Админ-панель') }}
                </x-responsive-nav-link>
                @endif
                
                @if(auth()->user()->seller == 1)
                <x-responsive-nav-link :href="route('products.create')" :active="request()->routeIs('products.create')">
                    {{ __('Добавить товар') }}
                </x-responsive-nav-link>
                @endif

                <!-- Mobile Cart Link -->
                <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>Корзина</span>
                        @if($cartCount = Auth::user()->cartItems()->sum('quantity'))
                            <span class="ml-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </div>
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name ?? 'Гость' }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email ?? '' }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Профиль') }}
                </x-responsive-nav-link>

                @auth
                    @if(auth()->user()->seller != 1)
                    <x-responsive-nav-link :href="route('become.seller')">
                        {{ __('Стать продавцом') }}
                    </x-responsive-nav-link>
                    @endif
                @endauth

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Выйти') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    document.getElementById('mobileMenuBtn').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobileMenu');
        const menuIconOpen = document.getElementById('menuIconOpen');
        const menuIconClose = document.getElementById('menuIconClose');
        
        mobileMenu.classList.toggle('hidden');
        menuIconOpen.classList.toggle('hidden');
        menuIconClose.classList.toggle('hidden');
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        
        if (!mobileMenu.contains(event.target) && event.target !== mobileMenuBtn && !mobileMenuBtn.contains(event.target)) {
            mobileMenu.classList.add('hidden');
            document.getElementById('menuIconOpen').classList.remove('hidden');
            document.getElementById('menuIconClose').classList.add('hidden');
        }
    });
});
</script>
</body>
</html>