@props([
    'id' => 'alert-modal',
    'type' => 'info', // success, error, warning, info
    'title' => 'Alert',
    'message' => '',
    'confirmText' => 'OK'
])

@php
    $typeConfig = [
        'success' => [
            'bgColor' => 'bg-green-100',
            'iconColor' => 'text-green-600',
            'buttonColor' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
        ],
        'error' => [
            'bgColor' => 'bg-red-100',
            'iconColor' => 'text-red-600',
            'buttonColor' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
        ],
        'warning' => [
            'bgColor' => 'bg-yellow-100',
            'iconColor' => 'text-yellow-600',
            'buttonColor' => 'bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />'
        ],
        'info' => [
            'bgColor' => 'bg-blue-100',
            'iconColor' => 'text-blue-600',
            'buttonColor' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />'
        ]
    ];
    
    $config = $typeConfig[$type] ?? $typeConfig['info'];
@endphp

<!-- Alert Modal -->
<div id="{{ $id }}" 
     class="modal fixed inset-0 z-50 hidden overflow-y-auto"
     aria-labelledby="modal-title" 
     role="dialog" 
     aria-modal="true">
    <!-- Backdrop -->
    <div class="modal-backdrop fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"></div>
    
    <!-- Modal Container -->
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <!-- Modal Panel -->
        <div class="modal-panel relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <!-- Icon -->
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full {{ $config['bgColor'] }} sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 {{ $config['iconColor'] }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            {!! $config['icon'] !!}
                        </svg>
                    </div>
                    
                    <!-- Content -->
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left flex-1">
                        <h3 class="text-lg font-semibold leading-6 text-gray-900 modal-title" id="modal-title">
                            {{ $title }}
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 modal-message">
                                {{ $message }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                <button type="button" 
                        class="modal-confirm inline-flex w-full justify-center rounded-md {{ $config['buttonColor'] }} px-4 py-2 text-sm font-semibold text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto transition-colors">
                    {{ $confirmText }}
                </button>
            </div>
        </div>
    </div>
</div>
