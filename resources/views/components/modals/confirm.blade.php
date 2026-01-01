@props(['id' => 'confirm-modal', 'confirmColor' => 'blue'])

@php
$btn = ['blue' => 'bg-blue-600 hover:bg-blue-700', 'red' => 'bg-red-600 hover:bg-red-700', 'green' => 'bg-green-600 hover:bg-green-700', 'yellow' => 'bg-yellow-600 hover:bg-yellow-700'][$confirmColor] ?? 'bg-blue-600 hover:bg-blue-700';
@endphp

<div id="{{ $id }}" class="fixed inset-0 z-[9999] hidden" style="background-color: rgba(0, 0, 0, 0.75);">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full" onclick="event.stopPropagation()">
            <div class="p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white modal-title">Konfirmasi</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 modal-message">Apakah Anda yakin?</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-900 px-6 py-3 flex flex-row-reverse gap-3">
                <button type="button" class="modal-confirm px-4 py-2 {{ $btn }} text-white text-sm font-medium rounded-md">Ya</button>
                <button type="button" class="modal-cancel px-4 py-2 bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm font-medium rounded-md border border-gray-300 dark:border-gray-600">Batal</button>
            </div>
        </div>
    </div>
</div>
