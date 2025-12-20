{{-- Select Input Component --}}
@props(['name', 'label' => '', 'options' => [], 'placeholder' => 'Select...', 'value' => ''])

<div {{ $attributes->merge(['class' => '']) }}>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
            {{ $label }}
        </label>
    @endif
    
    <select 
        id="{{ $name }}" 
        name="{{ $name }}"
        class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-md text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        
        @foreach($options as $key => $option)
            <option value="{{ $key }}" {{ old($name, $value) == $key ? 'selected' : '' }}>
                {{ $option }}
            </option>
        @endforeach
    </select>
</div>
