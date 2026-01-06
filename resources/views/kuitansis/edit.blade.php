<x-layout.app title="Edit Kuitansi">
    <div x-data="kuitansiEditForm()" class="space-y-6">
        
        <!-- Invoice Data for Alpine.js -->
        @php
            $invoiceData = $invoices->mapWithKeys(function($invoice) {
                return [$invoice->id => [
                    'nama_pelanggan' => $invoice->nama_pelanggan,
                    'alamat' => $invoice->alamat ?? '',
                    'no_telp' => $invoice->no_telp ?? '',
                    'total' => $invoice->total_harga ?? 0,
                    'id_sales' => $invoice->id_sales,
                ]];
            })->toJson();
        @endphp
        
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/25">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Kuitansi</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-0.5">{{ $kuitansi->no_kuitansi ?? 'KTN-' . str_pad($kuitansi->id, 4, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
            <x-ui.button variant="secondary" href="{{ route('kuitansis.show', $kuitansi->id) }}">
                <x-slot name="icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </x-slot>
                Kembali
            </x-ui.button>
        </div>

        <!-- Error Summary -->
        @if ($errors->any())
            <x-ui.alert type="error" :autoDismiss="false">
                <strong class="font-semibold">Perbaiki kesalahan berikut:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-ui.alert>
        @endif

        <form action="{{ route('kuitansis.update', $kuitansi->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

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
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kuitansi Number -->
                    <x-ui.input 
                        type="text" 
                        name="no_kuitansi" 
                        label="No. Kuitansi" 
                        :value="old('no_kuitansi', $kuitansi->no_kuitansi)" 
                        required 
                        readonly
                    />

                    <!-- Date -->
                    <x-ui.input 
                        type="date" 
                        name="tanggal_kuitansi" 
                        label="Tanggal Kuitansi" 
                        :value="old('tanggal_kuitansi', $kuitansi->tanggal_kuitansi->format('Y-m-d'))" 
                        required 
                    />

                    <!-- Related Invoice -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Invoice Terkait
                        </label>
                        <select 
                            name="id_invoice" 
                            x-model="selectedInvoice"
                            @change="onInvoiceChange()"
                            class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                        >
                            <option value="">-- Tanpa Invoice --</option>
                            @foreach($invoices as $invoice)
                                <option value="{{ $invoice->id }}" {{ old('id_invoice', $kuitansi->id_invoice) == $invoice->id ? 'selected' : '' }}>
                                    {{ $invoice->no_invoice ?? 'INV-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }} - {{ $invoice->nama_pelanggan }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pilih invoice untuk auto-fill data pelanggan</p>
                    </div>

                    <!-- Sales Person -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Sales Person <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="id_sales" 
                            x-model="selectedSales"
                            required
                            class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                        >
                            <option value="">Pilih Sales</option>
                            @foreach($salesList as $sales)
                                <option value="{{ $sales->id }}" {{ old('id_sales', $kuitansi->id_sales) == $sales->id ? 'selected' : '' }}>
                                    {{ $sales->id_sales ?? '' }} - {{ $sales->nama_sales }}
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
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Pelanggan</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Data pelanggan dan kontak
                                <span x-show="selectedInvoice" class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    Data dari Invoice
                                </span>
                            </p>
                        </div>
                    </div>
                </x-slot>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Customer Name -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Nama Pelanggan <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="nama_pelanggan" 
                            x-model="customerName"
                            :readonly="selectedInvoice !== ''"
                            :class="selectedInvoice !== '' ? 'bg-gray-100 dark:bg-gray-700 cursor-not-allowed' : 'bg-white dark:bg-dark-hover'"
                            placeholder="Masukkan nama pelanggan" 
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                        />
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Alamat
                        </label>
                        <textarea 
                            name="alamat" 
                            rows="3" 
                            x-model="customerAddress"
                            :readonly="selectedInvoice !== ''"
                            :class="selectedInvoice !== '' ? 'bg-gray-100 dark:bg-gray-700 cursor-not-allowed' : 'bg-white dark:bg-dark-hover'"
                            placeholder="Masukkan alamat pelanggan" 
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none"
                        ></textarea>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            No. Telepon
                        </label>
                        <input 
                            type="text" 
                            name="no_telp" 
                            x-model="customerPhone"
                            :readonly="selectedInvoice !== ''"
                            :class="selectedInvoice !== '' ? 'bg-gray-100 dark:bg-gray-700 cursor-not-allowed' : 'bg-white dark:bg-dark-hover'"
                            placeholder="08xx-xxxx-xxxx" 
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                        />
                    </div>
                </div>
            </x-ui.card>

            <!-- Payment Information Card -->
            <x-ui.card>
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Pembayaran</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Detail pembayaran dan status</p>
                        </div>
                    </div>
                </x-slot>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
                            <option value="">Pilih Metode</option>
                            <option value="Cash" {{ old('invoice_pembayaran', $kuitansi->invoice_pembayaran) == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="Transfer" {{ old('invoice_pembayaran', $kuitansi->invoice_pembayaran) == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                            <option value="Ciro" {{ old('invoice_pembayaran', $kuitansi->invoice_pembayaran) == 'Ciro' ? 'selected' : '' }}>Ciro</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="status_kuitansi" 
                            required
                            class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                        >
                            <option value="Draft" {{ old('status_kuitansi', $kuitansi->status_kuitansi) == 'Draft' ? 'selected' : '' }}>Draft</option>
                            <option value="Terkirim" {{ old('status_kuitansi', $kuitansi->status_kuitansi) == 'Terkirim' ? 'selected' : '' }}>Terkirim</option>
                            <option value="Lunas" {{ old('status_kuitansi', $kuitansi->status_kuitansi) == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="Batal" {{ old('status_kuitansi', $kuitansi->status_kuitansi) == 'Batal' ? 'selected' : '' }}>Batal</option>
                        </select>
                    </div>

                    <!-- Total Amount -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Total Bayar <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 font-semibold text-sm">Rp</div>
                            <input 
                                type="text" 
                                x-model="totalDisplay"
                                @input="formatCurrency($event)" 
                                @blur="updateTotal()"
                                placeholder="0" 
                                required
                                class="w-full pl-12 pr-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                            />
                            <input type="hidden" name="total_bayar" x-model="totalBayar">
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <!-- Notes Card -->
            <x-ui.card>
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Keterangan</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Catatan atau informasi tambahan (opsional)</p>
                        </div>
                    </div>
                </x-slot>
                
                <div>
                    <textarea 
                        name="keterangan" 
                        rows="4" 
                        placeholder="Tambahkan catatan atau keterangan (opsional)"
                        class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none"
                    >{{ old('keterangan', $kuitansi->keterangan) }}</textarea>
                </div>
            </x-ui.card>

            <!-- Detail Items Card -->
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
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Item</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Daftar item pembayaran (opsional)</p>
                            </div>
                        </div>
                        <x-ui.button type="button" variant="success" size="sm" x-on:click="addItem">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </x-slot>
                            Tambah Item
                        </x-ui.button>
                    </div>
                </x-slot>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-border">
                        <thead class="bg-gray-50 dark:bg-dark-hover">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Item</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider w-24">Jumlah</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider w-40">Harga Satuan</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider w-36">Subtotal</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider w-16">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-dark-card divide-y divide-gray-200 dark:divide-dark-border">
                            <template x-for="(item, index) in items" :key="index">
                                <tr>
                                    <td class="px-4 py-3">
                                        <input type="hidden" :name="'items['+index+'][id]'" x-model="item.id">
                                        <input type="text" :name="'items['+index+'][nama_item]'" x-model="item.nama_item"
                                            class="w-full px-3 py-2 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-lg text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                            placeholder="Nama item">
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="number" :name="'items['+index+'][jumlah]'" x-model="item.jumlah"
                                            @input="calculateSubtotal(index)"
                                            class="w-full px-3 py-2 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-lg text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                            min="1">
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 text-sm">Rp</span>
                                            <input type="text" x-model="item.harga_display"
                                                @input="formatItemPrice($event, index)" @blur="updateItemPrice(index)"
                                                class="w-full pl-10 pr-3 py-2 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-lg text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                                placeholder="0">
                                            <input type="hidden" :name="'items['+index+'][harga_satuan]'" x-model="item.harga_satuan">
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white" x-text="'Rp ' + formatNumber(item.subtotal)"></span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button type="button" @click="removeItem(index)"
                                            class="inline-flex items-center p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="items.length === 0">
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    Belum ada item. Klik "Tambah Item" untuk menambahkan.
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-gray-50 dark:bg-dark-hover" x-show="items.length > 0">
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-white">Total:</td>
                                <td class="px-4 py-3 font-bold text-primary-600 dark:text-primary-400 text-lg" x-text="'Rp ' + formatNumber(calculateGrandTotal())"></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-ui.card>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-end gap-4 p-6 bg-white dark:bg-dark-card rounded-2xl border border-gray-200 dark:border-dark-border shadow-soft">
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <x-ui.button variant="secondary" type="button" href="{{ route('kuitansis.show', $kuitansi->id) }}">
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </x-slot>
                        Batal
                    </x-ui.button>
                    <x-ui.button variant="primary" type="submit">
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </x-slot>
                        Simpan Perubahan
                    </x-ui.button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function kuitansiEditForm() {
            return {
                // Invoice data from server
                invoiceData: {!! $invoiceData !!},
                selectedInvoice: '{{ old('id_invoice', $kuitansi->id_invoice ?? '') }}',
                selectedSales: '{{ old('id_sales', $kuitansi->id_sales ?? '') }}',
                
                // Customer fields
                customerName: {!! json_encode(old('nama_pelanggan', $kuitansi->nama_pelanggan ?? '')) !!},
                customerAddress: {!! json_encode(old('alamat', $kuitansi->alamat ?? '')) !!},
                customerPhone: {!! json_encode(old('no_telp', $kuitansi->no_telp ?? '')) !!},
                
                // Payment
                totalBayar: {{ old('total_bayar', $kuitansi->total_bayar ?? 0) }},
                totalDisplay: '',
                
                // Items from existing kuitansi
                items: [
                    @foreach($kuitansi->detailKuitansis as $detail)
                    {
                        id: {{ $detail->id }},
                        nama_item: {!! json_encode($detail->id_txtKtl ?? '') !!},
                        jumlah: {{ $detail->jumlah ?? 1 }},
                        harga_satuan: {{ $detail->harga_satuan ?? 0 }},
                        harga_display: '{{ number_format($detail->harga_satuan ?? 0, 0, ',', '.') }}',
                        subtotal: {{ $detail->subtotal ?? 0 }}
                    },
                    @endforeach
                ],
                
                init() {
                    // Format initial total display
                    if (this.totalBayar > 0) {
                        this.totalDisplay = this.formatNumber(this.totalBayar);
                    }
                },
                
                onInvoiceChange() {
                    if (this.selectedInvoice && this.invoiceData[this.selectedInvoice]) {
                        const invoice = this.invoiceData[this.selectedInvoice];
                        this.customerName = invoice.nama_pelanggan || '';
                        this.customerAddress = invoice.alamat || '';
                        this.customerPhone = invoice.no_telp || '';
                        this.selectedSales = invoice.id_sales || '';
                        
                        // Set total from invoice
                        this.totalBayar = invoice.total || 0;
                        this.totalDisplay = this.totalBayar > 0 ? this.formatNumber(this.totalBayar) : '';
                    } else {
                        // Clear fields when "Tanpa Invoice" is selected
                        this.customerName = '';
                        this.customerAddress = '';
                        this.customerPhone = '';
                        this.totalBayar = 0;
                        this.totalDisplay = '';
                    }
                },

                formatCurrency(event) {
                    let value = event.target.value.replace(/[^\d]/g, '');
                    if (value) {
                        this.totalDisplay = parseInt(value).toLocaleString('id-ID');
                    } else {
                        this.totalDisplay = '';
                    }
                },

                updateTotal() {
                    let value = this.totalDisplay.replace(/[^\d]/g, '');
                    this.totalBayar = value ? parseInt(value) : 0;
                },

                addItem() {
                    this.items.push({
                        id: null,
                        nama_item: '',
                        jumlah: 1,
                        harga_satuan: 0,
                        harga_display: '',
                        subtotal: 0
                    });
                },

                removeItem(index) {
                    this.items.splice(index, 1);
                    this.syncTotalFromItems();
                },

                formatItemPrice(event, index) {
                    let value = event.target.value.replace(/[^\d]/g, '');
                    if (value) {
                        this.items[index].harga_display = parseInt(value).toLocaleString('id-ID');
                    } else {
                        this.items[index].harga_display = '';
                    }
                },

                updateItemPrice(index) {
                    let value = this.items[index].harga_display.replace(/[^\d]/g, '');
                    this.items[index].harga_satuan = value ? parseInt(value) : 0;
                    this.calculateSubtotal(index);
                },

                calculateSubtotal(index) {
                    const item = this.items[index];
                    item.subtotal = item.jumlah * item.harga_satuan;
                    this.syncTotalFromItems();
                },

                calculateGrandTotal() {
                    return this.items.reduce((sum, item) => sum + item.subtotal, 0);
                },

                syncTotalFromItems() {
                    if (this.items.length > 0) {
                        const total = this.calculateGrandTotal();
                        this.totalBayar = total;
                        this.totalDisplay = this.formatNumber(total);
                    }
                },

                formatNumber(num) {
                    return parseInt(num).toLocaleString('id-ID');
                }
            }
        }
    </script>
    @endpush
</x-layout.app>
