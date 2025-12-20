@props([
    'message' => 'Loading...',
    'overlay' => true,
])

@if($overlay)
<div {{ $attributes->merge(['class' => 'fixed inset-0 z-[200] flex items-center justify-center bg-white/80 dark:bg-dark-bg/80 backdrop-blur-sm']) }}>
    <div class="flex flex-col items-center gap-4">
        <div class="relative">
            <div class="w-16 h-16 rounded-full border-4 border-primary-200 dark:border-primary-900"></div>
            <div class="absolute top-0 left-0 w-16 h-16 rounded-full border-4 border-primary-500 border-t-transparent animate-spin"></div>
        </div>
        <p class="text-gray-600 dark:text-gray-400 font-medium">{{ $message }}</p>
    </div>
</div>
@else
<div {{ $attributes->merge(['class' => 'flex items-center justify-center py-12']) }}>
    <div class="flex flex-col items-center gap-4">
        <div class="relative">
            <div class="w-12 h-12 rounded-full border-4 border-primary-200 dark:border-primary-900"></div>
            <div class="absolute top-0 left-0 w-12 h-12 rounded-full border-4 border-primary-500 border-t-transparent animate-spin"></div>
        </div>
        <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $message }}</p>
    </div>
</div>
@endif
