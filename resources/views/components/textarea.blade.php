@props([
    'name' => '',
    'label' => null,
    'value' => '',
    'placeholder' => '',
    'rows' => 4,
    'required' => false,
])

@php
    $textareaId = $attributes->get('id', $name);
    $baseClasses = 'w-full px-5 py-4 border-2 border-[#02245B] rounded-[20px] font-poppins text-[#02245B] text-base focus:outline-none focus:ring-2 focus:ring-[#2387C0] focus:border-[#2387C0] transition-all duration-200 placeholder:text-[#02245B] placeholder:opacity-70 resize-none';
@endphp

<div class="w-full">
    @if($label)
        <label for="{{ $textareaId }}" class="block text-[#02245B] font-poppins font-medium text-base mb-2">
            {{ $label }}
            @if($required)
                <span class="text-[#DC3545]">*</span>
            @endif
        </label>
    @endif
    
    <textarea 
        name="{{ $name }}"
        id="{{ $textareaId }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => $baseClasses]) }}
    >{{ old($name, $value) }}</textarea>
    
    @error($name)
        <p class="mt-2 text-sm text-[#DC3545] font-poppins">{{ $message }}</p>
    @enderror
</div>
