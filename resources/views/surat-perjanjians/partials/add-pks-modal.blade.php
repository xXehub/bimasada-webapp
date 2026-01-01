<!-- Add PKS Modal -->
<x-ui.modal name="add-pks-modal" maxWidth="lg">
    <div x-data="addPKSModal()">
        <form @submit.prevent="submitForm">
            <!-- Modal Header -->
            <x-ui.modal-header title="Buat PKS Baru">
                <x-slot name="icon">
                    <div class="w-10 h-10 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </x-slot>
                <x-slot name="subtitle">Isi form berikut untuk membuat Surat Perjanjian Kerjasama baru</x-slot>
            </x-ui.modal-header>

            <!-- Modal Body -->
            <x-ui.modal-body>
                <div class="space-y-4">
                    <!-- No PKS -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            No PKS
                        </label>
                        <input 
                            type="text" 
                            x-model="formData.no_surat"
                            class="w-full px-4 py-2.5 bg-gray-100 dark:bg-dark-sidebar border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white cursor-not-allowed"
                            placeholder="PKS-2025-01-0001"
                            readonly
                        />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Nomor PKS digenerate otomatis</p>
                    </div>

                    <!-- Nama Pelanggan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Nama Pelanggan / Perusahaan <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            x-model="formData.nama_pelanggan"
                            class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                            placeholder="Nama perusahaan atau pelanggan"
                            required
                        />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Sales Person -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Sales Person <span class="text-red-500">*</span>
                            </label>
                            <select 
                                x-model="formData.id_sales"
                                class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                required
                            >
                                <option value="">Pilih Sales</option>
                                @foreach($salesList ?? [] as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama_sales }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select 
                                x-model="formData.status_surat"
                                class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                required
                            >
                                <option value="">Pilih Status</option>
                                <option value="Draft">Draft</option>
                                <option value="Aktif">Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Tanggal Surat -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Tanggal Surat <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="date" 
                                x-model="formData.tanggal_surat"
                                class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                required
                            />
                        </div>

                        <!-- Tanggal Selesai -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Tanggal Selesai <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="date" 
                                x-model="formData.tanggal_selesai"
                                class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                required
                            />
                        </div>
                    </div>

                    <!-- Nilai Kontrak -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Nilai Kontrak <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 text-sm font-medium">Rp</span>
                            <input 
                                type="text" 
                                x-model="formattedNilaiKontrak"
                                @input="formatNilaiKontrak($event)"
                                class="w-full pl-12 pr-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                placeholder="0"
                                required
                            />
                        </div>
                    </div>

                    <!-- Error Message -->
                    <div x-show="errorMessage" x-cloak class="rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-red-800 dark:text-red-200" x-text="errorMessage"></p>
                        </div>
                    </div>
                </div>
            </x-ui.modal-body>

            <!-- Modal Footer -->
            <x-ui.modal-footer>
                <x-ui.button variant="secondary" type="button" x-on:click="close()">
                    Batal
                </x-ui.button>
                <x-ui.button variant="primary" type="submit" x-bind:disabled="isSubmitting">
                    <template x-if="!isSubmitting">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan
                        </span>
                    </template>
                    <template x-if="isSubmitting">
                        <span class="flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Menyimpan...
                        </span>
                    </template>
                </x-ui.button>
            </x-ui.modal-footer>
        </form>
    </div>
</x-ui.modal>

<script>
    function addPKSModal() {
        return {
            formData: {
                no_surat: '',
                nama_pelanggan: '',
                id_sales: '',
                status_surat: 'Draft',
                tanggal_surat: new Date().toISOString().split('T')[0],
                tanggal_selesai: '',
                nilai_kontrak: 0
            },
            formattedNilaiKontrak: '',
            errorMessage: '',
            isSubmitting: false,

            init() {
                // Set default tanggal_selesai to 1 year from now
                const oneYearLater = new Date();
                oneYearLater.setFullYear(oneYearLater.getFullYear() + 1);
                this.formData.tanggal_selesai = oneYearLater.toISOString().split('T')[0];
                
                window.addEventListener('open-modal', async (event) => {
                    if (event.detail === 'add-pks-modal') {
                        await this.fetchPKSNumber();
                    }
                });
            },

            formatNilaiKontrak(event) {
                // Remove all non-digits
                let value = event.target.value.replace(/\D/g, '');
                
                // Store raw value
                this.formData.nilai_kontrak = parseInt(value) || 0;
                
                // Format with thousand separator
                this.formattedNilaiKontrak = new Intl.NumberFormat('id-ID').format(value);
            },

            async fetchPKSNumber() {
                try {
                    const response = await fetch('{{ route('surat-perjanjians.generateNumber') }}');
                    const data = await response.json();
                    this.formData.no_surat = data.pks_number;
                } catch (error) {
                    console.error('Error fetching PKS number:', error);
                    this.errorMessage = 'Gagal menggenerate nomor PKS';
                }
            },

            async submitForm() {
                this.isSubmitting = true;
                this.errorMessage = '';

                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    
                    const response = await fetch('{{ route('surat-perjanjians.storeQuick') }}', {
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
                        throw new Error(errorData.message || 'Terjadi kesalahan saat menyimpan PKS');
                    }

                    const data = await response.json();
                    
                    // Show success notification
                    Notification.success('Berhasil!', data.message || 'PKS berhasil dibuat');
                    
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        window.location.reload();
                    }
                } catch (error) {
                    this.errorMessage = error.message;
                    this.isSubmitting = false;
                }
            },

            close() {
                this.$dispatch('close-modal', 'add-pks-modal');
            }
        }
    }
</script>
