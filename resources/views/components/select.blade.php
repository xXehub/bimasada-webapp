@props([
    'name' => '',
    'label' => null,
    'options' => [],
    'selected' => null,
    'required' => false,
    'placeholder' => 'Select an option',
])

@php
    $selectId = $attributes->get('id', $name);
    $baseClasses = 'w-full h-[61px] px-5 py-[23px] border-2 border-[#02245B] rounded-[20px] font-poppins text-[#02245B] text-base focus:outline-none focus:ring-2 focus:ring-[#2387C0] focus:border-[#2387C0] transition-all duration-200 bg-white';
@endphp

<div class="w-full">
    @if($label)
        <label for="{{ $selectId }}" class="block text-[#02245B] font-poppins font-medium text-base mb-2">
            {{ $label }}
            @if($required)
                <span class="text-[#DC3545]">*</span>
            @endif
        </label>
    @endif
    
    <select 
        name="{{ $name }}"
        id="{{ $selectId }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => $baseClasses]) }}
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        
        @foreach($options as $value => $text)
            <option 
                value="{{ $value }}" 
                {{ old($name, $selected) == $value ? 'selected' : '' }}
            >
                {{ $text }}
            </option>
        @endforeach
    </select>
    
    @error($name)
        <p class="mt-2 text-sm text-[#DC3545] font-poppins">{{ $message }}</p>
    @enderror
</div>
