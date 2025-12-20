@props([
    'title' => '',
    'description' => null,
    'backUrl' => null,
    'backLabel' => 'Back',
])

<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $title }}</h1>
        @if($description)
            <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $description }}</p>
        @endif
    </div>
    
    @if($backUrl || isset($actions))
        <div class="flex items-center gap-3">
            @if($backUrl)
                <x-ui.button variant="outline" :href="$backUrl">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </x-slot>
                    {{ $backLabel }}
                </x-ui.button>
            @endif
            
            @if(isset($actions))
                {{ $actions }}
            @endif
        </div>
    @endif
</div>
