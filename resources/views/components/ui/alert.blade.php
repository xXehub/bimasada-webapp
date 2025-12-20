@props([
    'type' => 'success', // success, error, warning, info
    'message' => '',
    'dismissible' => true,
    'autoDismiss' => true,
    'duration' => 5000,
])

@php
    $styles = [
        'success' => [
            'bg' => 'bg-emerald-50 dark:bg-emerald-900/20',
            'border' => 'border-emerald-200 dark:border-emerald-800',
            'icon' => 'text-emerald-500',
            'text' => 'text-emerald-800 dark:text-emerald-200',
        ],
        'error' => [
            'bg' => 'bg-red-50 dark:bg-red-900/20',
            'border' => 'border-red-200 dark:border-red-800',
            'icon' => 'text-red-500',
            'text' => 'text-red-800 dark:text-red-200',
        ],
        'warning' => [
            'bg' => 'bg-amber-50 dark:bg-amber-900/20',
            'border' => 'border-amber-200 dark:border-amber-800',
            'icon' => 'text-amber-500',
            'text' => 'text-amber-800 dark:text-amber-200',
        ],
        'info' => [
            'bg' => 'bg-blue-50 dark:bg-blue-900/20',
            'border' => 'border-blue-200 dark:border-blue-800',
            'icon' => 'text-blue-500',
            'text' => 'text-blue-800 dark:text-blue-200',
        ],
    ][$type] ?? $styles['info'];
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-x-8"
    x-transition:enter-end="opacity-100 transform translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-x-0"
    x-transition:leave-end="opacity-0 transform translate-x-8"
    @if($autoDismiss)
    x-init="setTimeout(() => show = false, {{ $duration }})"
    @endif
    {{ $attributes->merge(['class' => "flex items-start gap-3 p-4 rounded-md border {$styles['bg']} {$styles['border']}"]) }}
>
    <!-- Icon -->
    <div class="flex-shrink-0 {{ $styles['icon'] }}">
        @if($type === 'success')
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        @elseif($type === 'error')
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        @elseif($type === 'warning')
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        @else
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        @endif
    </div>
    
    <!-- Content -->
    <div class="flex-1 {{ $styles['text'] }}">
        @if($message)
            <p class="text-sm font-medium">{{ $message }}</p>
        @else
            {{ $slot }}
        @endif
    </div>
    
    <!-- Dismiss Button -->
    @if($dismissible)
        <button
            type="button"
            x-on:click="show = false"
            class="flex-shrink-0 {{ $styles['text'] }} opacity-70 hover:opacity-100 transition-opacity"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    @endif
</div>
