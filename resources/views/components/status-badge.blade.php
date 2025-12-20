@props([
    'status' => 'pending'
])

@php
    $statusConfig = [
        'paid' => [
            'text' => 'PAID',
            'classes' => 'bg-[#28A745] text-white'
        ],
        'pending' => [
            'text' => 'PENDING',
            'classes' => 'bg-[#FFA500] text-white'
        ],
        'overdue' => [
            'text' => 'OVERDUE',
            'classes' => 'bg-[#DC3545] text-white'
        ],
        'draft' => [
            'text' => 'DRAFT',
            'classes' => 'bg-[#858788] text-white'
        ],
    ];
    
    $config = $statusConfig[strtolower($status)] ?? $statusConfig['pending'];
    $baseClasses = 'inline-flex items-center justify-center px-3 py-1 rounded-md font-poppins font-semibold text-xs uppercase tracking-wider';
@endphp

<span {{ $attributes->merge(['class' => $baseClasses . ' ' . $config['classes']]) }}>
    {{ $config['text'] }}
</span>
