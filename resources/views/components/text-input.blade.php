@props([
    'disabled' => false,
    'type' => 'text'
])

<input 
    type="{{ $type }}"
    {{ $disabled ? 'disabled' : '' }} 
    {!! $attributes->merge([
        'class' => 'w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed'
    ]) !!}
>
