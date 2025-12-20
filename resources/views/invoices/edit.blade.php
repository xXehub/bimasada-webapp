<x-layout.app title="Edit Invoice - {{ $invoice->no_invoice }}">
    <div x-data="editInvoice()" class="space-y-6">
        
        <!-- Page Header with Breadcrumb -->
        <div class="flex flex-col gap-4">
            <!-- Breadcrumb -->
            <nav class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('invoices.index') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Invoices</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <a href="{{ route('invoices.show', $invoice->id) }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">{{ $invoice->no_invoice }}</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-900 dark:text-white font-medium">Edit</span>
            </nav>

            <!-- Title & Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/25">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Invoice</h1>
                        <p class="text-gray-500 dark:text-gray-400 mt-0.5">
                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ $invoice->no_invoice }}</span>
                            • Last updated {{ $invoice->updated_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <x-ui.button variant="secondary" href="{{ route('invoices.show', $invoice->id) }}" size="sm">
                        <x-slot name="icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </x-slot>
                        View Invoice
                    </x-ui.button>
                    <x-ui.button variant="ghost" href="{{ route('invoices.index') }}" size="sm">
                        <x-slot name="icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </x-slot>
                        Cancel
                    </x-ui.button>
                </div>
            </div>
        </div>

        <!-- Current Status Badge -->
        <div class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 dark:bg-dark-card border border-gray-200 dark:border-dark-border">
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500 dark:text-gray-400">Current Status:</span>
                @php
                    $statusConfig = match($invoice->status_pembayaran) {
                        'Lunas' => ['bg' => 'bg-emerald-100 dark:bg-emerald-900/30', 'text' => 'text-emerald-700 dark:text-emerald-400', 'dot' => 'bg-emerald-500'],
                        'Belum Lunas' => ['bg' => 'bg-amber-100 dark:bg-amber-900/30', 'text' => 'text-amber-700 dark:text-amber-400', 'dot' => 'bg-amber-500'],
                        'Cicilan' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-700 dark:text-blue-400', 'dot' => 'bg-blue-500'],
                        default => ['bg' => 'bg-gray-100 dark:bg-gray-800', 'text' => 'text-gray-700 dark:text-gray-300', 'dot' => 'bg-gray-500'],
                    };
                @endphp
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                    <span class="w-2 h-2 rounded-full {{ $statusConfig['dot'] }}"></span>
                    {{ $invoice->status_pembayaran }}
                </span>
            </div>
            <div class="h-4 w-px bg-gray-300 dark:bg-dark-border"></div>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500 dark:text-gray-400">Total:</span>
                <span class="text-sm font-bold text-gray-900 dark:text-white">Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}</span>
            </div>
            <div class="h-4 w-px bg-gray-300 dark:bg-dark-border"></div>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500 dark:text-gray-400">Items:</span>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $invoice->items->count() }} item(s)</span>
            </div>
        </div>

        <!-- Error Summary -->
        @if ($errors->any())
            <x-ui.alert type="error" :autoDismiss="false">
                <strong class="font-semibold">Please fix the following errors:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-ui.alert>
        @endif

        <form action="{{ route('invoices.update', $invoice->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Invoice Information Card -->
            <x-ui.card>
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Invoice Information</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Basic invoice details and dates</p>
                        </div>
                    </div>
                </x-slot>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Invoice Number (Read-only) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Invoice Number
                        </label>
                        <div class="px-4 py-2.5 bg-gray-50 dark:bg-dark-hover border border-gray-200 dark:border-dark-border rounded-xl text-gray-700 dark:text-gray-300 font-mono">
                            {{ $invoice->no_invoice }}
                        </div>
                    </div>

                    <!-- Invoice Date -->
                    <x-ui.input 
                        type="date" 
                        name="tanggal_invoice" 
                        label="Invoice Date" 
                        :value="old('tanggal_invoice', $invoice->tanggal_invoice->format('Y-m-d'))" 
                        required 
                    />

                    <!-- Due Date -->
                    <x-ui.input 
                        type="date" 
                        name="jatuh_tempo" 
                        label="Due Date" 
                        :value="old('jatuh_tempo', $invoice->jatuh_tempo->format('Y-m-d'))" 
                        required 
                    />

                    <!-- Payment Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Payment Status <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="status_pembayaran" 
                            required
                            class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                        >
                            <option value="">Select Status</option>
                            <option value="Lunas" {{ old('status_pembayaran', $invoice->status_pembayaran) == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="Belum Lunas" {{ old('status_pembayaran', $invoice->status_pembayaran) == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                            <option value="Cicilan" {{ old('status_pembayaran', $invoice->status_pembayaran) == 'Cicilan' ? 'selected' : '' }}>Cicilan</option>
                        </select>
                    </div>

                    <!-- Sales Person -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Sales Person <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="id_sales" 
                            required
                            class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                        >
                            <option value="">Select Sales Person</option>
                            @foreach($sales as $s)
                                <option value="{{ $s->id }}" {{ old('id_sales', $invoice->id_sales) == $s->id ? 'selected' : '' }}>
                                    {{ $s->id_sales }} - {{ $s->nama_sales }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </x-ui.card>

            <!-- Customer Information Card -->
            <x-ui.card>
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Customer Information</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Customer details and contact information</p>
                        </div>
                    </div>
                </x-slot>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Customer Name -->
                    <div class="md:col-span-2">
                        <x-ui.input 
                            type="text" 
                            name="nama_pelanggan" 
                            label="Customer Name" 
                            placeholder="Enter customer name" 
                            :value="old('nama_pelanggan', $invoice->nama_pelanggan)" 
                            required 
                        >
                            <x-slot name="icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </x-slot>
                        </x-ui.input>
                    </div>

                    <!-- Email -->
                    <x-ui.input 
                        type="email" 
                        name="email" 
                        label="Email Address" 
                        placeholder="customer@example.com" 
                        :value="old('email', $invoice->email)" 
                    >
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </x-slot>
                    </x-ui.input>

                    <!-- Phone -->
                    <x-ui.input 
                        type="text" 
                        name="no_telp" 
                        label="Phone Number" 
                        placeholder="08xx-xxxx-xxxx" 
                        :value="old('no_telp', $invoice->no_telp)" 
                    >
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </x-slot>
                    </x-ui.input>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Address
                        </label>
                        <div class="relative">
                            <div class="absolute left-4 top-3 text-gray-400 dark:text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <textarea 
                                name="alamat" 
                                rows="3" 
                                placeholder="Enter customer address"
                                class="w-full pl-12 pr-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none"
                            >{{ old('alamat', $invoice->alamat) }}</textarea>
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <!-- Invoice Items Card (Read-only) -->
            <x-ui.card>
                <x-slot name="header">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Invoice Items</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $invoice->items->count() }} item(s) in this invoice</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-dark-hover text-xs font-medium text-gray-600 dark:text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Read-only
                        </span>
                    </div>
                </x-slot>
                
                <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-dark-border">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-border">
                        <thead class="bg-gray-50 dark:bg-dark-hover">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Product</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Qty</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Unit Price</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-dark-card divide-y divide-gray-200 dark:divide-dark-border">
                            @forelse($invoice->items as $index => $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-dark-hover transition-colors">
                                    <td class="px-4 py-3">
                                        <span class="w-6 h-6 inline-flex items-center justify-center rounded-full bg-gray-100 dark:bg-dark-hover text-xs font-medium text-gray-600 dark:text-gray-400">
                                            {{ $index + 1 }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-gray-900 dark:text-white">{{ $item->nama_barang }}</div>
                                        @if($item->keterangan)
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($item->keterangan, 50) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg bg-gray-100 dark:bg-dark-hover text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ $item->jumlah }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right text-gray-700 dark:text-gray-300 font-medium">
                                        Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-white">
                                        Rp {{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        No items found in this invoice
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gradient-to-r from-primary-50 to-emerald-50 dark:from-primary-900/20 dark:to-emerald-900/20">
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-right font-semibold text-gray-900 dark:text-white">
                                    Grand Total
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <span class="text-lg font-bold text-primary-600 dark:text-primary-400">
                                        Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="mt-4 p-3 rounded-lg bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="text-sm text-amber-700 dark:text-amber-300">
                            <strong>Note:</strong> Invoice items cannot be edited directly. To modify items, please delete this invoice and create a new one via the <a href="{{ route('invoices.input') }}" class="underline hover:no-underline font-medium">Input Invoice</a> page.
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <!-- Total Amount Card -->
            <x-ui.card>
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Total Amount</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Update invoice total if needed</p>
                        </div>
                    </div>
                </x-slot>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-ui.input 
                        type="number" 
                        step="0.01" 
                        name="total_harga" 
                        label="Total Amount (Rp)" 
                        placeholder="0" 
                        :value="old('total_harga', $invoice->total_harga)" 
                        required 
                    >
                        <x-slot name="icon">
                            <span class="text-sm font-semibold">Rp</span>
                        </x-slot>
                    </x-ui.input>
                    
                    <div class="flex items-end">
                        <div class="p-4 rounded-xl bg-gray-50 dark:bg-dark-hover w-full">
                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Calculated from items:</div>
                            <div class="text-lg font-bold text-gray-900 dark:text-white">
                                Rp {{ number_format($invoice->items->sum(function($item) { return $item->jumlah * $item->harga_satuan; }), 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <!-- Additional Notes Card -->
            <x-ui.card>
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Additional Notes</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Optional notes or remarks</p>
                        </div>
                    </div>
                </x-slot>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Notes / Keterangan
                    </label>
                    <textarea 
                        name="keterangan" 
                        rows="4" 
                        placeholder="Enter any additional notes or information (optional)"
                        class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none"
                    >{{ old('keterangan', $invoice->keterangan) }}</textarea>
                </div>
            </x-ui.card>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-6 bg-white dark:bg-dark-card rounded-2xl border border-gray-200 dark:border-dark-border shadow-soft">
                @can('delete-invoices')
                    <button 
                        type="button"
                        @click="showDeleteModal = true"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 font-medium hover:bg-red-100 dark:hover:bg-red-900/30 border border-red-200 dark:border-red-800 transition-all"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete Invoice
                    </button>
                @else
                    <div></div>
                @endcan

                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <x-ui.button variant="secondary" type="button" href="{{ route('invoices.show', $invoice->id) }}">
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </x-slot>
                        Cancel
                    </x-ui.button>
                    <x-ui.button variant="primary" type="submit">
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </x-slot>
                        Update Invoice
                    </x-ui.button>
                </div>
            </div>
        </form>

        <!-- Delete Confirmation Modal -->
        <div 
            x-show="showDeleteModal" 
            x-cloak
            class="fixed inset-0 z-50 overflow-y-auto"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div class="flex min-h-screen items-center justify-center p-4">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showDeleteModal = false"></div>
                
                <!-- Modal Content -->
                <div 
                    class="relative bg-white dark:bg-dark-card rounded-2xl shadow-xl max-w-md w-full p-6 border border-gray-200 dark:border-dark-border"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                >
                    <div class="text-center">
                        <!-- Warning Icon -->
                        <div class="mx-auto w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Delete Invoice</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-2">
                            Are you sure you want to delete invoice <strong class="text-gray-700 dark:text-gray-300">{{ $invoice->no_invoice }}</strong>?
                        </p>
                        <p class="text-sm text-red-500 dark:text-red-400 mb-6">
                            This action cannot be undone. All related items and receipts will also be deleted.
                        </p>
                        
                        <div class="flex gap-3 justify-center">
                            <button 
                                type="button"
                                @click="showDeleteModal = false"
                                class="px-5 py-2.5 rounded-xl bg-gray-100 dark:bg-dark-hover text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors"
                            >
                                Cancel
                            </button>
                            <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button 
                                    type="submit"
                                    class="px-5 py-2.5 rounded-xl bg-red-600 text-white font-medium hover:bg-red-700 transition-colors shadow-lg shadow-red-600/25"
                                >
                                    Yes, Delete Invoice
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function editInvoice() {
            return {
                showDeleteModal: false
            }
        }
    </script>
    @endpush
</x-layout.app>
