@props([
    'sortable' => false,
    'sortKey' => null,
    'sortDirection' => null,
    'currentSort' => null,
    'currentDirection' => 'asc',
    'align' => 'left', // left, center, right
])

@php
    $alignClasses = [
        'left' => 'text-left',
        'center' => 'text-center',
        'right' => 'text-right',
    ][$align ?? 'left'];
    
    $isSorted = $currentSort === $sortKey;
@endphp

<th {{ $attributes->merge(['class' => "px-4 py-3 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider {$alignClasses}"]) }}>
    @if($sortable && $sortKey)
        <button
            type="button"
            wire:click="sortBy('{{ $sortKey }}')"
            class="inline-flex items-center gap-1 hover:text-gray-900 dark:hover:text-white transition-colors group"
        >
            <span>{{ $slot }}</span>
            <span class="flex flex-col {{ $isSorted ? 'text-primary-500' : 'text-gray-400 group-hover:text-gray-500' }}">
                <svg class="w-3 h-3 -mb-1 {{ $isSorted && $currentDirection === 'asc' ? 'text-primary-500' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L10 6.414l-3.293 3.293a1 1 0 01-1.414 0z" />
                </svg>
                <svg class="w-3 h-3 {{ $isSorted && $currentDirection === 'desc' ? 'text-primary-500' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L10 13.586l3.293-3.293a1 1 0 011.414 0z" />
                </svg>
            </span>
        </button>
    @else
        {{ $slot }}
    @endif
</th>
