{{-- Textarea Component --}}
@props(['name', 'label' => '', 'placeholder' => '', 'rows' => 3, 'value' => ''])

<div {{ $attributes->merge(['class' => '']) }}>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
            {{ $label }}
        </label>
    @endif
    
    <textarea 
        id="{{ $name }}" 
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-y"
    >{{ old($name, $value) }}</textarea>
</div>
