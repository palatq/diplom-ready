@php
$colors = [
    'blue' => 'from-blue-500 to-purple-600',
    'green' => 'from-green-500 to-teal-400',
    'yellow' => 'from-yellow-500 to-orange-500',
    'pink' => 'from-pink-500 to-red-500'
];
@endphp

<div class="bg-gradient-to-br {{ $colors[$color] ?? 'from-gray-500 to-gray-700' }} rounded-lg shadow-lg p-6 text-white transform transition duration-300 hover:scale-105">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm opacity-80">{{ $title }}</p>
            <h3 class="text-2xl font-bold">{{ $value }}</h3>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 opacity-80" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            @switch($icon)
                @case('users')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    @break
                @case('shopping-bag')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    @break
                @case('dollar-sign')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    @break
                @case('check-circle')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    @break
            @endswitch
        </svg>
    </div>
</div>