<x-layout.app title="Buat PKS Baru">
    <div class="space-y-6">
        
        <!-- Page Header with Breadcrumb -->
        <div class="flex flex-col gap-4">
            <!-- Breadcrumb -->
            <nav class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('surat-perjanjians.index') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Surat Perjanjian</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-900 dark:text-white font-medium">Buat Baru</span>
            </nav>

            <!-- Title & Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center shadow-lg shadow-primary-500/25">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Buat PKS Baru</h1>
                        <p class="text-gray-500 dark:text-gray-400 mt-0.5">Buat Surat Perjanjian Kerjasama baru</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <x-ui.button variant="secondary" href="{{ route('surat-perjanjians.index') }}" size="sm">
                        <x-slot name="icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </x-slot>
                        Batal
                    </x-ui.button>
                </div>
            </div>
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

        <form action="{{ route('surat-perjanjians.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- PKS Information Card -->
            <x-ui.card>
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi PKS</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Detail dasar surat perjanjian</p>
                        </div>
                    </div>
                </x-slot>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Tanggal Surat -->
                    <x-ui.input 
                        type="date" 
                        name="tanggal_surat" 
                        label="Tanggal Surat" 
                        :value="old('tanggal_surat', date('Y-m-d'))" 
                        required 
                    />

                    <!-- Tanggal Selesai -->
                    <x-ui.input 
                        type="date" 
                        name="tanggal_selesai" 
                        label="Tanggal Selesai" 
                        :value="old('tanggal_selesai')" 
                        required 
                    />

                    <!-- Status Surat -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="status_surat" 
                            required
                            class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                        >
                            <option value="">Pilih Status</option>
                            <option value="Draft" {{ old('status_surat', 'Draft') == 'Draft' ? 'selected' : '' }}>Draft</option>
                            <option value="Aktif" {{ old('status_surat') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        </select>
                    </div>

                    <!-- Sales Person -->
                    <div class="md:col-span-3">
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
                                <option value="{{ $s->id }}" {{ old('id_sales') == $s->id ? 'selected' : '' }}>
                                    {{ $s->name }}
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
                            <p class="text-sm text-gray-500 dark:text-gray-400">Data pelanggan dan informasi kontak</p>
                        </div>
                    </div>
                </x-slot>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Pelanggan -->
                    <div class="md:col-span-2">
                        <x-ui.input 
                            type="text" 
                            name="nama_pelanggan" 
                            label="Nama Pelanggan / Perusahaan" 
                            placeholder="Masukkan nama pelanggan atau perusahaan" 
                            :value="old('nama_pelanggan')" 
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
                        name="email_pelanggan" 
                        label="Email" 
                        placeholder="customer@example.com" 
                        :value="old('email_pelanggan')" 
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
                        name="no_telp_pelanggan" 
                        label="No. Telepon" 
                        placeholder="08xx-xxxx-xxxx" 
                        :value="old('no_telp_pelanggan')" 
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
                            Alamat <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-4 top-3 text-gray-400 dark:text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <textarea 
                                name="alamat_pelanggan" 
                                rows="3" 
                                placeholder="Masukkan alamat pelanggan"
                                required
                                class="w-full pl-12 pr-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none"
                            >{{ old('alamat_pelanggan') }}</textarea>
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <!-- Contract Parties Card -->
            <x-ui.card>
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pihak Perjanjian</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nama pihak yang terlibat dalam perjanjian</p>
                        </div>
                    </div>
                </x-slot>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Pihak Pertama -->
                    <x-ui.input 
                        type="text" 
                        name="nama_pihak_pertama" 
                        label="Pihak Pertama" 
                        placeholder="Nama pihak pertama (perusahaan Anda)" 
                        :value="old('nama_pihak_pertama', 'PT. BIMASADA JAYA PERSADA')" 
                        required 
                    >
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </x-slot>
                    </x-ui.input>

                    <!-- Pihak Kedua -->
                    <x-ui.input 
                        type="text" 
                        name="nama_pihak_kedua" 
                        label="Pihak Kedua" 
                        placeholder="Nama pihak kedua (pelanggan)" 
                        :value="old('nama_pihak_kedua')" 
                        required 
                    >
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </x-slot>
                    </x-ui.input>
                </div>
            </x-ui.card>

            <!-- Contract Value Card -->
            <x-ui.card>
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Nilai Kontrak</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total nilai perjanjian kerjasama</p>
                        </div>
                    </div>
                </x-slot>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-ui.input 
                        type="number" 
                        step="0.01" 
                        name="nilai_kontrak" 
                        label="Nilai Kontrak (Rp)" 
                        placeholder="0" 
                        :value="old('nilai_kontrak')" 
                        required 
                    >
                        <x-slot name="icon">
                            <span class="text-sm font-semibold">Rp</span>
                        </x-slot>
                    </x-ui.input>
                    
                    <div class="flex items-end">
                        <div class="p-4 rounded-xl bg-gradient-to-br from-primary-50 to-emerald-50 dark:from-primary-900/20 dark:to-emerald-900/20 border border-primary-100 dark:border-primary-800 w-full">
                            <div class="flex items-center gap-2 text-sm text-primary-700 dark:text-primary-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Masukkan total nilai kontrak perjanjian kerjasama
                            </div>
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <!-- Terms & Conditions Card -->
            <x-ui.card>
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Syarat & Ketentuan</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Syarat dan ketentuan perjanjian (opsional)</p>
                        </div>
                    </div>
                </x-slot>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Syarat & Ketentuan
                    </label>
                    <textarea 
                        name="syarat_ketentuan" 
                        rows="6" 
                        placeholder="Masukkan syarat dan ketentuan perjanjian (opsional)"
                        class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors resize-none"
                    >{{ old('syarat_ketentuan') }}</textarea>
                </div>
            </x-ui.card>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-end gap-4 p-6 bg-white dark:bg-dark-card rounded-2xl border border-gray-200 dark:border-dark-border shadow-soft">
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <x-ui.button variant="secondary" type="button" href="{{ route('surat-perjanjians.index') }}">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </x-slot>
                        Simpan PKS
                    </x-ui.button>
                </div>
            </div>
        </form>
    </div>
</x-layout.app>
