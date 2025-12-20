@props([
    'label' => '',
])

<div {{ $attributes->merge(['class' => 'px-4 py-2']) }}>
    @if($label)
        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">{{ $label }}</p>
    @endif
    <hr class="border-gray-200 dark:border-dark-border">
</div>
