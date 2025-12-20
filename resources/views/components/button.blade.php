@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'icon' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-poppins font-semibold transition-colors duration-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2';
    
    $variantClasses = [
        'primary' => 'bg-[#02245B] text-white hover:bg-[#01183d] focus:ring-[#2387C0]',
        'secondary' => 'bg-white text-[#02245B] border-2 border-[#02245B] hover:bg-gray-50 focus:ring-[#2387C0]',
        'success' => 'bg-[#28A745] text-white hover:bg-[#218838] focus:ring-[#28A745]',
        'danger' => 'bg-[#DC3545] text-white hover:bg-[#c82333] focus:ring-[#DC3545]',
        'outline' => 'bg-transparent text-[#02245B] border-2 border-[#02245B] hover:bg-[#02245B] hover:text-white focus:ring-[#2387C0]',
        'link' => 'bg-transparent text-[#2387C0] hover:text-[#1a6a99] hover:underline focus:ring-[#2387C0]',
    ];
    
    $sizeClasses = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-3 text-base',
        'lg' => 'px-8 py-4 text-lg',
    ];
    
    $classes = $baseClasses . ' ' . ($variantClasses[$variant] ?? $variantClasses['primary']) . ' ' . ($sizeClasses[$size] ?? $sizeClasses['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <i class="{{ $icon }} mr-2"></i>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <i class="{{ $icon }} mr-2"></i>
        @endif
        {{ $slot }}
    </button>
@endif
