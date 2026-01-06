<x-layout.app title="Buat Kuitansi dari Invoice">
    <div class="space-y-6">
        
        <!-- Page Header with Breadcrumb -->
        <div class="flex flex-col gap-4">
            <!-- Breadcrumb -->
            <nav class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('invoices.index') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Invoice</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <a href="{{ route('invoices.show', $invoice->id) }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">{{ $invoice->invoice_number }}</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-900 dark:text-white font-medium">Buat Kuitansi</span>
            </nav>

            <!-- Title & Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/25">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Buat Kuitansi dari Invoice</h1>
                        <p class="text-gray-500 dark:text-gray-400 mt-0.5">Kuitansi sebagai tanda terima pembayaran</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <x-ui.button variant="secondary" href="{{ route('invoices.show', $invoice->id) }}" size="sm">
                        <x-slot name="icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                        </x-slot>
                        Kembali ke Invoice
                    </x-ui.button>
                </div>
            </div>
        </div>

        <!-- Invoice Info Card -->
        <x-ui.card class="border-2 border-emerald-200 dark:border-emerald-800 bg-emerald-50/50 dark:bg-emerald-900/20">
            <x-slot name="header">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Invoice</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Data dari Invoice terkait</p>
                    </div>
                </div>
            </x-slot>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-3 bg-white dark:bg-dark-card rounded-xl">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">No. Invoice</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ $invoice->invoice_number }}</p>
                </div>
                <div class="p-3 bg-white dark:bg-dark-card rounded-xl">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Pelanggan</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ $invoice->nama_pelanggan }}</p>
                </div>
                <div class="p-3 bg-white dark:bg-dark-card rounded-xl">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total Invoice</p>
                    <p class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-white dark:bg-dark-card rounded-xl">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Status</p>
                    @php
                        $statusVariant = match($invoice->status_pembayaran) {
                            'Lunas' => 'success',
                            'Cicilan' => 'warning',
                            default => 'info'
                        };
                    @endphp
                    <x-ui.badge :type="$statusVariant">{{ $invoice->status_pembayaran }}</x-ui.badge>
                </div>
            </div>
        </x-ui.card>

        <!-- Error Summary -->
        @if ($errors->any())
            <x-ui.alert type="error" :autoDismiss="false">
                <strong class="font-semibold">Harap perbaiki kesalahan berikut:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-ui.alert>
        @endif

        <form id="kuitansiForm" action="{{ route('kuitansis.storeFromInvoice', $invoice->id) }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="id_invoice" value="{{ $invoice->id }}">
            <input type="hidden" name="total_bayar" value="{{ $remainingAmount }}">

            <!-- Kuitansi Information Card -->
            <x-ui.card>
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Kuitansi</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Detail dasar kuitansi</p>
                        </div>
                    </div>
                </x-slot>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Kuitansi Number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Nomor Kuitansi <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-2">
                            <input 
                                type="text" 
                                name="no_kuitansi" 
                                id="no_kuitansi"
                                class="flex-1 px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                value="{{ old('no_kuitansi', $noKuitansi) }}"
                                required
                            >
                            <button type="button" id="generateNumber" class="px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Kuitansi Date -->
                    <x-ui.input 
                        type="date" 
                        name="tanggal_kuitansi" 
                        label="Tanggal Kuitansi" 
                        :value="old('tanggal_kuitansi', date('Y-m-d'))" 
                        required 
                    />

                    <!-- Payment Method -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Metode Pembayaran <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="invoice_pembayaran" 
                            required
                            class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                        >
                            <option value="Transfer" {{ old('invoice_pembayaran', 'Transfer') == 'Transfer' ? 'selected' : '' }}>Transfer Bank</option>
                            <option value="Cash" {{ old('invoice_pembayaran') == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="Ciro" {{ old('invoice_pembayaran') == 'Ciro' ? 'selected' : '' }}>Ciro / Giro</option>
                        </select>
                    </div>

                    <!-- Status - Hidden, always Lunas -->
                    <input type="hidden" name="status_kuitansi" value="Lunas">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Status Kuitansi
                        </label>
                        <div class="flex items-center gap-2 px-4 py-2.5 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-xl">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-semibold text-green-700 dark:text-green-300">Lunas</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Kuitansi sebagai tanda terima pembayaran</p>
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
                            <option value="">Pilih Sales</option>
                            @foreach($salesList as $s)
                                <option value="{{ $s->id }}" {{ old('id_sales', $prefillData['id_sales'] ?? '') == $s->id ? 'selected' : '' }}>
                                    {{ $s->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </x-ui.card>

            <!-- Customer Information Card (Pre-filled from Invoice) -->
            <x-ui.card>
                <x-slot name="header">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Pelanggan</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Data terisi otomatis dari Invoice</p>
                            </div>
                        </div>
                        <x-ui.badge type="info">Auto-filled</x-ui.badge>
                    </div>
                </x-slot>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Customer Name -->
                    <div class="md:col-span-2">
                        <x-ui.input 
                            type="text" 
                            name="nama_pelanggan" 
                            label="Nama Pelanggan" 
                            placeholder="Masukkan nama pelanggan" 
                            :value="old('nama_pelanggan', $prefillData['nama_pelanggan'] ?? '')" 
                            required 
                        >
                            <x-slot name="icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </x-slot>
                        </x-ui.input>
                    </div>

                    <!-- Phone -->
                    <x-ui.input 
                        type="text" 
                        name="no_telp" 
                        label="Nomor Telepon" 
                        placeholder="08xx-xxxx-xxxx" 
                        :value="old('no_telp', $prefillData['no_telp'] ?? '')" 
                    >
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </x-slot>
                    </x-ui.input>

                    <!-- Address -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Alamat
                        </label>
                        <textarea 
                            name="alamat" 
                            rows="2" 
                            placeholder="Masukkan alamat pelanggan"
                            class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none"
                        >{{ old('alamat', $prefillData['alamat'] ?? '') }}</textarea>
                    </div>
                </div>
            </x-ui.card>

            <!-- Invoice Items Card (Synced from Invoice) -->
            <x-ui.card>
                <x-slot name="header">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Item Pembayaran</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $invoice->detailInvoices->count() }} item(s) dari Invoice</p>
                            </div>
                        </div>
                        <x-ui.badge type="secondary">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Readonly
                        </x-ui.badge>
                    </div>
                </x-slot>
                
                @if($invoice->detailInvoices->count() > 0)
                    <div class="overflow-x-auto -mx-6 -mb-6">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-dark-sidebar border-y border-gray-200 dark:border-dark-border">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider w-12">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Item / Deskripsi</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Qty</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Harga Satuan</th>
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
                        <p class="text-gray-500 dark:text-gray-400">Tidak ada item dalam invoice</p>
                    </div>
                @endif
            </x-ui.card>

            <!-- Total Payment Card (Non-editable) -->
            <x-ui.card class="border-2 border-primary-200 dark:border-primary-800 bg-primary-50/50 dark:bg-primary-900/20">
                <x-slot name="header">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Total Pembayaran</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah yang akan dibayarkan</p>
                            </div>
                        </div>
                        <x-ui.badge type="success">Full Payment</x-ui.badge>
                    </div>
                </x-slot>
                
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-2xl bg-white dark:bg-dark-card shadow-sm flex items-center justify-center">
                                <svg class="w-8 h-8 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Bayar</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($remainingAmount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 rounded-xl bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border">
                        <div class="flex items-start gap-3 text-sm">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="text-gray-600 dark:text-gray-400">
                                <p class="font-medium text-gray-900 dark:text-white">Pembayaran Penuh</p>
                                <p class="mt-1">Kuitansi otomatis menggunakan total sisa tagihan dari invoice. Tidak dapat diubah.</p>
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
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Catatan Tambahan</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Catatan atau keterangan opsional</p>
                        </div>
                    </div>
                </x-slot>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Keterangan
                    </label>
                    <textarea 
                        name="keterangan" 
                        rows="4" 
                        placeholder="Masukkan catatan atau informasi tambahan (opsional)"
                        class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none"
                    >{{ old('keterangan') }}</textarea>
                </div>
            </x-ui.card>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-6 bg-white dark:bg-dark-card rounded-2xl border border-gray-200 dark:border-dark-border shadow-soft">
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                    Kuitansi akan terhubung ke Invoice: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $invoice->invoice_number }}</span>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <x-ui.button variant="secondary" type="button" href="{{ route('invoices.show', $invoice->id) }}">
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </x-slot>
                        Batal
                    </x-ui.button>
                    <x-ui.button variant="primary" type="submit" id="submitBtn">
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </x-slot>
                        Buat Kuitansi
                    </x-ui.button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        // Generate kuitansi number
        document.getElementById('generateNumber').addEventListener('click', function() {
            fetch('{{ route("kuitansis.generateNumber") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('no_kuitansi').value = data.no_kuitansi;
                })
                .catch(error => console.error('Error:', error));
        });

        // Form submission with AJAX
        document.getElementById('kuitansiForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...';

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.message || 'Terjadi kesalahan');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan kuitansi');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    </script>
    @endpush
</x-layout.app>
