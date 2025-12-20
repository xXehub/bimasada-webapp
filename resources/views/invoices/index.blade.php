<x-layout.app title="Invoice Management">
    <div class="space-y-6">
        
        <!-- Page Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Invoice Management</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Manage and track all your invoices</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <!-- Quick Modal Button -->
                <x-ui.button 
                    variant="success" 
                    x-on:click="$dispatch('open-modal', 'add-invoice')"
                >
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </x-slot>
                    Quick Add
                </x-ui.button>
                
                <x-ui.button variant="primary" href="{{ route('invoices.input') }}">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </x-slot>
                    Input Invoice
                </x-ui.button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-ui.card class="!p-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Invoices</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $invoices->total() }}</p>
                    </div>
                </div>
            </x-ui.card>
            
            <x-ui.card class="!p-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Paid</p>
                        <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $invoices->where('status_pembayaran', 'Lunas')->count() }}</p>
                    </div>
                </div>
            </x-ui.card>
            
            <x-ui.card class="!p-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pending</p>
                        <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $invoices->where('status_pembayaran', 'Belum Lunas')->count() }}</p>
                    </div>
                </div>
            </x-ui.card>
            
            <x-ui.card class="!p-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Installment</p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $invoices->where('status_pembayaran', 'Cicilan')->count() }}</p>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <!-- Filters & Search -->
        <x-ui.card>
            <form method="GET" action="{{ route('invoices.index') }}">
                <div class="flex flex-col lg:flex-row gap-4">
                    <!-- Search -->
                    <div class="flex-1">
                        <x-ui.input 
                            type="text" 
                            name="search" 
                            placeholder="Search by customer name, email, phone..."
                            :value="request('search')"
                        >
                            <x-slot name="icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </x-slot>
                        </x-ui.input>
                    </div>

                    <!-- Status Filter -->
                    <div class="w-full lg:w-48">
                        <select 
                            name="status"
                            class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                        >
                            <option value="">All Status</option>
                            <option value="Lunas" {{ request('status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="Belum Lunas" {{ request('status') == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                            <option value="Cicilan" {{ request('status') == 'Cicilan' ? 'selected' : '' }}>Cicilan</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-2">
                        <x-ui.button variant="primary" type="submit">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                            </x-slot>
                            Filter
                        </x-ui.button>
                        <x-ui.button variant="ghost" href="{{ route('invoices.index') }}">
                            Reset
                        </x-ui.button>
                    </div>
                </div>
            </form>
        </x-ui.card>

        <!-- Invoice Table -->
        <x-ui.card class="!p-0">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-dark-sidebar border-b border-gray-200 dark:border-dark-border">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Invoice #</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                <a href="?sort_by=tanggal_invoice&sort_order={{ request('sort_order') == 'asc' ? 'desc' : 'asc' }}&search={{ request('search') }}&status={{ request('status') }}" class="flex items-center gap-1 hover:text-primary-600">
                                    Date
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                    </svg>
                                </a>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                <a href="?sort_by=total_harga&sort_order={{ request('sort_order') == 'asc' ? 'desc' : 'asc' }}&search={{ request('search') }}&status={{ request('status') }}" class="flex items-center gap-1 hover:text-primary-600">
                                    Amount
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                    </svg>
                                </a>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Due Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Sales</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border">
                        @forelse($invoices as $invoice)
                            <tr class="hover:bg-gray-50 dark:hover:bg-dark-hover transition-colors">
                                <td class="px-4 py-4">
                                    <span class="font-mono text-sm font-semibold text-primary-600 dark:text-primary-400">
                                        {{ $invoice->invoice_number ?? 'INV-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="text-gray-900 dark:text-white">
                                        {{ $invoice->tanggal_invoice->format('d M Y') }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-dark-hover flex items-center justify-center">
                                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">
                                                {{ strtoupper(substr($invoice->nama_pelanggan, 0, 2)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $invoice->nama_pelanggan }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $invoice->email ?? $invoice->no_telp }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    @php
                                        $badgeVariants = [
                                            'Lunas' => 'success',
                                            'Belum Lunas' => 'warning',
                                            'Cicilan' => 'info'
                                        ];
                                    @endphp
                                    <x-ui.badge :variant="$badgeVariants[$invoice->status_pembayaran] ?? 'secondary'" :dot="true">
                                        {{ $invoice->status_pembayaran }}
                                    </x-ui.badge>
                                </td>
                                <td class="px-4 py-4">
                                    <div>
                                        <span class="text-gray-900 dark:text-white">{{ $invoice->jatuh_tempo->format('d M Y') }}</span>
                                        @if($invoice->jatuh_tempo->isPast() && $invoice->status_pembayaran != 'Lunas')
                                            <x-ui.badge variant="danger" size="sm" class="ml-1">Overdue</x-ui.badge>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-gray-700 dark:text-gray-300">
                                    {{ $invoice->sales->nama_sales ?? '-' }}
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-center gap-1">
                                        <a 
                                            href="{{ route('invoices.show', $invoice) }}"
                                            class="p-2 rounded-lg text-gray-500 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors"
                                            title="View"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <a 
                                            href="{{ route('invoices.edit', $invoice) }}"
                                            class="p-2 rounded-lg text-gray-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors"
                                            title="Edit"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        @can('delete-invoices')
                                            <button 
                                                type="button"
                                                x-data
                                                x-on:click="$dispatch('open-modal', 'delete-invoice-{{ $invoice->id }}')"
                                                class="p-2 rounded-lg text-gray-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                                                title="Delete"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-dark-hover flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <p class="text-gray-500 dark:text-gray-400 mb-4">No invoices found</p>
                                        <x-ui.button variant="primary" href="{{ route('invoices.input') }}" size="sm">
                                            Create your first invoice
                                        </x-ui.button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($invoices->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 dark:border-dark-border">
                    {{ $invoices->withQueryString()->links() }}
                </div>
            @endif
        </x-ui.card>

    </div>

    <!-- Add Invoice Modal -->
    @include('invoices.partials.add-invoice-modal', ['salesList' => $salesList ?? []])
    
    <!-- Delete Confirmation Modals -->
    @foreach($invoices as $invoice)
        @can('delete-invoices')
            <x-ui.modal name="delete-invoice-{{ $invoice->id }}" maxWidth="sm">
                <div class="p-6 text-center">
                    <div class="mx-auto w-14 h-14 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Delete Invoice?</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                        Are you sure you want to delete invoice <strong>{{ $invoice->invoice_number ?? 'INV-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</strong>?
                        This action cannot be undone.
                    </p>
                    <div class="flex items-center justify-center gap-3">
                        <x-ui.button variant="secondary" x-on:click="close()">Cancel</x-ui.button>
                        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <x-ui.button type="submit" variant="danger">Delete</x-ui.button>
                        </form>
                    </div>
                </div>
            </x-ui.modal>
        @endcan
    @endforeach
</x-layout.app>
