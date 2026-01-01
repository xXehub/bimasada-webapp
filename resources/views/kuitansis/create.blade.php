@extends('layouts.app')

@section('title', 'Buat Kuitansi Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('kuitansis.index') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Buat Kuitansi Baru</h1>
            <p class="mt-1 text-sm text-gray-500">Isi form di bawah untuk membuat kuitansi pembayaran baru</p>
        </div>
    </div>

    <form action="{{ route('kuitansis.store') }}" method="POST" x-data="kuitansiForm()">
        @csrf

        <!-- Basic Info -->
        <x-ui.card class="mb-6">
            <div class="p-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Kuitansi</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Kuitansi Number -->
                    <div>
                        <label for="no_kuitansi" class="block text-sm font-medium text-gray-700 mb-1">
                            No. Kuitansi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="no_kuitansi" name="no_kuitansi" value="{{ $noKuitansi }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50"
                            readonly>
                    </div>

                    <!-- Date -->
                    <div>
                        <label for="tanggal_kuitansi" class="block text-sm font-medium text-gray-700 mb-1">
                            Tanggal Kuitansi <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_kuitansi" name="tanggal_kuitansi" 
                            value="{{ old('tanggal_kuitansi', date('Y-m-d')) }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                        @error('tanggal_kuitansi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Related Invoice -->
                    <div>
                        <label for="id_invoice" class="block text-sm font-medium text-gray-700 mb-1">
                            Invoice Terkait
                        </label>
                        <select id="id_invoice" name="id_invoice" x-model="selectedInvoice" @change="loadInvoiceData()"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Invoice (Opsional)</option>
                            @foreach($invoices as $invoice)
                                <option value="{{ $invoice->id }}" 
                                    data-customer="{{ $invoice->nama_pelanggan }}"
                                    data-alamat="{{ $invoice->alamat }}"
                                    data-telp="{{ $invoice->no_telp }}"
                                    data-total="{{ $invoice->total }}"
                                    {{ ($selectedInvoice && $selectedInvoice->id == $invoice->id) ? 'selected' : '' }}>
                                    {{ $invoice->no_invoice ?? 'INV-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }} - {{ $invoice->nama_pelanggan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sales -->
                    <div>
                        <label for="id_sales" class="block text-sm font-medium text-gray-700 mb-1">
                            Sales <span class="text-red-500">*</span>
                        </label>
                        <select id="id_sales" name="id_sales"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="">Pilih Sales</option>
                            @foreach($salesList as $sales)
                                <option value="{{ $sales->id }}" {{ old('id_sales', $selectedInvoice?->id_sales) == $sales->id ? 'selected' : '' }}>
                                    {{ $sales->nama_sales }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_sales')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </x-ui.card>

        <!-- Customer Info -->
        <x-ui.card class="mb-6">
            <div class="p-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Pelanggan</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Customer Name -->
                    <div class="md:col-span-2">
                        <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Pelanggan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_pelanggan" name="nama_pelanggan" x-model="customerName"
                            value="{{ old('nama_pelanggan', $selectedInvoice?->nama_pelanggan) }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Masukkan nama pelanggan" required>
                        @error('nama_pelanggan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                            Alamat
                        </label>
                        <textarea id="alamat" name="alamat" rows="2" x-model="customerAddress"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Masukkan alamat pelanggan">{{ old('alamat', $selectedInvoice?->alamat) }}</textarea>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-1">
                            No. Telepon
                        </label>
                        <input type="text" id="no_telp" name="no_telp" x-model="customerPhone"
                            value="{{ old('no_telp', $selectedInvoice?->no_telp) }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Masukkan no. telepon">
                    </div>
                </div>
            </div>
        </x-ui.card>

        <!-- Payment Info -->
        <x-ui.card class="mb-6">
            <div class="p-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Pembayaran</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Payment Method -->
                    <div>
                        <label for="invoice_pembayaran" class="block text-sm font-medium text-gray-700 mb-1">
                            Metode Pembayaran <span class="text-red-500">*</span>
                        </label>
                        <select id="invoice_pembayaran" name="invoice_pembayaran"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="">Pilih Metode</option>
                            <option value="Cash" {{ old('invoice_pembayaran') == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="Transfer" {{ old('invoice_pembayaran') == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                            <option value="Ciro" {{ old('invoice_pembayaran') == 'Ciro' ? 'selected' : '' }}>Ciro</option>
                        </select>
                        @error('invoice_pembayaran')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status_kuitansi" class="block text-sm font-medium text-gray-700 mb-1">
                            Status
                        </label>
                        <select id="status_kuitansi" name="status_kuitansi"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="Draft" {{ old('status_kuitansi') == 'Draft' ? 'selected' : '' }}>Draft</option>
                            <option value="Terkirim" {{ old('status_kuitansi') == 'Terkirim' ? 'selected' : '' }}>Terkirim</option>
                            <option value="Lunas" {{ old('status_kuitansi') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>

                    <!-- Total Amount -->
                    <div>
                        <label for="total_bayar_display" class="block text-sm font-medium text-gray-700 mb-1">
                            Total Bayar <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                            <input type="text" id="total_bayar_display" x-model="totalDisplay"
                                @input="formatCurrency($event)" @blur="updateTotal()"
                                class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="0" required>
                            <input type="hidden" name="total_bayar" x-model="totalBayar">
                        </div>
                        @error('total_bayar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">
                        Keterangan
                    </label>
                    <textarea id="keterangan" name="keterangan" rows="3"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Tambahkan catatan atau keterangan (opsional)">{{ old('keterangan') }}</textarea>
                </div>
            </div>
        </x-ui.card>

        <!-- Detail Items -->
        <x-ui.card class="mb-6">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Detail Item</h3>
                <button type="button" @click="addItem()"
                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Item
                </button>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Item</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga Satuan</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <template x-for="(item, index) in items" :key="index">
                                <tr>
                                    <td class="px-4 py-3">
                                        <input type="text" :name="'items['+index+'][nama_item]'" x-model="item.nama_item"
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                                            placeholder="Nama item">
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="number" :name="'items['+index+'][jumlah]'" x-model="item.jumlah"
                                            @input="calculateSubtotal(index)"
                                            class="w-24 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                                            min="1">
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="relative">
                                            <span class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                                            <input type="text" x-model="item.harga_display"
                                                @input="formatItemPrice($event, index)" @blur="updateItemPrice(index)"
                                                class="w-32 pl-8 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                                                placeholder="0">
                                            <input type="hidden" :name="'items['+index+'][harga_satuan]'" x-model="item.harga_satuan">
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-sm font-medium text-gray-900" x-text="'Rp ' + formatNumber(item.subtotal)"></span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button type="button" @click="removeItem(index)"
                                            class="inline-flex items-center p-1.5 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="items.length === 0">
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                    Belum ada item. Klik "Tambah Item" untuk menambahkan.
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-gray-50" x-show="items.length > 0">
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right font-semibold text-gray-900">Total:</td>
                                <td class="px-4 py-3 font-bold text-gray-900" x-text="'Rp ' + formatNumber(calculateGrandTotal())"></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </x-ui.card>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('kuitansis.index') }}" 
                class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit" name="action" value="draft"
                class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors">
                Simpan sebagai Draft
            </button>
            <button type="submit" name="action" value="publish"
                class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 transition-colors">
                Simpan Kuitansi
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function kuitansiForm() {
        return {
            selectedInvoice: '{{ $selectedInvoice?->id ?? '' }}',
            customerName: '{{ old('nama_pelanggan', $selectedInvoice?->nama_pelanggan ?? '') }}',
            customerAddress: '{{ old('alamat', $selectedInvoice?->alamat ?? '') }}',
            customerPhone: '{{ old('no_telp', $selectedInvoice?->no_telp ?? '') }}',
            totalBayar: {{ old('total_bayar', $selectedInvoice?->total ?? 0) }},
            totalDisplay: '{{ old('total_bayar', $selectedInvoice?->total ?? 0) > 0 ? number_format(old('total_bayar', $selectedInvoice?->total ?? 0), 0, ',', '.') : '' }}',
            items: [],

            loadInvoiceData() {
                const select = document.getElementById('id_invoice');
                const option = select.options[select.selectedIndex];
                
                if (option.value) {
                    this.customerName = option.dataset.customer || '';
                    this.customerAddress = option.dataset.alamat || '';
                    this.customerPhone = option.dataset.telp || '';
                    
                    const total = parseFloat(option.dataset.total) || 0;
                    this.totalBayar = total;
                    this.totalDisplay = total > 0 ? this.formatNumber(total) : '';
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
