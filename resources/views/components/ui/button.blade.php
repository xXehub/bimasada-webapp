@props([
    'variant' => 'primary', // primary, primary-dark, secondary, outline, ghost, danger, success
    'size' => 'md', // sm, md, lg
    'type' => 'button',
    'href' => null,
    'icon' => null,
    'iconRight' => null,
    'loading' => false,
    'disabled' => false,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-xl transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
    
    $variants = [
        'primary' => 'bg-primary text-white hover:bg-primary-600 focus:ring-primary shadow-md hover:shadow-lg dark:bg-primary-500 dark:hover:bg-primary-600',
        'primary-dark' => 'bg-primary-dark text-white hover:bg-primary-900 focus:ring-primary-dark shadow-md hover:shadow-lg',
        'secondary' => 'bg-secondary-100 text-secondary-700 hover:bg-secondary-200 focus:ring-secondary dark:bg-secondary-800 dark:text-secondary-200 dark:hover:bg-secondary-700',
        'outline' => 'border-2 border-primary text-primary bg-transparent hover:bg-primary hover:text-white focus:ring-primary dark:border-primary-400 dark:text-primary-400 dark:hover:bg-primary-400 dark:hover:text-white',
        'ghost' => 'bg-transparent text-secondary-600 hover:bg-secondary-100 focus:ring-secondary dark:text-secondary-300 dark:hover:bg-secondary-800',
        'danger' => 'bg-danger text-white hover:bg-danger-dark focus:ring-danger shadow-md hover:shadow-lg',
        'success' => 'bg-success text-white hover:bg-success-dark focus:ring-success shadow-md hover:shadow-lg',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm gap-1.5',
        'md' => 'px-4 py-2.5 text-sm gap-2',
        'lg' => 'px-6 py-3 text-base gap-2.5',
    ];

    $iconSizes = [
        'sm' => 'w-4 h-4',
        'md' => 'w-5 h-5',
        'lg' => 'w-5 h-5',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <x-dynamic-component :component="$icon" :class="$iconSizes[$size] ?? $iconSizes['md']" />
        @endif
        {{ $slot }}
        @if($iconRight)
            <x-dynamic-component :component="$iconRight" :class="$iconSizes[$size] ?? $iconSizes['md']" />
        @endif
    </a>
@else
    <button 
        type="{{ $type }}" 
        {{ $attributes->merge(['class' => $classes]) }}
        @disabled($disabled || $loading)
    >
        @if($loading)
            <svg class="animate-spin {{ $iconSizes[$size] ?? $iconSizes['md'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon)
            <x-dynamic-component :component="$icon" :class="$iconSizes[$size] ?? $iconSizes['md']" />
        @endif
        {{ $slot }}
        @if($iconRight && !$loading)
            <x-dynamic-component :component="$iconRight" :class="$iconSizes[$size] ?? $iconSizes['md']" />
        @endif
    </button>
@endif
