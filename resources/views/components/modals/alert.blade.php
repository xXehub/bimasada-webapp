@props(['id' => 'alert-modal', 'type' => 'info'])

@php
$cfg = [
    'success' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'ic' => 'text-green-600 dark:text-green-400', 'btn' => 'bg-green-600 hover:bg-green-700', 'p' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
    'error' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'ic' => 'text-red-600 dark:text-red-400', 'btn' => 'bg-red-600 hover:bg-red-700', 'p' => 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
    'warning' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'ic' => 'text-yellow-600 dark:text-yellow-400', 'btn' => 'bg-yellow-600 hover:bg-yellow-700', 'p' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z'],
    'info' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'ic' => 'text-blue-600 dark:text-blue-400', 'btn' => 'bg-blue-600 hover:bg-blue-700', 'p' => 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z']
];
$c = $cfg[$type] ?? $cfg['info'];
@endphp

<div id="{{ $id }}" class="fixed inset-0 z-[9999] hidden" style="background-color: rgba(0, 0, 0, 0.75);">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full" onclick="event.stopPropagation()">
            <div class="p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-12 h-12 {{ $c['bg'] }} rounded-full">
                            <svg class="w-6 h-6 {{ $c['ic'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $c['p'] }}" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white modal-title">Alert</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 modal-message">Message</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-900 px-6 py-3 flex justify-end">
                <button type="button" class="modal-confirm px-4 py-2 {{ $c['btn'] }} text-white text-sm font-medium rounded-md">OK</button>
            </div>
        </div>
    </div>
</div>
