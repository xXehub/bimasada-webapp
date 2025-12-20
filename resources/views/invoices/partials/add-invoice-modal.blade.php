<!-- Add Invoice Modal -->
<x-modal name="add-invoice" :show="false" maxWidth="md" focusable>
    <div class="p-6" x-data="addInvoiceModal()">
        <form @submit.prevent="submitForm">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-6 border-b pb-4">
                <h2 class="text-xl font-semibold text-gray-900">
                    Tambah Invoice Baru
                </h2>
                <button 
                    type="button" 
                    @click="$dispatch('close-modal', 'add-invoice')"
                    class="text-gray-400 hover:text-gray-600 transition-colors"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="space-y-4">
                <!-- No Invoice -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        No Invoice <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="text" 
                        x-model="formData.invoice_number"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 bg-gray-50"
                        placeholder="INV-2025-12-0001"
                        readonly
                        required
                    />
                    <p class="mt-1 text-xs text-gray-500">Nomor invoice akan digenerate otomatis</p>
                </div>

                <!-- No Kontrak -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        No Kontrak
                    </label>
                    <input 
                        type="text" 
                        x-model="formData.no_kontrak"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                        placeholder="Masukkan nomor kontrak (opsional)"
                    />
                </div>

                <!-- Mitra / Perusahaan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Mitra / Perusahaan <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="text" 
                        x-model="formData.nama_pelanggan"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                        placeholder="Nama perusahaan atau mitra"
                        required
                    />
                </div>

                <!-- Sales Person -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Sales Person <span class="text-danger">*</span>
                    </label>
                    <select 
                        x-model="formData.id_sales"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                        required
                    >
                        <option value="">Pilih Sales Person</option>
                        @foreach($salesList ?? [] as $s)
                            <option value="{{ $s->id }}">{{ $s->id_sales }} - {{ $s->nama_sales }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status Pembayaran <span class="text-danger">*</span>
                    </label>
                    <select 
                        x-model="formData.status_pembayaran"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                        required
                    >
                        <option value="">Pilih Status</option>
                        <option value="Lunas">Lunas</option>
                        <option value="Belum Lunas">Belum Lunas</option>
                        <option value="Cicilan">Cicilan</option>
                    </select>
                </div>

                <!-- Created at (Tanggal Invoice) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Invoice <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="date" 
                        x-model="formData.tanggal_invoice"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                        required
                    />
                </div>

                <!-- Error Message -->
                <div x-show="errorMessage" class="rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-800" x-text="errorMessage"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="mt-6 flex items-center justify-end space-x-3 border-t pt-4">
                <button 
                    type="button" 
                    @click="$dispatch('close-modal', 'add-invoice')"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors"
                >
                    Batal
                </button>
                <button 
                    type="submit"
                    :disabled="isSubmitting"
                    :class="{ 'opacity-50 cursor-not-allowed': isSubmitting }"
                    class="px-4 py-2 text-sm font-medium text-white bg-primary hover:bg-primary-dark rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors"
                >
                    <span x-show="!isSubmitting">Simpan</span>
                    <span x-show="isSubmitting" class="flex items-center">
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

    <script>
        function addInvoiceModal() {
            return {
                formData: {
                    invoice_number: '',
                    no_kontrak: '',
                    nama_pelanggan: '',
                    id_sales: '',
                    status_pembayaran: '',
                    tanggal_invoice: new Date().toISOString().split('T')[0]
                },
                errorMessage: '',
                isSubmitting: false,

                init() {
                    // Fetch invoice number when modal opens
                    this.$watch('show', async (value) => {
                        if (value) {
                            await this.fetchInvoiceNumber();
                        }
                    });

                    // Listen for modal open event
                    window.addEventListener('open-modal', async (event) => {
                        if (event.detail === 'add-invoice') {
                            await this.fetchInvoiceNumber();
                        }
                    });
                },

                async fetchInvoiceNumber() {
                    try {
                        const response = await fetch('{{ route('invoices.generateNumber') }}');
                        const data = await response.json();
                        this.formData.invoice_number = data.invoice_number;
                    } catch (error) {
                        console.error('Error fetching invoice number:', error);
                        this.errorMessage = 'Gagal menggenerate nomor invoice';
                    }
                },

                async submitForm() {
                    this.isSubmitting = true;
                    this.errorMessage = '';

                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                        
                        const response = await fetch('{{ route('invoices.storeQuick') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(this.formData)
                        });

                        if (!response.ok) {
                            const errorData = await response.json();
                            throw new Error(errorData.message || 'Terjadi kesalahan saat menyimpan invoice');
                        }

                        // Redirect to edit page
                        const data = await response.json();
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            // Fallback: reload page
                            window.location.reload();
                        }
                    } catch (error) {
                        this.errorMessage = error.message;
                        this.isSubmitting = false;
                    }
                }
            }
        }
    </script>
</x-modal>
