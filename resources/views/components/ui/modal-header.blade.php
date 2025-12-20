@props([
    'title' => '',
    'closeable' => true,
])

<div {{ $attributes->merge(['class' => 'flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-dark-border']) }}>
    <div class="flex items-center gap-3">
        @if(isset($icon))
            <div class="flex-shrink-0">
                {{ $icon }}
            </div>
        @endif
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                {{ $title ?: $slot }}
            </h3>
            @if(isset($subtitle))
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
    </div>
    
    @if($closeable)
        <button
            type="button"
            x-on:click="close()"
            class="rounded-lg p-2 text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:text-gray-300 dark:hover:bg-dark-hover focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    @endif
</div>
