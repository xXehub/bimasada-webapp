@props([
    'type' => 'text',
    'name' => '',
    'value' => '',
    'placeholder' => '',
    'label' => null,
    'required' => false,
    'disabled' => false,
    'id' => null,
])

@php
    $inputId = $id ?? $name;
    // Placeholder HITAM TEBAL seperti di contoh Figma yang benar
    $baseClasses = 'w-full px-5 py-3 border-2 border-primary rounded-[20px] font-poppins text-black text-base font-medium focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 placeholder:text-black placeholder:font-semibold';
    
    if($disabled) {
        $baseClasses .= ' bg-gray-100 cursor-not-allowed opacity-60';
    }
@endphp

<div class="w-full">
    @if($label)
        <label for="{{ $inputId }}" class="block text-primary-dark font-poppins font-medium text-base mb-2">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    
    <input 
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $inputId }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => $baseClasses]) }}
    >
    
    @error($name)
        <p class="mt-2 text-sm text-[#DC3545] font-poppins">{{ $message }}</p>
    @enderror
</div>
