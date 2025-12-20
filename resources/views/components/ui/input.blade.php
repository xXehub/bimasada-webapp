@props([
    'type' => 'text',
    'name' => '',
    'label' => null,
    'placeholder' => '',
    'value' => '',
    'error' => null,
    'helper' => null,
    'required' => false,
    'disabled' => false,
])

@php
    $hasIcon = isset($icon);
    $hasIconRight = isset($iconRight);
    
    $inputClasses = 'w-full px-4 py-2.5 rounded-xl border transition-all duration-200 focus:outline-none focus:ring-2 dark:focus:ring-offset-dark-bg';
    
    if ($error) {
        $inputClasses .= ' border-red-300 focus:ring-red-500 focus:border-red-500 bg-red-50 dark:bg-red-900/10 dark:border-red-800';
    } else {
        $inputClasses .= ' border-gray-300 focus:ring-primary-500 focus:border-primary-500 bg-white dark:bg-dark-hover dark:border-dark-border dark:text-white';
    }

    if ($hasIcon) {
        $inputClasses .= ' pl-11';
    }

    if ($hasIconRight) {
        $inputClasses .= ' pr-11';
    }

    $inputClasses .= ' placeholder:text-gray-400 dark:placeholder:text-gray-500';
    
    if ($disabled) {
        $inputClasses .= ' opacity-50 cursor-not-allowed bg-gray-100 dark:bg-dark-sidebar';
    }
@endphp

<div>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        @if($hasIcon)
            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 pointer-events-none">
                {{ $icon }}
            </div>
        @endif

        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => $inputClasses]) }}
            @if($required) required @endif
            @if($disabled) disabled @endif
        />

        @if($hasIconRight)
            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                {{ $iconRight }}
            </div>
        @endif
    </div>

    @if($error)
        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @elseif($helper)
        <p class="mt-1.5 text-sm text-gray-500 dark:text-gray-400">{{ $helper }}</p>
    @endif
</div>
