{{-- Status Badge Component --}}
@props(['status' => 'draft'])

@php
$variants = [
    'paid' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400',
    'pending' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400',
    'overdue' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
    'draft' => 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300',
];

$labels = [
    'paid' => 'Paid',
    'pending' => 'Pending',
    'overdue' => 'Overdue',
    'draft' => 'Draft',
];

$variantClass = $variants[$status] ?? $variants['draft'];
$label = $labels[$status] ?? ucfirst($status);
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold {$variantClass}"]) }}>
    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
    {{ $label }}
</span>
