@props([
    'type' => 'text',
    'name' => '',
    'label' => null,
    'placeholder' => '',
    'value' => '',
    'error' => null,
    'helper' => null,
    'icon' => null,
    'iconRight' => null,
    'required' => false,
    'disabled' => false,
])

@php
    $inputClasses = 'w-full px-4 py-3 rounded-xl border transition-all duration-200 focus:outline-none focus:ring-2';
    
    if ($error) {
        $inputClasses .= ' border-danger focus:ring-danger focus:border-danger bg-danger-light/10 dark:bg-danger/10';
    } else {
        $inputClasses .= ' border-secondary-200 focus:ring-primary focus:border-primary bg-white dark:bg-dark-card dark:border-dark-border dark:text-white';
    }

    if ($icon) {
        $inputClasses .= ' pl-11';
    }

    if ($iconRight) {
        $inputClasses .= ' pr-11';
    }

    $inputClasses .= ' placeholder:text-secondary-400 dark:placeholder:text-secondary-500';
@endphp

<div class="form-group">
    @if($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        @if($icon)
            <div class="input-icon">
                <x-dynamic-component :component="$icon" class="w-5 h-5" />
            </div>
        @endif

        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => $inputClasses]) }}
            @required($required)
            @disabled($disabled)
        />

        @if($iconRight)
            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-secondary-400 dark:text-secondary-500">
                <x-dynamic-component :component="$iconRight" class="w-5 h-5" />
            </div>
        @endif
    </div>

    @if($error)
        <p class="form-error">{{ $error }}</p>
    @elseif($helper)
        <p class="form-helper">{{ $helper }}</p>
    @endif
</div>
