<x-layout.app title="Detail Relasi - {{ $pks->no_surat }}">
    @push('styles')
    <style>
        .timeline-item {
            position: relative;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: 1.25rem;
            top: 2.5rem;
            bottom: -1rem;
            width: 2px;
            background: linear-gradient(to bottom, rgb(229 231 235), transparent);
        }
        .dark .timeline-item::before {
            background: linear-gradient(to bottom, rgb(55 65 81), transparent);
        }
        .timeline-item:last-child::before {
            display: none;
        }
    </style>
    @endpush

    <!-- Main Content Container - matching Invoice layout -->
    <div class="mb-8">
        <div class="space-y-8">
            
            <!-- Page Header with Breadcrumb -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-2">
                        <a href="{{ route('archive.index') }}" class="hover:text-gray-700 dark:hover:text-gray-300">Archive</a>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <a href="{{ route('archive.relations') }}" class="hover:text-gray-700 dark:hover:text-gray-300">Relasi</a>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <span class="text-gray-900 dark:text-white">{{ $pks->no_surat }}</span>
                    </nav>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Relasi Dokumen</h1>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('surat-perjanjians.show', $pks->id) }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                        Lihat PKS
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- PKS Info Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 sticky top-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">PKS</span>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $pks->no_surat }}</h3>
                            </div>
                        </div>

                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm text-gray-500 dark:text-gray-400">Pelanggan</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $pks->nama_pelanggan }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-500 dark:text-gray-400">Tanggal</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $pks->tanggal_surat?->format('d M Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-500 dark:text-gray-400">Nilai Kontrak</dt>
                                <dd class="text-lg font-bold text-gray-900 dark:text-white">Rp {{ number_format($pks->nilai_kontrak ?? 0, 0, ',', '.') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-500 dark:text-gray-400">Status</dt>
                                <dd>
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
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$pks->status_surat] ?? $statusColors['Draft'] }}">
                                        {{ $pks->status_surat }}
                                    </span>
                                </dd>
                            </div>
                        </dl>

                        <!-- Summary Stats -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-4">Ringkasan</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-3 text-center">
                                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $relations['invoices']->count() }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Invoice</p>
                                </div>
                                <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-3 text-center">
                                    <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $relations['kuitansis']->count() }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Kuitansi</p>
                                </div>
                            </div>
                            
                            @php
                                $totalInvoiced = $relations['invoices']->sum('total_harga');
                                $totalPaid = $relations['kuitansis']->sum('total_bayar');
                                $percentage = $totalInvoiced > 0 ? round(($totalPaid / $totalInvoiced) * 100) : 0;
                            @endphp
                            <div class="mt-4">
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-500 dark:text-gray-400">Progress Pembayaran</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $percentage }}%</span>
                                </div>
                                <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-green-500 rounded-full transition-all duration-300" style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    <span>Rp {{ number_format($totalPaid, 0, ',', '.') }}</span>
                                    <span>Rp {{ number_format($totalInvoiced, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Timeline Dokumen
                        </h3>

                        <div class="space-y-6">
                            @foreach($relations['timeline'] as $item)
                                @php
                                    $iconColors = [
                                        'blue' => 'bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400',
                                        'green' => 'bg-green-100 text-green-600 dark:bg-green-900/50 dark:text-green-400',
                                        'purple' => 'bg-purple-100 text-purple-600 dark:bg-purple-900/50 dark:text-purple-400',
                                        'gray' => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400',
                                        'yellow' => 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/50 dark:text-yellow-400',
                                    ];
                                @endphp
                                <div class="timeline-item flex gap-4">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full {{ $iconColors[$item['color']] ?? $iconColors['gray'] }} flex items-center justify-center">
                                        @switch($item['icon'])
                                            @case('document')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                @break
                                            @case('check')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                @break
                                            @case('receipt')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                </svg>
                                                @break
                                            @case('cash')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                                @break
                                            @case('check-circle')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                @break
                                            @case('flag')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                                                </svg>
                                                @break
                                            @default
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                        @endswitch
                                    </div>
                                    <div class="flex-1 pb-6">
                                        <div class="flex items-center justify-between mb-1">
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $item['title'] }}</h4>
                                            <time class="text-xs text-gray-500 dark:text-gray-400">{{ $item['date']->format('d M Y H:i') }}</time>
                                        </div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $item['description'] }}</p>
                                        @if(isset($item['url']))
                                            <a href="{{ $item['url'] }}" class="inline-flex items-center gap-1 mt-2 text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                                                Lihat Detail
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($relations['timeline']->isEmpty())
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">Belum ada aktivitas</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>