@props([
    'href' => null,
    'active' => false,
    'icon' => null,
    'danger' => false,
])

@php
    $baseClasses = 'w-full flex items-center gap-3 px-4 py-2.5 text-sm transition-colors';
    
    if ($danger) {
        $stateClasses = 'text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20';
    } elseif ($active) {
        $stateClasses = 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400';
    } else {
        $stateClasses = 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-dark-hover';
    }
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "{$baseClasses} {$stateClasses}"]) }}>
        @if($icon)
            <span class="w-5 h-5 flex-shrink-0">
                {{ $icon }}
            </span>
        @endif
        <span>{{ $slot }}</span>
    </a>
@else
    <button type="button" {{ $attributes->merge(['class' => "{$baseClasses} {$stateClasses}"]) }}>
        @if($icon)
            <span class="w-5 h-5 flex-shrink-0">
                {{ $icon }}
            </span>
        @endif
        <span>{{ $slot }}</span>
    </button>
@endif
