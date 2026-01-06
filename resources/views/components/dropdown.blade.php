{{-- Alias for x-ui.dropdown component (Breeze compatibility) --}}
<x-ui.dropdown {{ $attributes }}>
    <x-slot name="trigger">
        {{ $trigger }}
    </x-slot>
    {{ $content ?? $slot }}
</x-ui.dropdown>
