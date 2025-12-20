@props([
    'align' => 'left', // left, center, right
])

@php
    $alignClasses = [
        'left' => 'text-left',
        'center' => 'text-center',
        'right' => 'text-right',
    ][$align ?? 'left'];
@endphp

<td {{ $attributes->merge(['class' => "px-4 py-3 text-gray-700 dark:text-gray-300 {$alignClasses}"]) }}>
    {{ $slot }}
</td>
