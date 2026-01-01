<x-ui.modal name="add-kuitansi-modal" :show="false" maxWidth="lg">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Buat Kuitansi Cepat</h3>
            <button type="button" x-on:click="$dispatch('close-modal', 'add-kuitansi-modal')" class="text-gray-400 hover:text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="quick-kuitansi-form" x-data="quickKuitansiForm()" @submit.prevent="submitForm">
            @csrf
            <div class="space-y-4">
                <!-- Kuitansi Number -->
                <div>
                    <label for="modal_no_kuitansi" class="block text-sm font-medium text-gray-700 mb-1">
                        No. Kuitansi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="modal_no_kuitansi" name="no_kuitansi" x-model="form.no_kuitansi"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50"
                        readonly>
                </div>

                <!-- Date -->
                <div>
                    <label for="modal_tanggal_kuitansi" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Kuitansi <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="modal_tanggal_kuitansi" name="tanggal_kuitansi" x-model="form.tanggal_kuitansi"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- Customer Name -->
                <div>
                    <label for="modal_nama_pelanggan" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Pelanggan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="modal_nama_pelanggan" name="nama_pelanggan" x-model="form.nama_pelanggan"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan nama pelanggan" required>
                </div>

                <!-- Total Amount -->
                <div>
                    <label for="modal_total_bayar" class="block text-sm font-medium text-gray-700 mb-1">
                        Total Bayar <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                        <input type="text" id="modal_total_bayar" x-model="form.total_bayar_display"
                            @input="formatCurrency($event)" @blur="updateTotalBayar()"
                            class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="0" required>
                        <input type="hidden" name="total_bayar" x-model="form.total_bayar">
                    </div>
                </div>

                <!-- Payment Method -->
                <div>
                    <label for="modal_invoice_pembayaran" class="block text-sm font-medium text-gray-700 mb-1">
                        Metode Pembayaran <span class="text-red-500">*</span>
                    </label>
                    <select id="modal_invoice_pembayaran" name="invoice_pembayaran" x-model="form.invoice_pembayaran"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="">Pilih Metode</option>
                        <option value="Cash">Cash</option>
                        <option value="Transfer">Transfer</option>
                        <option value="Ciro">Ciro</option>
                    </select>
                </div>

                <!-- Sales -->
                <div>
                    <label for="modal_id_sales" class="block text-sm font-medium text-gray-700 mb-1">
                        Sales <span class="text-red-500">*</span>
                    </label>
                    <select id="modal_id_sales" name="id_sales" x-model="form.id_sales"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="">Pilih Sales</option>
                        @php
                            $salesList = \App\Models\Sales::orderBy('nama_sales')->get();
                        @endphp
                        @foreach($salesList as $sales)
                            <option value="{{ $sales->id }}">{{ $sales->nama_sales }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Error Messages -->
            <div x-show="error" x-text="error" class="mt-4 p-3 bg-red-50 text-red-700 rounded-lg text-sm"></div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
                <button type="button" x-on:click="$dispatch('close-modal', 'add-kuitansi-modal')"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" :disabled="loading"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors disabled:opacity-50">
                    <span x-show="!loading">Simpan Kuitansi</span>
                    <span x-show="loading" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>
</x-ui.modal>

<script>
    function quickKuitansiForm() {
        return {
            loading: false,
            error: '',
            form: {
                no_kuitansi: '',
                tanggal_kuitansi: new Date().toISOString().split('T')[0],
                nama_pelanggan: '',
                total_bayar: 0,
                total_bayar_display: '',
                invoice_pembayaran: '',
                id_sales: ''
            },

            formatCurrency(event) {
                let value = event.target.value.replace(/[^\d]/g, '');
                if (value) {
                    this.form.total_bayar_display = parseInt(value).toLocaleString('id-ID');
                } else {
                    this.form.total_bayar_display = '';
                }
            },

            updateTotalBayar() {
                let value = this.form.total_bayar_display.replace(/[^\d]/g, '');
                this.form.total_bayar = value ? parseInt(value) : 0;
            },

            async submitForm() {
                this.loading = true;
                this.error = '';
                this.updateTotalBayar();

                try {
                    const response = await fetch('{{ route("kuitansis.storeQuick") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(this.form)
                    });

                    const data = await response.json();

                    if (data.success) {
                        window.dispatchEvent(new CustomEvent('close-modal', { detail: 'add-kuitansi-modal' }));
                        
                        // Show success notification
                        if (typeof showNotification === 'function') {
                            showNotification('success', data.message);
                        }

                        // Reload table
                        if (typeof kuitansiTable !== 'undefined') {
                            kuitansiTable.ajax.reload();
                        }

                        // Reset form
                        this.resetForm();
                    } else {
                        this.error = data.message || 'Gagal menyimpan kuitansi';
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.error = 'Terjadi kesalahan saat menyimpan kuitansi';
                } finally {
                    this.loading = false;
                }
            },

            resetForm() {
                this.form = {
                    no_kuitansi: '',
                    tanggal_kuitansi: new Date().toISOString().split('T')[0],
                    nama_pelanggan: '',
                    total_bayar: 0,
                    total_bayar_display: '',
                    invoice_pembayaran: '',
                    id_sales: ''
                };
            }
        }
    }
</script>
