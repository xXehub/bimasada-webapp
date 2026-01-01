<x-layout.app title="Document Relations">
    @push('styles')
    <style>
        .relation-card {
            transition: all 0.2s ease;
        }
        .relation-card:hover {
            transform: translateY(-2px);
        }
    </style>
    @endpush

    <!-- Main Content Container - matching Invoice layout -->
    <div class="mb-8">
        <div class="space-y-8">
            
            <!-- Page Header -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Relasi Dokumen</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Lihat hubungan antar dokumen PKS → Invoice → Kuitansi</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('archive.index') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Archive
                    </a>
                </div>
            </div>
            
            <div>
            @if($pksList->count() > 0)
                <div class="space-y-6">
                    @foreach($pksList as $pks)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden relation-card">
                            <!-- PKS Header -->
                            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0 w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">PKS</span>
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $pks->no_surat }}</h3>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                {{ $pks->nama_pelanggan }} • {{ $pks->tanggal_surat?->format('d M Y') }}
                                            </p>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                Nilai Kontrak: Rp {{ number_format($pks->nilai_kontrak ?? 0, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        @php
                                            $statusColors = [
                                                'Draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                                'Menunggu Persetujuan' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                'Disetujui' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                                'Aktif' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                                'Selesai' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                                'Dibatalkan' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$pks->status_surat] ?? $statusColors['Draft'] }}">
                                            {{ $pks->status_surat }}
                                        </span>
                                        <a href="{{ route('surat-perjanjians.show', $pks->id) }}" 
                                           class="inline-flex items-center gap-1 text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            Detail
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Invoices -->
                            @if($pks->invoices->count() > 0)
                                <div class="p-6">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-4 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                        Invoice ({{ $pks->invoices->count() }})
                                    </h4>
                                    <div class="space-y-4 ml-6 border-l-2 border-green-200 dark:border-green-800 pl-6">
                                        @foreach($pks->invoices as $invoice)
                                            <div class="bg-green-50 dark:bg-green-900/10 rounded-lg p-4 border border-green-200 dark:border-green-800">
                                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                                                    <div class="flex items-center gap-3">
                                                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center">
                                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <p class="font-medium text-gray-900 dark:text-white">{{ $invoice->invoice_number }}</p>
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                                {{ $invoice->tanggal_invoice?->format('d M Y') }} • Rp {{ number_format($invoice->total_harga ?? 0, 0, ',', '.') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-3">
                                                        @php
                                                            $invStatusColors = [
                                                                'Draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                                                'Terkirim' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                                                'Dibayar Sebagian' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                                'Lunas' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                                                'Jatuh Tempo' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                                                'Belum Lunas' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
                                                            ];
                                                        @endphp
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $invStatusColors[$invoice->status_pembayaran] ?? $invStatusColors['Draft'] }}">
                                                            {{ $invoice->status_pembayaran }}
                                                        </span>
                                                        <a href="{{ route('invoices.show', $invoice->id) }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>

                                                <!-- Kuitansi for this Invoice -->
                                                @if($invoice->kuitansis->count() > 0)
                                                    <div class="mt-4 ml-6 border-l-2 border-purple-200 dark:border-purple-800 pl-4 space-y-3">
                                                        @foreach($invoice->kuitansis as $kuitansi)
                                                            <div class="bg-purple-50 dark:bg-purple-900/10 rounded-lg p-3 border border-purple-200 dark:border-purple-800">
                                                                <div class="flex items-center justify-between">
                                                                    <div class="flex items-center gap-3">
                                                                        <div class="flex-shrink-0 w-6 h-6 bg-purple-100 dark:bg-purple-900/50 rounded flex items-center justify-center">
                                                                            <svg class="w-3 h-3 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                                            </svg>
                                                                        </div>
                                                                        <div>
                                                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $kuitansi->no_kuitansi }}</p>
                                                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                                                {{ $kuitansi->tanggal_kuitansi?->format('d M Y') }} • Rp {{ number_format($kuitansi->total_bayar ?? 0, 0, ',', '.') }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <a href="{{ route('kuitansis.show', $kuitansi->id) }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                                        </svg>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <p class="text-sm">Belum ada Invoice untuk PKS ini</p>
                                    @can('create-invoices')
                                    <a href="{{ route('invoices.createFromPks', $pks->id) }}" class="mt-2 inline-flex items-center gap-1 text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Buat Invoice
                                    </a>
                                    @endcan
                                </div>
                            @endif

                            <!-- Summary Footer -->
                            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex flex-wrap items-center gap-6 text-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-500 dark:text-gray-400">Invoice:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $pks->invoices_count }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-500 dark:text-gray-400">Lunas:</span>
                                        <span class="font-medium text-green-600 dark:text-green-400">{{ $pks->paid_invoices_count }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-500 dark:text-gray-400">Kuitansi:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $pks->invoices->flatMap->kuitansis->count() }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-500 dark:text-gray-400">Total Terbayar:</span>
                                        <span class="font-medium text-gray-900 dark:text-white">Rp {{ number_format($pks->invoices->flatMap->kuitansis->sum('total_bayar') ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $pksList->links() }}
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada PKS</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Mulai dengan membuat PKS baru untuk melihat relasi dokumen.</p>
                    @can('create-pks')
                    <a href="{{ route('surat-perjanjians.create') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat PKS Baru
                    </a>
                    @endcan
                </div>
            @endif
        </div>
    </div>
</x-layout.app>