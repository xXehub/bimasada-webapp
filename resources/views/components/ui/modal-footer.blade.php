@props([
    'align' => 'right', // left, center, right
])

@php
    $alignClasses = [
        'left' => 'justify-start',
        'center' => 'justify-center',
        'right' => 'justify-end',
    ][$align ?? 'right'];
@endphp

<div {{ $attributes->merge(['class' => "flex items-center gap-3 px-6 py-4 bg-gray-50 dark:bg-dark-sidebar border-t border-gray-200 dark:border-dark-border {$alignClasses}"]) }}>
    {{ $slot }}
</div>
