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
    $baseClasses = 'w-full h-[61px] px-5 py-[23px] border-2 border-[#02245B] rounded-[20px] font-poppins text-[#02245B] text-base focus:outline-none focus:ring-2 focus:ring-[#2387C0] focus:border-[#2387C0] transition-all duration-200 placeholder:text-[#02245B] placeholder:opacity-70';
    
    if($disabled) {
        $baseClasses .= ' bg-gray-100 cursor-not-allowed opacity-60';
    }
@endphp

<div class="w-full">
    @if($label)
        <label for="{{ $inputId }}" class="block text-[#02245B] font-poppins font-medium text-base mb-2">
            {{ $label }}
            @if($required)
                <span class="text-[#DC3545]">*</span>
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
