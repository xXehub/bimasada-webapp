@props([
    'variant' => 'primary', // primary, secondary, outline, ghost, danger, success, warning
    'size' => 'md', // sm, md, lg
    'type' => 'button',
    'href' => null,
    'loading' => false,
    'disabled' => false,
    'fullWidth' => false,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-dark-bg disabled:opacity-50 disabled:cursor-not-allowed';
    
    $variants = [
        'primary' => 'bg-primary-500 text-white hover:bg-primary-600 focus:ring-primary-500 shadow-sm hover:shadow-md',
        'secondary' => 'bg-gray-100 text-gray-700 hover:bg-gray-200 focus:ring-gray-500 dark:bg-dark-hover dark:text-gray-200 dark:hover:bg-gray-700',
        'outline' => 'border-2 border-gray-300 text-gray-700 bg-transparent hover:bg-gray-50 focus:ring-gray-500 dark:border-dark-border dark:text-gray-300 dark:hover:bg-dark-hover',
        'ghost' => 'bg-transparent text-gray-600 hover:bg-gray-100 focus:ring-gray-500 dark:text-gray-300 dark:hover:bg-dark-hover',
        'danger' => 'bg-red-500 text-white hover:bg-red-600 focus:ring-red-500 shadow-sm hover:shadow-md',
        'success' => 'bg-emerald-500 text-white hover:bg-emerald-600 focus:ring-emerald-500 shadow-sm hover:shadow-md',
        'warning' => 'bg-amber-500 text-white hover:bg-amber-600 focus:ring-amber-500 shadow-sm hover:shadow-md',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs gap-1.5',
        'md' => 'px-4 py-2 text-sm gap-2',
        'lg' => 'px-6 py-3 text-base gap-2.5',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
    
    if ($fullWidth) {
        $classes .= ' w-full';
    }
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if(isset($icon))
            {{ $icon }}
        @endif
        {{ $slot }}
        @if(isset($iconRight))
            {{ $iconRight }}
        @endif
    </a>
@else
    <button 
        type="{{ $type }}" 
        {{ $attributes->merge(['class' => $classes]) }}
        @disabled($disabled || $loading)
    >
        @if($loading)
            <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif(isset($icon))
            {{ $icon }}
        @endif
        {{ $slot }}
        @if(isset($iconRight) && !$loading)
            {{ $iconRight }}
        @endif
    </button>
@endif
