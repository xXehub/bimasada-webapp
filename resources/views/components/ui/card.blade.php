@props([
    'hover' => false,
    'padding' => true,
])

@php
    $classes = 'bg-white rounded-md shadow-card border border-secondary-100 dark:bg-dark-card dark:border-dark-border';
    
    if ($hover) {
        $classes .= ' hover:shadow-lg hover:border-primary/20 transition-all duration-300 cursor-pointer';
    }
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if(isset($header))
        <div class="px-6 py-4 border-b border-secondary-100 dark:border-dark-border">
            {{ $header }}
        </div>
    @endif

    <div @class(['p-6' => $padding, 'p-0' => !$padding])>
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="px-6 py-4 border-t border-secondary-100 dark:border-dark-border">
            {{ $footer }}
        </div>
    @endif
</div>
