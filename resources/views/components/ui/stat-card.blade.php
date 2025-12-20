@props([
    'icon' => null,
    'iconColor' => 'primary',
    'label' => '',
    'value' => '0',
])

@php
    $iconBgColors = [
        'primary' => 'bg-primary-100 dark:bg-primary-900/30',
        'emerald' => 'bg-emerald-100 dark:bg-emerald-900/30',
        'amber' => 'bg-amber-100 dark:bg-amber-900/30',
        'blue' => 'bg-blue-100 dark:bg-blue-900/30',
        'red' => 'bg-red-100 dark:bg-red-900/30',
        'purple' => 'bg-purple-100 dark:bg-purple-900/30',
    ];
    
    $iconTextColors = [
        'primary' => 'text-primary-600 dark:text-primary-400',
        'emerald' => 'text-emerald-600 dark:text-emerald-400',
        'amber' => 'text-amber-600 dark:text-amber-400',
        'blue' => 'text-blue-600 dark:text-blue-400',
        'red' => 'text-red-600 dark:text-red-400',
        'purple' => 'text-purple-600 dark:text-purple-400',
    ];
    
    $iconBgClass = $iconBgColors[$iconColor] ?? $iconBgColors['primary'];
    $iconTextClass = $iconTextColors[$iconColor] ?? $iconTextColors['primary'];
@endphp

<x-ui.card class="!p-4">
    <div class="flex items-center gap-4">
        @if($icon)
            <div class="w-12 h-12 rounded-md {{ $iconBgClass }} flex items-center justify-center flex-shrink-0">
                <div class="w-6 h-6 {{ $iconTextClass }}">
                    {{ $icon }}
                </div>
            </div>
        @endif
        
        <div class="flex-1 min-w-0">
            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $label }}</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $value }}</p>
        </div>
    </div>
</x-ui.card>
