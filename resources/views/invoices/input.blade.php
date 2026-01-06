<x-layout.app title="Input Invoice">
    <div x-data="invoiceInput()" class="space-y-6">
        
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Input Invoice</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Create a new invoice with items</p>
            </div>
            <x-ui.button variant="secondary" href="{{ route('invoices.index') }}">
                <x-slot name="icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </x-slot>
                Back to List
            </x-ui.button>
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

        <form action="{{ route('invoices.storeWithItems') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Invoice Header Information -->
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
                            <p class="text-sm text-gray-500 dark:text-gray-400">Basic invoice details</p>
                        </div>
                    </div>
                </x-slot>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Invoice Number -->
                    <x-ui.input 
                        type="text" 
                        name="no_invoice" 
                        label="No. Invoice" 
                        :value="old('no_invoice', $noInvoice)" 
                        required 
                        readonly
                    />

                    <!-- Invoice Date -->
                    <x-ui.input 
                        type="date" 
                        name="tanggal_invoice" 
                        label="Invoice Date" 
                        :value="old('tanggal_invoice', date('Y-m-d'))" 
                        required 
                    />

                    <!-- Due Date -->
                    <x-ui.input 
                        type="date" 
                        name="jatuh_tempo" 
                        label="Due Date" 
                        :value="old('jatuh_tempo')" 
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
                            <option value="Lunas" {{ old('status_pembayaran') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="Belum Lunas" {{ old('status_pembayaran') == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                            <option value="Cicilan" {{ old('status_pembayaran') == 'Cicilan' ? 'selected' : '' }}>Cicilan</option>
                        </select>
                    </div>

                    <!-- Sales Person -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Sales Person <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="id_sales" 
                            required
                            class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                        >
                            <option value="">Select Sales Person</option>
                            @foreach($salesList as $s)
                                <option value="{{ $s->id }}" {{ old('id_sales') == $s->id ? 'selected' : '' }}>
                                    {{ $s->id_sales ?? '' }} - {{ $s->nama_sales }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- PKS Relation -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Surat Perjanjian (PKS)
                        </label>
                        <select 
                            name="id_pks" 
                            class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                        >
                            <option value="">-- Tanpa PKS --</option>
                            @foreach($pksList as $pks)
                                <option value="{{ $pks->id }}" {{ old('id_pks') == $pks->id ? 'selected' : '' }}>
                                    {{ $pks->no_surat }} - {{ $pks->nama_pelanggan }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pilih jika invoice terkait dengan surat perjanjian</p>
                    </div>
                </div>
            </x-ui.card>

            <!-- Bukti PKS Upload -->
            <x-ui.card>
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Bukti Surat Perjanjian</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Upload dokumen PKS (PDF/Gambar)</p>
                        </div>
                    </div>
                </x-slot>
                
                <div class="space-y-4" x-data="{ fileName: null }">
                    <div class="flex items-center justify-center w-full">
                        <label for="bukti_pks" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed rounded-xl cursor-pointer transition-colors"
                            :class="fileName ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-gray-300 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600'">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <template x-if="!fileName">
                                    <div class="text-center">
                                        <svg class="w-10 h-10 mb-3 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> atau drag and drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">PDF, PNG, JPG (MAX. 5MB)</p>
                                    </div>
                                </template>
                                <template x-if="fileName">
                                    <div class="text-center">
                                        <svg class="w-10 h-10 mb-3 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-green-600 dark:text-green-400 font-semibold" x-text="fileName"></p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Klik untuk mengganti file</p>
                                    </div>
                                </template>
                            </div>
                            <input id="bukti_pks" name="bukti_pks" type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png" 
                                @change="fileName = $event.target.files[0]?.name" />
                        </label>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        <span class="text-amber-600 dark:text-amber-400">💡</span> 
                        Upload scan/foto surat perjanjian sebagai bukti pendukung invoice (opsional)
                    </p>
                </div>
            </x-ui.card>

            <!-- Customer Information -->
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
                            <p class="text-sm text-gray-500 dark:text-gray-400">Customer details and contact</p>
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
                            :value="old('nama_pelanggan')" 
                            required 
                        />
                    </div>

                    <!-- Email -->
                    <x-ui.input 
                        type="email" 
                        name="email" 
                        label="Email Address" 
                        placeholder="customer@example.com" 
                        :value="old('email')" 
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
                        :value="old('no_telp')" 
                    >
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </x-slot>
                    </x-ui.input>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Address</label>
                        <textarea 
                            name="alamat" 
                            rows="3" 
                            placeholder="Enter customer address" 
                            class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none"
                        >{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </x-ui.card>

            <!-- Invoice Items Table -->
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
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Invoice Items</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Add items to this invoice</p>
                            </div>
                        </div>
                        <x-ui.button type="button" variant="success" size="sm" x-on:click="addItem">
                            <x-slot name="icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </x-slot>
                            Add Item
                        </x-ui.button>
                    </div>
                </x-slot>

                <div class="overflow-x-auto -mx-6 -mb-6">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-dark-sidebar border-y border-gray-200 dark:border-dark-border">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider w-12">#</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Item / Kuitansi ID <span class="text-red-500">*</span>
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider w-28">
                                    Qty <span class="text-red-500">*</span>
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider w-44">
                                    Unit Price <span class="text-red-500">*</span>
                                </th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider w-40">Subtotal</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider w-20">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-dark-border">
                            <template x-for="(item, index) in items" :key="index">
                                <tr class="hover:bg-gray-50 dark:hover:bg-dark-hover transition-colors">
                                    <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-400">
                                        <span x-text="index + 1"></span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <input 
                                            type="text" 
                                            :name="'items[' + index + '][id_kuitansi]'" 
                                            x-model="item.id_kuitansi"
                                            class="w-full px-3 py-2 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-lg text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                            placeholder="Enter item ID"
                                            required
                                        />
                                    </td>
                                    <td class="px-4 py-4">
                                        <input 
                                            type="number" 
                                            :name="'items[' + index + '][jumlah]'" 
                                            x-model.number="item.jumlah"
                                            @input="calculateSubtotal(index)"
                                            class="w-full px-3 py-2 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-lg text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                            placeholder="0"
                                            min="1"
                                            step="1"
                                            required
                                        />
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 text-sm">Rp</span>
                                            <input 
                                                type="number" 
                                                :name="'items[' + index + '][harga_satuan]'" 
                                                x-model.number="item.harga_satuan"
                                                @input="calculateSubtotal(index)"
                                                class="w-full pl-10 pr-3 py-2 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-lg text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                                placeholder="0"
                                                min="0"
                                                step="1"
                                                required
                                            />
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <span class="font-semibold text-gray-900 dark:text-white" x-text="formatCurrency(item.subtotal)"></span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <button 
                                            type="button" 
                                            @click="removeItem(index)"
                                            class="p-2 rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                            :disabled="items.length === 1"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <!-- Empty State -->
                <div x-show="items.length === 0" x-cloak class="text-center py-12">
                    <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-dark-hover mx-auto flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">No items added</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Click "Add Item" to add invoice items.</p>
                </div>
            </x-ui.card>

            <!-- Calculation Summary -->
            <x-ui.card class="bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/20 dark:to-primary-800/20 border-primary-200 dark:border-primary-800">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-white dark:bg-dark-card shadow-sm flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Invoice Summary</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Calculated totals</p>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-6 md:gap-10">
                        <div class="text-center sm:text-right">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Subtotal</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-white" x-text="formatCurrency(grandTotal)"></p>
                        </div>
                        <div class="text-center sm:text-right">
                            <p class="text-sm text-gray-600 dark:text-gray-400">PPN (11%)</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-white" x-text="formatCurrency(ppn)"></p>
                        </div>
                        <div class="text-center sm:text-right border-t sm:border-t-0 sm:border-l border-primary-300 dark:border-primary-700 pt-4 sm:pt-0 sm:pl-6">
                            <p class="text-sm font-medium text-primary-600 dark:text-primary-400">Grand Total</p>
                            <p class="text-2xl font-bold text-primary-600 dark:text-primary-400" x-text="formatCurrency(totalWithPPN)"></p>
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <!-- Additional Notes -->
            <x-ui.card>
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-dark-hover flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Additional Notes</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Optional information</p>
                        </div>
                    </div>
                </x-slot>
                
                <textarea 
                    name="keterangan" 
                    rows="4" 
                    placeholder="Enter any additional notes or information (optional)" 
                    class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none"
                >{{ old('keterangan') }}</textarea>
            </x-ui.card>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-4 bg-white dark:bg-dark-card rounded-xl border border-gray-200 dark:border-dark-border">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    <span class="text-red-500">*</span> indicates required fields
                </p>
                <div class="flex gap-3">
                    <x-ui.button variant="secondary" href="{{ route('invoices.index') }}">
                        Cancel
                    </x-ui.button>
                    <x-ui.button type="submit" variant="success">
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </x-slot>
                        Create Invoice
                    </x-ui.button>
                </div>
            </div>

        </form>
    </div>

    @push('scripts')
    <script>
        function invoiceInput() {
            return {
                items: [{
                    id_kuitansi: '',
                    jumlah: 1,
                    harga_satuan: 0,
                    subtotal: 0
                }],
                
                get grandTotal() {
                    return this.items.reduce((sum, item) => sum + (item.subtotal || 0), 0);
                },
                
                get ppn() {
                    return this.grandTotal * 0.11;
                },
                
                get totalWithPPN() {
                    return this.grandTotal + this.ppn;
                },
                
                addItem() {
                    this.items.push({
                        id_kuitansi: '',
                        jumlah: 1,
                        harga_satuan: 0,
                        subtotal: 0
                    });
                },
                
                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                },
                
                calculateSubtotal(index) {
                    const item = this.items[index];
                    item.subtotal = (item.jumlah || 0) * (item.harga_satuan || 0);
                },
                
                formatCurrency(value) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(value || 0);
                }
            }
        }
    </script>
    @endpush
</x-layout.app>
