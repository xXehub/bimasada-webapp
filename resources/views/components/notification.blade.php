<!-- Notification Container -->
<div id="notification-container" 
     class="fixed top-4 right-4 z-[9999] flex flex-col gap-3 max-w-md"
     style="pointer-events: none;">
</div>

<!-- Notification Template -->
<template id="notification-template">
    <div class="notification-item bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden"
         style="pointer-events: auto;"
         role="alert">
        <div class="flex items-start gap-3 p-4">
            <!-- Icon -->
            <div class="flex-shrink-0 notification-icon-container">
                <!-- Success Icon -->
                <div class="notification-icon-success hidden w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <!-- Error Icon -->
                <div class="notification-icon-error hidden w-8 h-8 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <!-- Warning Icon -->
                <div class="notification-icon-warning hidden w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <!-- Info Icon -->
                <div class="notification-icon-info hidden w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            
            <!-- Content -->
            <div class="flex-1 pt-0.5">
                <p class="notification-title text-sm font-semibold text-gray-900 dark:text-white"></p>
                <p class="notification-message text-sm text-gray-600 dark:text-gray-300"></p>
            </div>
            
            <!-- Close Button -->
            <button type="button" class="flex-shrink-0 p-1 rounded-lg text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Progress Bar -->
        <div class="notification-progress h-1 bg-gray-200 dark:bg-gray-700">
            <div class="notification-progress-bar h-full"></div>
        </div>
    </div>
</template>


<style>
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    .notification-item {
        animation: slideInRight 0.3s ease-out;
    }
</style>
