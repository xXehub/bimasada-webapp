{{-- 
Toast Notification Component
Usage: This is injected in the layout, you don't need to add it manually.
To trigger toast from controller or blade:
  session()->flash('toast', ['type' => 'success', 'message' => 'Invoice created!']);
  
To trigger from JavaScript/Alpine:
  $dispatch('toast', { type: 'success', message: 'Success!' });
--}}

<div
    x-data="{
        toasts: [],
        addToast(toast) {
            const id = Date.now();
            this.toasts.push({ id, ...toast });
            setTimeout(() => this.removeToast(id), toast.duration || 5000);
        },
        removeToast(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }
    }"
    x-on:toast.window="addToast($event.detail)"
    class="fixed top-4 right-4 z-[100] flex flex-col gap-3 pointer-events-none"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="true"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-x-8 scale-95"
            x-transition:enter-end="opacity-100 transform translate-x-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-x-0 scale-100"
            x-transition:leave-end="opacity-0 transform translate-x-8 scale-95"
            class="min-w-[320px] max-w-md bg-white dark:bg-dark-card rounded-xl shadow-lg border border-gray-200 dark:border-dark-border overflow-hidden pointer-events-auto"
        >
            <!-- Progress bar -->
            <div 
                class="h-1 transition-all duration-100"
                :class="{
                    'bg-emerald-500': toast.type === 'success',
                    'bg-red-500': toast.type === 'error',
                    'bg-amber-500': toast.type === 'warning',
                    'bg-blue-500': toast.type === 'info' || !toast.type
                }"
                x-init="$el.style.width = '100%'; setTimeout(() => $el.style.width = '0%', 100)"
                :style="'transition-duration: ' + (toast.duration || 5000) + 'ms'"
            ></div>
            
            <div class="flex items-start gap-3 p-4">
                <!-- Icon -->
                <div class="flex-shrink-0">
                    <template x-if="toast.type === 'success'">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </template>
                    <template x-if="toast.type === 'error'">
                        <div class="w-8 h-8 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    </template>
                    <template x-if="toast.type === 'warning'">
                        <div class="w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </template>
                    <template x-if="toast.type === 'info' || !toast.type">
                        <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </template>
                </div>
                
                <!-- Content -->
                <div class="flex-1 pt-0.5">
                    <template x-if="toast.title">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white" x-text="toast.title"></p>
                    </template>
                    <p class="text-sm text-gray-600 dark:text-gray-300" x-text="toast.message"></p>
                </div>
                
                <!-- Close Button -->
                <button
                    type="button"
                    x-on:click="removeToast(toast.id)"
                    class="flex-shrink-0 p-1 rounded-lg text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:text-gray-300 dark:hover:bg-dark-hover transition-colors"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </template>
</div>

{{-- Show flash message toast --}}
@if(session('toast'))
<script>
    document.addEventListener('alpine:init', () => {
        setTimeout(() => {
            window.dispatchEvent(new CustomEvent('toast', { 
                detail: @json(session('toast'))
            }));
        }, 100);
    });
</script>
@endif

@if(session('success'))
<script>
    document.addEventListener('alpine:init', () => {
        setTimeout(() => {
            window.dispatchEvent(new CustomEvent('toast', { 
                detail: { type: 'success', message: @json(session('success')) }
            }));
        }, 100);
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('alpine:init', () => {
        setTimeout(() => {
            window.dispatchEvent(new CustomEvent('toast', { 
                detail: { type: 'error', message: @json(session('error')) }
            }));
        }, 100);
    });
</script>
@endif
