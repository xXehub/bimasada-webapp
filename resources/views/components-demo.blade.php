<x-layout.app title="Component Demo">
    <div class="space-y-8">
        
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Component Library Demo</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Showcase of all UI components</p>
            </div>
        </div>

        <!-- Buttons Section -->
        <x-ui.card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Buttons</h3>
            </x-slot>
            
            <div class="space-y-4">
                <div class="flex flex-wrap gap-3">
                    <x-ui.button variant="primary">Primary</x-ui.button>
                    <x-ui.button variant="secondary">Secondary</x-ui.button>
                    <x-ui.button variant="outline">Outline</x-ui.button>
                    <x-ui.button variant="ghost">Ghost</x-ui.button>
                    <x-ui.button variant="danger">Danger</x-ui.button>
                    <x-ui.button variant="success">Success</x-ui.button>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <x-ui.button size="sm">Small</x-ui.button>
                    <x-ui.button size="md">Medium</x-ui.button>
                    <x-ui.button size="lg">Large</x-ui.button>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <x-ui.button variant="primary" :loading="true">Loading</x-ui.button>
                    <x-ui.button variant="primary" disabled>Disabled</x-ui.button>
                    <x-ui.button variant="primary">
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </x-slot>
                        With Icon
                    </x-ui.button>
                </div>
            </div>
        </x-ui.card>
        
        <!-- Alerts Section -->
        <x-ui.card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Alerts</h3>
            </x-slot>
            
            <div class="space-y-3">
                <x-ui.alert type="success" message="This is a success alert - everything worked!" :autoDismiss="false" />
                <x-ui.alert type="error" message="This is an error alert - something went wrong!" :autoDismiss="false" />
                <x-ui.alert type="warning" message="This is a warning alert - be careful!" :autoDismiss="false" />
                <x-ui.alert type="info" message="This is an info alert - just FYI." :autoDismiss="false" />
            </div>
        </x-ui.card>
        
        <!-- Badges Section -->
        <x-ui.card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Badges</h3>
            </x-slot>
            
            <div class="space-y-4">
                <div class="flex flex-wrap gap-2">
                    <x-ui.badge variant="primary">Primary</x-ui.badge>
                    <x-ui.badge variant="secondary">Secondary</x-ui.badge>
                    <x-ui.badge variant="success">Success</x-ui.badge>
                    <x-ui.badge variant="danger">Danger</x-ui.badge>
                    <x-ui.badge variant="warning">Warning</x-ui.badge>
                    <x-ui.badge variant="info">Info</x-ui.badge>
                </div>
                
                <div class="flex flex-wrap gap-2">
                    <x-ui.badge variant="success" :dot="true">Active</x-ui.badge>
                    <x-ui.badge variant="warning" :dot="true">Pending</x-ui.badge>
                    <x-ui.badge variant="danger" :dot="true">Inactive</x-ui.badge>
                </div>
            </div>
        </x-ui.card>
        
        <!-- Input Section -->
        <x-ui.card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Inputs</h3>
            </x-slot>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-ui.input label="Default Input" placeholder="Enter text..." />
                <x-ui.input label="With Icon" placeholder="Search...">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </x-slot>
                </x-ui.input>
                <x-ui.input label="With Error" value="invalid@email" error="Please enter a valid email address" />
                <x-ui.input label="Disabled" value="Disabled value" disabled />
            </div>
        </x-ui.card>
        
        <!-- Toast Demo Section -->
        <x-ui.card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Toast Notifications</h3>
            </x-slot>
            
            <div class="flex flex-wrap gap-3">
                <x-ui.button 
                    variant="success" 
                    x-on:click="$dispatch('toast', { type: 'success', title: 'Success!', message: 'Operation completed successfully.' })"
                >
                    Success Toast
                </x-ui.button>
                <x-ui.button 
                    variant="danger" 
                    x-on:click="$dispatch('toast', { type: 'error', title: 'Error!', message: 'Something went wrong.' })"
                >
                    Error Toast
                </x-ui.button>
                <x-ui.button 
                    variant="outline" 
                    x-on:click="$dispatch('toast', { type: 'warning', title: 'Warning!', message: 'Please check your input.' })"
                >
                    Warning Toast
                </x-ui.button>
                <x-ui.button 
                    variant="secondary" 
                    x-on:click="$dispatch('toast', { type: 'info', title: 'Info', message: 'Just letting you know.' })"
                >
                    Info Toast
                </x-ui.button>
            </div>
        </x-ui.card>
        
        <!-- Modal Demo Section -->
        <x-ui.card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Modals</h3>
            </x-slot>
            
            <div class="flex flex-wrap gap-3">
                <x-ui.button 
                    variant="primary" 
                    x-on:click="$dispatch('open-modal', 'demo-modal')"
                >
                    Open Modal
                </x-ui.button>
                <x-ui.button 
                    variant="danger" 
                    x-on:click="$dispatch('open-modal', 'delete-confirm')"
                >
                    Delete Confirmation
                </x-ui.button>
            </div>
        </x-ui.card>
        
        <!-- Table Section -->
        <x-ui.card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Table</h3>
            </x-slot>
            
            <x-ui.table :hoverable="true">
                <x-slot name="head">
                    <tr>
                        <x-ui.table-header>Invoice</x-ui.table-header>
                        <x-ui.table-header>Customer</x-ui.table-header>
                        <x-ui.table-header>Status</x-ui.table-header>
                        <x-ui.table-header align="right">Amount</x-ui.table-header>
                        <x-ui.table-header align="center">Actions</x-ui.table-header>
                    </tr>
                </x-slot>
                
                <tr>
                    <x-ui.table-cell>
                        <span class="font-medium text-gray-900 dark:text-white">INV-001</span>
                    </x-ui.table-cell>
                    <x-ui.table-cell>PT ABC Indonesia</x-ui.table-cell>
                    <x-ui.table-cell>
                        <x-ui.badge variant="success" :dot="true">Approved</x-ui.badge>
                    </x-ui.table-cell>
                    <x-ui.table-cell align="right">
                        <span class="font-semibold">Rp 15.000.000</span>
                    </x-ui.table-cell>
                    <x-ui.table-cell align="center">
                        <div class="flex items-center justify-center gap-2">
                            <button class="p-1.5 rounded-lg text-gray-500 hover:text-primary-600 hover:bg-gray-100 dark:hover:bg-dark-hover">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <button class="p-1.5 rounded-lg text-gray-500 hover:text-blue-600 hover:bg-gray-100 dark:hover:bg-dark-hover">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </div>
                    </x-ui.table-cell>
                </tr>
                <tr>
                    <x-ui.table-cell>
                        <span class="font-medium text-gray-900 dark:text-white">INV-002</span>
                    </x-ui.table-cell>
                    <x-ui.table-cell>CV Maju Bersama</x-ui.table-cell>
                    <x-ui.table-cell>
                        <x-ui.badge variant="warning" :dot="true">Pending</x-ui.badge>
                    </x-ui.table-cell>
                    <x-ui.table-cell align="right">
                        <span class="font-semibold">Rp 8.500.000</span>
                    </x-ui.table-cell>
                    <x-ui.table-cell align="center">
                        <div class="flex items-center justify-center gap-2">
                            <button class="p-1.5 rounded-lg text-gray-500 hover:text-primary-600 hover:bg-gray-100 dark:hover:bg-dark-hover">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <button class="p-1.5 rounded-lg text-gray-500 hover:text-blue-600 hover:bg-gray-100 dark:hover:bg-dark-hover">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </div>
                    </x-ui.table-cell>
                </tr>
            </x-ui.table>
        </x-ui.card>
        
        <!-- Loading States Section -->
        <x-ui.card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Loading States</h3>
            </x-slot>
            
            <div class="space-y-6">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Spinners:</p>
                    <div class="flex items-center gap-4">
                        <x-ui.spinner size="xs" />
                        <x-ui.spinner size="sm" />
                        <x-ui.spinner size="md" />
                        <x-ui.spinner size="lg" />
                        <x-ui.spinner size="xl" />
                    </div>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Skeletons:</p>
                    <div class="space-y-2">
                        <x-ui.skeleton width="w-3/4" />
                        <x-ui.skeleton width="w-1/2" />
                        <x-ui.skeleton width="w-1/4" />
                    </div>
                </div>
            </div>
        </x-ui.card>
        
        <!-- Dropdown Section -->
        <x-ui.card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Dropdowns</h3>
            </x-slot>
            
            <div class="flex flex-wrap gap-4">
                <x-ui.dropdown>
                    <x-slot name="trigger">
                        <x-ui.button variant="secondary">
                            Actions
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </x-ui.button>
                    </x-slot>
                    
                    <x-ui.dropdown-item href="#">
                        <x-slot name="icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </x-slot>
                        View Details
                    </x-ui.dropdown-item>
                    <x-ui.dropdown-item href="#">
                        <x-slot name="icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </x-slot>
                        Edit
                    </x-ui.dropdown-item>
                    <x-ui.dropdown-divider />
                    <x-ui.dropdown-item :danger="true">
                        <x-slot name="icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </x-slot>
                        Delete
                    </x-ui.dropdown-item>
                </x-ui.dropdown>
            </div>
        </x-ui.card>
        
    </div>
    
    <!-- Demo Modal -->
    <x-ui.modal name="demo-modal" maxWidth="md">
        <x-ui.modal-header title="Demo Modal">
            <x-slot name="subtitle">This is a subtitle</x-slot>
        </x-ui.modal-header>
        <x-ui.modal-body>
            <p class="text-gray-600 dark:text-gray-300">
                This is a demo modal with header, body, and footer components.
                You can customize the content and actions as needed.
            </p>
            <div class="mt-4">
                <x-ui.input label="Sample Input" placeholder="Enter something..." />
            </div>
        </x-ui.modal-body>
        <x-ui.modal-footer>
            <x-ui.button variant="secondary" x-on:click="close()">Cancel</x-ui.button>
            <x-ui.button variant="primary" x-on:click="close()">Save Changes</x-ui.button>
        </x-ui.modal-footer>
    </x-ui.modal>
    
    <!-- Delete Confirmation Modal -->
    <x-ui.confirm-modal 
        name="delete-confirm"
        type="danger"
        title="Delete Item?"
        message="Are you sure you want to delete this item? This action cannot be undone."
        confirmText="Delete"
        cancelText="Cancel"
    />
    
</x-layout.app>
