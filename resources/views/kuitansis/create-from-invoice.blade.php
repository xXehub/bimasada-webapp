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
                        <p class="text-gray-500 dark:text-gray-400 mt-0.5">Kuitansi akan terhubung dengan Invoice</p>
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

            <!-- Progress Bar -->
            <div class="mt-4 p-4 bg-white dark:bg-dark-card rounded-xl">
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-600 dark:text-gray-400">Progress Pembayaran</span>
                    <span class="font-medium text-gray-900 dark:text-white">
                        Rp {{ number_format($invoice->total_paid, 0, ',', '.') }} / Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}
                    </span>
                </div>
                @php
                    $percentage = $invoice->total_harga > 0 ? min(100, ($invoice->total_paid / $invoice->total_harga) * 100) : 0;
                @endphp
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                    <div class="bg-emerald-600 h-3 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                </div>
                <div class="flex justify-between text-xs mt-2">
                    <span class="text-gray-500 dark:text-gray-400">{{ number_format($percentage, 1) }}% terbayar</span>
                    <span class="text-emerald-600 dark:text-emerald-400 font-medium">
                        Sisa: Rp {{ number_format($remainingAmount, 0, ',', '.') }}
                    </span>
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
                                    {{ $s->id_sales }} - {{ $s->nama_sales }}
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

            <!-- Payment Amount Card -->
            <x-ui.card>
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Jumlah Pembayaran</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total pembayaran kuitansi</p>
                        </div>
                    </div>
                </x-slot>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Total Bayar (Rp) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                                <span class="text-sm font-semibold">Rp</span>
                            </div>
                            <input 
                                type="number" 
                                step="0.01" 
                                name="total_bayar" 
                                id="total_bayar"
                                placeholder="0" 
                                value="{{ old('total_bayar') }}"
                                max="{{ $remainingAmount }}"
                                required
                                class="w-full pl-12 pr-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                            >
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Maksimal: <span class="font-medium text-emerald-600 dark:text-emerald-400">Rp {{ number_format($remainingAmount, 0, ',', '.') }}</span>
                        </p>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="p-4 rounded-xl bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 border border-amber-200 dark:border-amber-800 w-full">
                            <div class="flex items-start gap-3 text-sm text-amber-700 dark:text-amber-300">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <div>
                                    <p class="font-medium">Batas Sisa Tagihan</p>
                                    <p class="mt-1 text-amber-600 dark:text-amber-400">Total pembayaran tidak boleh melebihi sisa tagihan invoice.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick amount buttons -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Quick Amount</label>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" onclick="setAmount({{ $remainingAmount }})" class="px-3 py-1.5 text-sm bg-emerald-100 dark:bg-emerald-900/30 hover:bg-emerald-200 dark:hover:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 rounded-lg transition-colors font-medium">
                                Full (Rp {{ number_format($remainingAmount, 0, ',', '.') }})
                            </button>
                            @if($remainingAmount >= 1000000)
                            <button type="button" onclick="setAmount({{ $remainingAmount / 2 }})" class="px-3 py-1.5 text-sm bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
                                50% (Rp {{ number_format($remainingAmount / 2, 0, ',', '.') }})
                            </button>
                            <button type="button" onclick="setAmount({{ $remainingAmount / 4 }})" class="px-3 py-1.5 text-sm bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
                                25% (Rp {{ number_format($remainingAmount / 4, 0, ',', '.') }})
                            </button>
                            @endif
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

        // Set amount function for quick buttons
        function setAmount(amount) {
            document.getElementById('total_bayar').value = Math.floor(amount);
        }

        // Validate max amount
        document.getElementById('total_bayar').addEventListener('input', function() {
            const maxAmount = {{ $remainingAmount }};
            if (parseFloat(this.value) > maxAmount) {
                this.value = maxAmount;
            }
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
