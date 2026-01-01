<!-- Notification Container -->
<div id="notification-container" 
     class="fixed top-4 right-4 z-50 flex flex-col gap-3 max-w-md"
     style="pointer-events: none;">
</div>

<!-- Notification Template (Hidden) -->
<template id="notification-template">
    <div class="notification-item bg-white rounded-lg shadow-lg border-l-4 overflow-hidden transform transition-all duration-300 ease-in-out"
         style="pointer-events: auto;"
         role="alert">
        <div class="p-4 flex items-start gap-3">
            <!-- Icon Container -->
            <div class="flex-shrink-0">
                <div class="notification-icon w-6 h-6 rounded-full flex items-center justify-center">
                    <!-- Icon will be injected here -->
                </div>
            </div>
            
            <!-- Content -->
            <div class="flex-1 min-w-0">
                <h4 class="notification-title text-sm font-semibold mb-1"></h4>
                <p class="notification-message text-sm text-gray-600"></p>
            </div>
            
            <!-- Close Button -->
            <button type="button" 
                    class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors"
                    onclick="this.closest('.notification-item').remove()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <!-- Progress Bar -->
        <div class="notification-progress h-1 bg-gray-200">
            <div class="notification-progress-bar h-full transition-all duration-100 ease-linear"></div>
        </div>
    </div>
</template>

<style>
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .notification-item {
        animation: slideInRight 0.3s ease-out;
    }
    
    .notification-item.removing {
        animation: slideOutRight 0.3s ease-in;
    }
    
    /* Success */
    .notification-success {
        border-left-color: #10b981;
    }
    
    .notification-success .notification-icon {
        background-color: #d1fae5;
        color: #10b981;
    }
    
    .notification-success .notification-progress-bar {
        background-color: #10b981;
    }
    
    /* Error */
    .notification-error {
        border-left-color: #ef4444;
    }
    
    .notification-error .notification-icon {
        background-color: #fee2e2;
        color: #ef4444;
    }
    
    .notification-error .notification-progress-bar {
        background-color: #ef4444;
    }
    
    /* Warning */
    .notification-warning {
        border-left-color: #f59e0b;
    }
    
    .notification-warning .notification-icon {
        background-color: #fef3c7;
        color: #f59e0b;
    }
    
    .notification-warning .notification-progress-bar {
        background-color: #f59e0b;
    }
    
    /* Info */
    .notification-info {
        border-left-color: #3b82f6;
    }
    
    .notification-info .notification-icon {
        background-color: #dbeafe;
        color: #3b82f6;
    }
    
    .notification-info .notification-progress-bar {
        background-color: #3b82f6;
    }
</style>

<script>
    // Notification System
    window.Notification = {
        // Show notification
        show(type, title, message, duration = 5000) {
            const container = document.getElementById('notification-container');
            const template = document.getElementById('notification-template');
            const clone = template.content.cloneNode(true);
            const notification = clone.querySelector('.notification-item');
            
            // Add type class
            notification.classList.add(`notification-${type}`);
            
            // Set icon
            const iconContainer = notification.querySelector('.notification-icon');
            iconContainer.innerHTML = this.getIcon(type);
            
            // Set content
            notification.querySelector('.notification-title').textContent = title;
            notification.querySelector('.notification-message').textContent = message;
            
            // Add to container
            container.appendChild(notification);
            
            // Progress bar animation
            const progressBar = notification.querySelector('.notification-progress-bar');
            progressBar.style.width = '100%';
            
            setTimeout(() => {
                progressBar.style.width = '0%';
                progressBar.style.transition = `width ${duration}ms linear`;
            }, 10);
            
            // Auto remove
            const timeout = setTimeout(() => {
                this.remove(notification);
            }, duration);
            
            // Cancel auto-remove on hover
            notification.addEventListener('mouseenter', () => {
                clearTimeout(timeout);
                progressBar.style.transition = 'none';
            });
            
            notification.addEventListener('mouseleave', () => {
                this.remove(notification, 1000);
            });
            
            return notification;
        },
        
        // Remove notification
        remove(notification, delay = 0) {
            setTimeout(() => {
                notification.classList.add('removing');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, delay);
        },
        
        // Get icon SVG
        getIcon(type) {
            const icons = {
                success: '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>',
                error: '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>',
                warning: '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>',
                info: '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>'
            };
            return icons[type] || icons.info;
        },
        
        // Shorthand methods
        success(title, message, duration) {
            return this.show('success', title, message, duration);
        },
        
        error(title, message, duration) {
            return this.show('error', title, message, duration);
        },
        
        warning(title, message, duration) {
            return this.show('warning', title, message, duration);
        },
        
        info(title, message, duration) {
            return this.show('info', title, message, duration);
        }
    };
</script>
