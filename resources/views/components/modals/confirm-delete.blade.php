@props(['id' => 'confirm-delete-modal'])

<div id="{{ $id }}" class="fixed inset-0 z-[9999] hidden" style="background-color: rgba(0, 0, 0, 0.75);">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full" onclick="event.stopPropagation()">
            <div class="p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white modal-title">Konfirmasi Hapus</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 modal-message">Apakah Anda yakin?</p>
                        <div class="modal-item-name mt-2 hidden">
                            <p class="text-sm font-medium text-red-600 dark:text-red-400"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-900 px-6 py-3 flex flex-row-reverse gap-3">
                <button type="button" class="modal-confirm px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md">Hapus</button>
                <button type="button" class="modal-cancel px-4 py-2 bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm font-medium rounded-md border border-gray-300 dark:border-gray-600">Batal</button>
            </div>
        </div>
    </div>
</div>
