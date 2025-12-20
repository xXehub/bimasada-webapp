<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Component Preview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Buttons Section -->
            <x-card title="Buttons">
                <div class="flex flex-wrap gap-4">
                    <x-button variant="primary">Primary Button</x-button>
                    <x-button variant="secondary">Secondary Button</x-button>
                    <x-button variant="success">Success Button</x-button>
                    <x-button variant="danger">Danger Button</x-button>
                    <x-button variant="outline">Outline Button</x-button>
                    <x-button variant="link">Link Button</x-button>
                </div>
                
                <div class="mt-4 flex flex-wrap gap-4">
                    <x-button variant="primary" size="sm">Small</x-button>
                    <x-button variant="primary" size="md">Medium</x-button>
                    <x-button variant="primary" size="lg">Large</x-button>
                </div>
            </x-card>

            <!-- Status Badges Section -->
            <x-card title="Status Badges">
                <div class="flex flex-wrap gap-4">
                    <x-status-badge status="paid" />
                    <x-status-badge status="pending" />
                    <x-status-badge status="overdue" />
                    <x-status-badge status="draft" />
                </div>
            </x-card>

            <!-- Inputs Section -->
            <x-card title="Input Fields">
                <div class="space-y-4">
                    <x-input 
                        name="name" 
                        label="Name"
                        placeholder="Enter your name"
                        :required="true"
                    />
                    
                    <x-input 
                        type="email" 
                        name="email" 
                        label="Email"
                        placeholder="Enter your email"
                    />
                    
                    <x-input 
                        type="password" 
                        name="password" 
                        label="Password"
                        placeholder="Enter password"
                    />
                    
                    <x-select 
                        name="status" 
                        label="Status"
                        :options="[
                            'paid' => 'Paid',
                            'pending' => 'Pending',
                            'overdue' => 'Overdue'
                        ]"
                        placeholder="Select status"
                    />
                    
                    <x-textarea 
                        name="notes" 
                        label="Notes"
                        placeholder="Enter notes"
                        :rows="4"
                    />
                </div>
            </x-card>

            <!-- Alerts Section -->
            <x-card title="Alerts">
                <div class="space-y-4">
                    <x-alert type="success">
                        <strong>Success!</strong> Your action was completed successfully.
                    </x-alert>
                    
                    <x-alert type="error">
                        <strong>Error!</strong> Something went wrong. Please try again.
                    </x-alert>
                    
                    <x-alert type="warning">
                        <strong>Warning!</strong> Please review your information carefully.
                    </x-alert>
                    
                    <x-alert type="info">
                        <strong>Info:</strong> This is an informational message.
                    </x-alert>
                </div>
            </x-card>

            <!-- Table Section -->
            <x-card title="Table Example">
                <x-table>
                    <x-slot name="header">
                        <th class="sortable">Invoice Number</th>
                        <th>Client</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </x-slot>
                    
                    <x-slot name="body">
                        <tr>
                            <td>INV-001</td>
                            <td>PT. Example Company</td>
                            <td><x-status-badge status="paid" /></td>
                            <td>$1,500.00</td>
                            <td>
                                <div class="flex gap-2">
                                    <x-button variant="primary" size="sm">View</x-button>
                                    <x-button variant="danger" size="sm">Delete</x-button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>INV-002</td>
                            <td>CV. Sample Business</td>
                            <td><x-status-badge status="pending" /></td>
                            <td>$2,750.00</td>
                            <td>
                                <div class="flex gap-2">
                                    <x-button variant="primary" size="sm">View</x-button>
                                    <x-button variant="danger" size="sm">Delete</x-button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>INV-003</td>
                            <td>UD. Test Corporation</td>
                            <td><x-status-badge status="overdue" /></td>
                            <td>$950.00</td>
                            <td>
                                <div class="flex gap-2">
                                    <x-button variant="primary" size="sm">View</x-button>
                                    <x-button variant="danger" size="sm">Delete</x-button>
                                </div>
                            </td>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>

        </div>
    </div>
</x-app-layout>
