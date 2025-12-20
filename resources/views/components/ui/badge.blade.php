@props([
    'variant' => 'primary', // primary, success, danger, warning, info, secondary
    'size' => 'md', // sm, md, lg
    'dot' => false,
])

@php
    $baseClasses = 'inline-flex items-center font-semibold rounded-md';
    
    $variants = [
        'primary' => 'bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-400',
        'success' => 'bg-success-light text-success-dark dark:bg-success/20 dark:text-success',
        'danger' => 'bg-danger-light text-danger-dark dark:bg-danger/20 dark:text-danger',
        'warning' => 'bg-warning-light text-warning-dark dark:bg-warning/20 dark:text-warning',
        'info' => 'bg-info-light text-info-dark dark:bg-info/20 dark:text-info',
        'secondary' => 'bg-secondary-100 text-secondary-700 dark:bg-secondary-800 dark:text-secondary-300',
    ];

    $sizes = [
        'sm' => 'px-2 py-0.5 text-xs',
        'md' => 'px-2.5 py-1 text-xs',
        'lg' => 'px-3 py-1.5 text-sm',
    ];

    $dotColors = [
        'primary' => 'bg-primary',
        'success' => 'bg-success',
        'danger' => 'bg-danger',
        'warning' => 'bg-warning',
        'info' => 'bg-info',
        'secondary' => 'bg-secondary',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $dotColors[$variant] ?? $dotColors['primary'] }}"></span>
    @endif
    {{ $slot }}
</span>
