@props([
    'colspan' => 1,
    'message' => 'No data available',
    'icon' => true,
])

<tr>
    <td colspan="{{ $colspan }}" class="px-4 py-12 text-center">
        <div class="flex flex-col items-center justify-center">
            @if($icon)
                <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-dark-hover flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
            @endif
            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $message }}</p>
            @if(isset($action))
                <div class="mt-4">
                    {{ $action }}
                </div>
            @endif
        </div>
    </td>
</tr>
