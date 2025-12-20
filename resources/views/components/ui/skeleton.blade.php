@props([
    'class' => '',
    'height' => 'h-4',
    'width' => 'w-full',
    'rounded' => 'rounded',
])

<div {{ $attributes->merge(['class' => "animate-pulse bg-gray-200 dark:bg-dark-hover {$height} {$width} {$rounded} {$class}"]) }}></div>
