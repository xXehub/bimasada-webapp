@props([
    'striped' => false,
    'hoverable' => true,
    'compact' => false,
])

@php
    $tableClasses = 'w-full text-sm text-left';
    if ($compact) {
        $tableClasses .= ' table-compact';
    }
@endphp

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl border border-gray-200 dark:border-dark-border bg-white dark:bg-dark-card']) }}>
    <div class="overflow-x-auto">
        <table class="{{ $tableClasses }}">
            @if(isset($head))
                <thead class="bg-gray-50 dark:bg-dark-sidebar border-b border-gray-200 dark:border-dark-border">
                    {{ $head }}
                </thead>
            @endif
            
            <tbody class="divide-y divide-gray-200 dark:divide-dark-border {{ $striped ? '[&>tr:nth-child(odd)]:bg-gray-50 dark:[&>tr:nth-child(odd)]:bg-dark-hover' : '' }} {{ $hoverable ? '[&>tr]:hover:bg-gray-50 dark:[&>tr]:hover:bg-dark-hover [&>tr]:transition-colors' : '' }}">
                {{ $slot }}
            </tbody>
            
            @if(isset($foot))
                <tfoot class="bg-gray-50 dark:bg-dark-sidebar border-t border-gray-200 dark:border-dark-border">
                    {{ $foot }}
                </tfoot>
            @endif
        </table>
    </div>
    
    @if(isset($pagination))
        <div class="px-4 py-3 border-t border-gray-200 dark:border-dark-border">
            {{ $pagination }}
        </div>
    @endif
</div>
