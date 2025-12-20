@props([
    'title' => '',
    'message' => '',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'type' => 'danger', // danger, warning, info
    'name' => 'confirm-modal',
    'action' => null,
])

@php
    $iconColors = [
        'danger' => 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400',
        'warning' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400',
        'info' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400',
    ][$type ?? 'danger'];
    
    $buttonVariant = $type === 'danger' ? 'danger' : ($type === 'warning' ? 'warning' : 'primary');
@endphp

<x-ui.modal :name="$name" maxWidth="sm">
    <div class="p-6 text-center">
        <!-- Icon -->
        <div class="mx-auto w-14 h-14 rounded-full {{ $iconColors }} flex items-center justify-center mb-4">
            @if($type === 'danger')
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            @elseif($type === 'warning')
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            @else
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            @endif
        </div>
        
        <!-- Title -->
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
            {{ $title }}
        </h3>
        
        <!-- Message -->
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
            {{ $message }}
        </p>
        
        <!-- Actions -->
        <div class="flex items-center justify-center gap-3">
            <button
                type="button"
                x-on:click="close()"
                class="btn-secondary"
            >
                {{ $cancelText }}
            </button>
            
            @if($action)
                <form action="{{ $action }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-{{ $buttonVariant }}">
                        {{ $confirmText }}
                    </button>
                </form>
            @else
                <button
                    type="button"
                    x-on:click="$dispatch('confirmed'); close()"
                    class="btn-{{ $buttonVariant }}"
                >
                    {{ $confirmText }}
                </button>
            @endif
        </div>
    </div>
</x-ui.modal>
