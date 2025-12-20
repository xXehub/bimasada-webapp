@props([
    'align' => 'right', // left, right
    'width' => '48', // 48, 56, 64
    'contentClasses' => '',
])

@php
    $alignmentClasses = [
        'left' => 'left-0 origin-top-left',
        'right' => 'right-0 origin-top-right',
    ][$align ?? 'right'];

    $widthClasses = [
        '48' => 'w-48',
        '56' => 'w-56',
        '64' => 'w-64',
    ][$width ?? '48'];
@endphp

<div class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
    <!-- Trigger -->
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <!-- Dropdown Menu -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 mt-2 {{ $widthClasses }} {{ $alignmentClasses }} rounded-xl bg-white dark:bg-dark-card shadow-lg border border-gray-200 dark:border-dark-border ring-1 ring-black ring-opacity-5 overflow-hidden"
        style="display: none;"
        @click="open = false"
    >
        <div class="py-1 {{ $contentClasses }}">
            {{ $slot }}
        </div>
    </div>
</div>
