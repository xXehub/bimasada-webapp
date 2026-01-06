<x-layout.app title="Detail Kuitansi">
    <div class="space-y-6">
        
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/25">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $kuitansi->no_kuitansi ?? 'KTN-' . str_pad($kuitansi->id, 4, '0', STR_PAD_LEFT) }}</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-0.5">Detail kuitansi pembayaran</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <x-ui.button variant="secondary" href="{{ route('kuitansis.index') }}">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </x-slot>
                    Kembali
                </x-ui.button>
                @can('edit-kuitansi')
                <x-ui.button variant="secondary" href="{{ route('kuitansis.edit', $kuitansi->id) }}">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </x-slot>
                    Edit
                </x-ui.button>
                @endcan
                <x-ui.button variant="primary" href="{{ route('pdf.kuitansi', $kuitansi) }}" target="_blank">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </x-slot>
                    Download PDF
                </x-ui.button>
            </div>
        </div>

        <!-- Status Banner -->
        @php
            $statusConfig = [
                'Lunas' => [
                    'bg' => 'bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30',
                    'border' => 'border-green-200 dark:border-green-800',
                    'text' => 'text-green-700 dark:text-green-300',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                ],
                'Terkirim' => [
                    'bg' => 'bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30',
                    'border' => 'border-blue-200 dark:border-blue-800',
                    'text' => 'text-blue-700 dark:text-blue-300',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
                ],
                'Draft' => [
                    'bg' => 'bg-gradient-to-r from-gray-50 to-slate-50 dark:from-gray-800/50 dark:to-slate-800/50',
                    'border' => 'border-gray-200 dark:border-gray-700',
                    'text' => 'text-gray-700 dark:text-gray-300',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                ],
                'Batal' => [
                    'bg' => 'bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/30 dark:to-rose-900/30',
                    'border' => 'border-red-200 dark:border-red-800',
                    'text' => 'text-red-700 dark:text-red-300',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>',
                ],
            ];
            $config = $statusConfig[$kuitansi->status_kuitansi] ?? $statusConfig['Draft'];
        @endphp
        
        <div class="p-5 rounded-2xl border-2 {{ $config['bg'] }} {{ $config['border'] }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-white dark:bg-dark-card shadow-sm flex items-center justify-center">
                        <svg class="w-7 h-7 {{ $config['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $config['icon'] !!}
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Kuitansi</p>
                        <p class="text-xl font-bold {{ $config['text'] }}">{{ $kuitansi->status_kuitansi }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pembayaran</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($kuitansi->total_bayar, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Kuitansi Info -->
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
                                <p class="text-sm text-gray-500 dark:text-gray-400">Detail kuitansi pembayaran</p>
                            </div>
                        </div>
                    </x-slot>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">No. Kuitansi</p>
                            <p class="mt-1 text-base font-semibold text-gray-900 dark:text-white">{{ $kuitansi->no_kuitansi ?? 'KTN-' . str_pad($kuitansi->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Kuitansi</p>
                            <p class="mt-1 text-base font-semibold text-gray-900 dark:text-white">{{ $kuitansi->tanggal_kuitansi->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Metode Pembayaran</p>
                            @php
                                $methodColors = [
                                    'Cash' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                    'Transfer' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                    'Ciro' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400',
                                ];
                            @endphp
                            <p class="mt-1">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $methodColors[$kuitansi->invoice_pembayaran] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $kuitansi->invoice_pembayaran }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Invoice Terkait</p>
                            <p class="mt-1">
                                @if($kuitansi->invoice)
                                    <a href="{{ route('invoices.show', $kuitansi->invoice->id) }}" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        {{ $kuitansi->invoice->no_invoice ?? 'INV-' . str_pad($kuitansi->invoice->id, 4, '0', STR_PAD_LEFT) }}
                                    </a>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">Tidak ada invoice terkait</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </x-ui.card>

                <!-- Customer Info -->
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
                                <p class="text-sm text-gray-500 dark:text-gray-400">Data pelanggan</p>
                            </div>
                        </div>
                    </x-slot>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Pelanggan</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $kuitansi->nama_pelanggan }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">No. Telepon</p>
                            <p class="mt-1 text-base text-gray-900 dark:text-white">{{ $kuitansi->no_telp ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Sales</p>
                            <p class="mt-1 text-base text-gray-900 dark:text-white">{{ $kuitansi->sales?->nama_sales ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat</p>
                            <p class="mt-1 text-base text-gray-900 dark:text-white">{{ $kuitansi->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </x-ui.card>

                <!-- Keterangan -->
                @if($kuitansi->keterangan)
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
                                <p class="text-sm text-gray-500 dark:text-gray-400">Catatan tambahan</p>
                            </div>
                        </div>
                    </x-slot>
                    
                    <p class="text-gray-700 dark:text-gray-300">{{ $kuitansi->keterangan }}</p>
                </x-ui.card>
                @endif

                <!-- Detail Items -->
                @if($kuitansi->detailKuitansis->count() > 0)
                <x-ui.card>
                    <x-slot name="header">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Item</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Rincian item pembayaran</p>
                            </div>
                        </div>
                    </x-slot>
                    
                    <div class="overflow-x-auto -mx-6 -mb-6">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-border">
                            <thead class="bg-gray-50 dark:bg-dark-hover">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Item</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Harga Satuan</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-dark-card divide-y divide-gray-200 dark:divide-dark-border">
                                @foreach($kuitansi->detailKuitansis as $index => $detail)
                                <tr class="hover:bg-gray-50 dark:hover:bg-dark-hover transition-colors">
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $detail->id_txtKtl }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white text-right">{{ $detail->jumlah }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white text-right">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 dark:bg-dark-hover">
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-right text-sm font-semibold text-gray-900 dark:text-white">Total:</td>
                                    <td class="px-6 py-4 text-right text-base font-bold text-primary-600 dark:text-primary-400">Rp {{ number_format($kuitansi->detailKuitansis->sum('subtotal'), 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </x-ui.card>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <x-ui.card>
                    <x-slot name="header">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Aksi Cepat</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Aksi yang tersedia</p>
                            </div>
                        </div>
                    </x-slot>
                    
                    <div class="space-y-2">
                        @can('edit-kuitansi')
                        <a href="{{ route('kuitansis.edit', $kuitansi->id) }}" 
                            class="flex items-center gap-3 w-full px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-hover rounded-xl transition-colors">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Kuitansi
                        </a>
                        @endcan

                        <a href="{{ route('pdf.kuitansi', $kuitansi) }}" target="_blank"
                            class="flex items-center gap-3 w-full px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-hover rounded-xl transition-colors">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Download PDF
                        </a>

                        <a href="{{ route('pdf.kuitansi.stream', $kuitansi) }}" target="_blank"
                            class="flex items-center gap-3 w-full px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-hover rounded-xl transition-colors">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Cetak Kuitansi
                        </a>

                        @if($kuitansi->invoice)
                        <a href="{{ route('invoices.show', $kuitansi->invoice->id) }}"
                            class="flex items-center gap-3 w-full px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-hover rounded-xl transition-colors">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Lihat Invoice
                        </a>
                        @endif

                        @can('delete-kuitansi')
                        <button type="button" onclick="deleteKuitansi()"
                            class="flex items-center gap-3 w-full px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Kuitansi
                        </button>
                        @endcan
                    </div>
                </x-ui.card>

                <!-- Timestamps -->
                <x-ui.card>
                    <x-slot name="header">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Waktu</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Riwayat perubahan</p>
                            </div>
                        </div>
                    </x-slot>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Dibuat</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $kuitansi->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Terakhir Diubah</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $kuitansi->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </x-ui.card>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function deleteKuitansi() {
            if (confirm('Apakah Anda yakin ingin menghapus kuitansi ini? Tindakan ini tidak dapat dibatalkan.')) {
                fetch('{{ route("kuitansis.destroy", $kuitansi->id) }}', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '{{ route("kuitansis.index") }}';
                    } else {
                        alert(data.message || 'Gagal menghapus kuitansi');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus kuitansi');
                });
            }
        }
    </script>
    @endpush
</x-layout.app>
