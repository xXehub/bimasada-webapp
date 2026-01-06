<x-layout.app title="Invoice Details">
    <div class="space-y-6">
        
        <!-- Page Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('invoices.index') }}" class="p-2 rounded-xl bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border hover:bg-gray-50 dark:hover:bg-dark-hover transition-colors">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Invoice Details</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $invoice->invoice_number ?? 'INV-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
            <div class="flex gap-3 flex-wrap">
                {{-- Marketing Manager: Review Actions --}}
                @can('review-invoices')
                    @if($invoice->status_pembayaran !== 'Lunas' && $invoice->status_pembayaran !== 'Revisi')
                        <x-ui.button variant="warning" onclick="requestRevision()">
                            <x-slot name="icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </x-slot>
                            Minta Revisi
                        </x-ui.button>
                    @endif
                @endcan

                @can('edit-invoices')
                    <x-ui.button variant="primary" href="{{ route('invoices.edit', $invoice->id) }}">
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </x-slot>
                        Edit Invoice
                    </x-ui.button>
                @endcan
                
                {{-- Sales: Create Kuitansi when invoice is not fully paid --}}
                @if($invoice->status_pembayaran !== 'Lunas' && $invoice->remaining_amount > 0)
                    @can('create-kuitansi')
                        <x-ui.button variant="success" href="{{ route('kuitansis.createFromInvoice', $invoice->id) }}">
                            <x-slot name="icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </x-slot>
                            Buat Kuitansi
                        </x-ui.button>
                    @endcan
                @endif
                
                <x-ui.button variant="outline" onclick="printInvoice()">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                    </x-slot>
                    Print
                </x-ui.button>
            </div>
        </div>

        {{-- Revision Alert Banner --}}
        @if($invoice->status_pembayaran === 'Revisi')
        <div class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-orange-800 dark:text-orange-200">Invoice Memerlukan Revisi</h3>
                    <p class="text-sm text-orange-700 dark:text-orange-300 mt-1">
                        Marketing Manager telah meminta revisi untuk invoice ini. Silakan periksa dan perbaiki data invoice, kemudian update kembali.
                    </p>
                </div>
                @can('edit-invoices')
                <a href="{{ route('invoices.edit', $invoice->id) }}" class="flex-shrink-0">
                    <x-ui.button variant="warning" size="sm">
                        Edit Invoice
                    </x-ui.button>
                </a>
                @endcan
            </div>
        </div>
        @endif

        <!-- Invoice Summary Card -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Invoice Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Header Card -->
                <x-ui.card class="!p-0 overflow-hidden">
                    <!-- Status Banner -->
                    @php
                        $statusColors = [
                            'Lunas' => 'from-emerald-500 to-emerald-600',
                            'Belum Lunas' => 'from-amber-500 to-amber-600',
                            'Cicilan' => 'from-blue-500 to-blue-600',
                            'Revisi' => 'from-orange-500 to-orange-600'
                        ];
                        $statusBg = $statusColors[$invoice->status_pembayaran] ?? 'from-gray-500 to-gray-600';
                    @endphp
                    <div class="bg-gradient-to-r {{ $statusBg }} px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-white/80 text-sm">Invoice Number</p>
                                    <p class="text-white font-bold text-xl">{{ $invoice->invoice_number ?? 'INV-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-white/80 text-sm">Status</p>
                                <p class="text-white font-bold text-lg">{{ $invoice->status_pembayaran }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Invoice Date</p>
                                <p class="font-semibold text-gray-900 dark:text-white mt-1">{{ $invoice->tanggal_invoice->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Due Date</p>
                                <p class="font-semibold mt-1 {{ $invoice->jatuh_tempo->isPast() && $invoice->status_pembayaran !== 'Lunas' ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white' }}">
                                    {{ $invoice->jatuh_tempo->format('d M Y') }}
                                    @if($invoice->jatuh_tempo->isPast() && $invoice->status_pembayaran !== 'Lunas')
                                        <span class="text-xs block text-red-500">Overdue!</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Sales Person</p>
                                <p class="font-semibold text-gray-900 dark:text-white mt-1">{{ $invoice->sales->nama_sales ?? '-' }}</p>
                            </div>
                            @if($invoice->no_kontrak)
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">No. Kontrak</p>
                                <p class="font-semibold text-gray-900 dark:text-white mt-1">{{ $invoice->no_kontrak }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </x-ui.card>

                <!-- Invoice Items -->
                <x-ui.card>
                    <x-slot name="header">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Invoice Items</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $invoice->detailInvoices->count() }} item(s)</p>
                            </div>
                        </div>
                    </x-slot>

                    @if($invoice->detailInvoices->count() > 0)
                        <div class="overflow-x-auto -mx-6 -mb-6">
                            <table class="w-full">
                                <thead class="bg-gray-50 dark:bg-dark-sidebar border-y border-gray-200 dark:border-dark-border">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider w-12">#</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Item / Kuitansi ID</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Qty</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Unit Price</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-dark-border">
                                    @foreach($invoice->detailInvoices as $index => $detail)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-dark-hover transition-colors">
                                        <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $index + 1 }}</td>
                                        <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $detail->id_kuitansi }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-white text-right">{{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-white text-right">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                        <td class="px-4 py-4 text-sm font-semibold text-gray-900 dark:text-white text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50 dark:bg-dark-sidebar border-t-2 border-gray-300 dark:border-dark-border">
                                    <tr>
                                        <td colspan="4" class="px-4 py-4 text-right text-sm font-bold text-gray-900 dark:text-white uppercase">Total Amount:</td>
                                        <td class="px-4 py-4 text-right text-lg font-bold text-primary-600 dark:text-primary-400">Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-dark-hover mx-auto flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400">No invoice items</p>
                        </div>
                    @endif
                </x-ui.card>

                <!-- Notes Section -->
                @if($invoice->keterangan)
                <x-ui.card>
                    <x-slot name="header">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-dark-hover flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Additional Notes</h3>
                        </div>
                    </x-slot>
                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $invoice->keterangan }}</p>
                </x-ui.card>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Total Amount Card -->
                <x-ui.card class="bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/20 dark:to-primary-800/20 border-primary-200 dark:border-primary-800">
                    <div class="text-center">
                        <p class="text-sm text-primary-600 dark:text-primary-400 font-medium">Total Amount</p>
                        <p class="text-3xl font-bold text-primary-700 dark:text-primary-300 mt-2">
                            Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}
                        </p>
                        <div class="mt-4 pt-4 border-t border-primary-200 dark:border-primary-700">
                            @php
                                $badgeVariants = [
                                    'Lunas' => 'success',
                                    'Belum Lunas' => 'warning',
                                    'Cicilan' => 'info'
                                ];
                            @endphp
                            <x-ui.badge :variant="$badgeVariants[$invoice->status_pembayaran] ?? 'secondary'" :dot="true" size="lg">
                                {{ $invoice->status_pembayaran }}
                            </x-ui.badge>
                        </div>
                    </div>
                </x-ui.card>

                <!-- Payment Progress Card -->
                <x-ui.card>
                    <x-slot name="header">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Progress Pembayaran</h3>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $invoice->kuitansis->count() }} kuitansi</span>
                        </div>
                    </x-slot>
                    
                    @php
                        $totalPaid = $invoice->total_paid;
                        $remainingAmount = $invoice->remaining_amount;
                        $percentage = $invoice->total_harga > 0 ? min(100, ($totalPaid / $invoice->total_harga) * 100) : 0;
                    @endphp
                    
                    <div class="space-y-4">
                        <!-- Progress Bar -->
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600 dark:text-gray-400">Terbayar</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ number_format($percentage, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                                <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 h-3 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl">
                                <p class="text-xs text-emerald-600 dark:text-emerald-400">Sudah Dibayar</p>
                                <p class="font-bold text-emerald-700 dark:text-emerald-300 text-sm mt-1">Rp {{ number_format($totalPaid, 0, ',', '.') }}</p>
                            </div>
                            <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl">
                                <p class="text-xs text-amber-600 dark:text-amber-400">Sisa Tagihan</p>
                                <p class="font-bold text-amber-700 dark:text-amber-300 text-sm mt-1">Rp {{ number_format($remainingAmount, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Create Kuitansi Button -->
                        @if($remainingAmount > 0)
                            @can('create-kuitansi')
                            <a href="{{ route('kuitansis.createFromInvoice', $invoice->id) }}" class="block w-full py-2 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-center rounded-xl text-sm font-medium transition-colors">
                                + Buat Kuitansi Pembayaran
                            </a>
                            @endcan
                        @else
                        <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl text-center">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm font-medium text-emerald-700 dark:text-emerald-300">Invoice Lunas</p>
                        </div>
                        @endif
                    </div>
                </x-ui.card>

                <!-- PKS Info Card (if linked) -->
                @if($invoice->pks)
                <x-ui.card class="border-2 border-primary-200 dark:border-primary-800">
                    <x-slot name="header">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Terhubung ke PKS</h3>
                        </div>
                    </x-slot>
                    
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">No. PKS</p>
                            <a href="{{ route('surat-perjanjians.show', $invoice->pks->id) }}" class="font-semibold text-primary-600 dark:text-primary-400 hover:underline">
                                {{ $invoice->pks->no_surat }}
                            </a>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Nilai Kontrak</p>
                            <p class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($invoice->pks->nilai_kontrak, 0, ',', '.') }}</p>
                        </div>
                        <a href="{{ route('surat-perjanjians.show', $invoice->pks->id) }}" class="inline-flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400 hover:underline">
                            Lihat PKS
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </div>
                </x-ui.card>
                @endif

                <!-- Customer Info Card -->
                <x-ui.card>
                    <x-slot name="header">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Customer</h3>
                        </div>
                    </x-slot>
                    
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-dark-hover flex items-center justify-center">
                                <span class="text-lg font-bold text-gray-600 dark:text-gray-300">
                                    {{ strtoupper(substr($invoice->nama_pelanggan, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $invoice->nama_pelanggan }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Customer</p>
                            </div>
                        </div>
                        
                        @if($invoice->email)
                        <div class="flex items-center gap-3 text-sm">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">{{ $invoice->email }}</span>
                        </div>
                        @endif
                        
                        @if($invoice->no_telp)
                        <div class="flex items-center gap-3 text-sm">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">{{ $invoice->no_telp }}</span>
                        </div>
                        @endif
                        
                        @if($invoice->alamat)
                        <div class="flex items-start gap-3 text-sm">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">{{ $invoice->alamat }}</span>
                        </div>
                        @endif
                    </div>
                </x-ui.card>

                <!-- Related Receipts -->
                @if($invoice->kuitansis && $invoice->kuitansis->count() > 0)
                <x-ui.card>
                    <x-slot name="header">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Receipts</h3>
                        </div>
                    </x-slot>
                    
                    <div class="space-y-3">
                        @foreach($invoice->kuitansis as $kuitansi)
                        <div class="p-3 rounded-xl bg-gray-50 dark:bg-dark-hover border border-gray-200 dark:border-dark-border">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-medium text-gray-900 dark:text-white">Kuitansi #{{ $kuitansi->id }}</span>
                                @php
                                    $paymentColors = [
                                        'Cash' => 'success',
                                        'Transfer' => 'info',
                                    ];
                                @endphp
                                <x-ui.badge :variant="$paymentColors[$kuitansi->invoice_pembayaran] ?? 'secondary'" size="sm">
                                    {{ $kuitansi->invoice_pembayaran }}
                                </x-ui.badge>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $kuitansi->tanggal_kuitansi->format('d M Y') }}</p>
                            <p class="font-bold text-primary-600 dark:text-primary-400 mt-1">Rp {{ number_format($kuitansi->total_bayar, 0, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>
                </x-ui.card>
                @endif

                <!-- Quick Actions -->
                <x-ui.card>
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        @can('edit-invoices')
                        <a href="{{ route('invoices.edit', $invoice->id) }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-dark-hover transition-colors group">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <span class="text-gray-700 dark:text-gray-300 font-medium">Edit Invoice</span>
                        </a>
                        @endcan
                        
                        <button type="button" class="w-full flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-dark-hover transition-colors group">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </div>
                            <span class="text-gray-700 dark:text-gray-300 font-medium">Download PDF</span>
                        </button>
                        
                        <button type="button" class="w-full flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-dark-hover transition-colors group">
                            <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span class="text-gray-700 dark:text-gray-300 font-medium">Send Email</span>
                        </button>
                    </div>
                </x-ui.card>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function printInvoice() {
            window.print();
        }

        function requestRevision() {
            if (confirm('Apakah Anda yakin ingin meminta revisi invoice ini? Invoice akan dikembalikan ke Sales untuk diperbaiki.')) {
                fetch('{{ route("invoices.requestRevision", $invoice->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'Gagal meminta revisi');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memproses permintaan');
                });
            }
        }
    </script>
    @endpush
</x-layout.app>
