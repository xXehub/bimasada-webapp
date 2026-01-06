<x-layout.app title="Detail PKS">
    <div class="space-y-6">
        
        <!-- Page Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('surat-perjanjians.index') }}" class="p-2 rounded-xl bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border hover:bg-gray-50 dark:hover:bg-dark-hover transition-colors">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail PKS</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $suratPerjanjian->no_surat ?? 'PKS-' . str_pad($suratPerjanjian->id, 4, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
            <div class="flex gap-3 flex-wrap">
                {{-- Sales: Submit for Approval when PKS is Draft --}}
                @if($suratPerjanjian->status_surat === 'Draft')
                    @can('edit-pks')
                        <x-ui.button variant="success" onclick="submitForApproval()">
                            <x-slot name="icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </x-slot>
                            Kirim untuk Persetujuan
                        </x-ui.button>
                    @endcan
                @endif

                {{-- Marketing Manager: Approve/Reject when PKS is Aktif (pending approval) --}}
                @if($suratPerjanjian->status_surat === 'Aktif')
                    @can('approve-pks')
                        <x-ui.button variant="success" onclick="approvePKS()">
                            <x-slot name="icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </x-slot>
                            Setujui PKS
                        </x-ui.button>
                        <x-ui.button variant="danger" onclick="rejectPKS()">
                            <x-slot name="icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </x-slot>
                            Tolak
                        </x-ui.button>
                    @endcan
                @endif

                @can('edit-pks')
                    <x-ui.button variant="primary" href="{{ route('surat-perjanjians.edit', $suratPerjanjian->id) }}">
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </x-slot>
                        Edit PKS
                    </x-ui.button>
                @endcan
                <x-ui.button variant="outline" onclick="printPKS()">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                    </x-slot>
                    Print
                </x-ui.button>
            </div>
        </div>

        <!-- PKS Summary Card -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main PKS Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Header Card -->
                <x-ui.card class="!p-0 overflow-hidden">
                    <!-- Status Banner -->
                    @php
                        $statusColors = [
                            'Draft' => 'from-gray-500 to-gray-600',
                            'Aktif' => 'from-blue-500 to-blue-600',
                            'Disetujui' => 'from-emerald-500 to-emerald-600',
                            'Kadaluarsa' => 'from-red-500 to-red-600',
                            'Dibatalkan' => 'from-amber-500 to-amber-600'
                        ];
                        $statusBg = $statusColors[$suratPerjanjian->status_surat] ?? 'from-gray-500 to-gray-600';
                    @endphp
                    <div class="bg-gradient-to-r {{ $statusBg }} px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-white/80 text-sm">Nomor PKS</p>
                                    <p class="text-white font-bold text-xl">{{ $suratPerjanjian->no_surat ?? 'PKS-' . str_pad($suratPerjanjian->id, 4, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-white/80 text-sm">Status</p>
                                <p class="text-white font-bold text-lg">{{ $suratPerjanjian->status_surat }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Surat</p>
                                <p class="font-semibold text-gray-900 dark:text-white mt-1">{{ $suratPerjanjian->tanggal_surat->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Selesai</p>
                                <p class="font-semibold mt-1 {{ $suratPerjanjian->tanggal_selesai->isPast() ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white' }}">
                                    {{ $suratPerjanjian->tanggal_selesai->format('d M Y') }}
                                    @if($suratPerjanjian->tanggal_selesai->isPast())
                                        <span class="text-xs block text-red-500">Expired!</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Sales Person</p>
                                <p class="font-semibold text-gray-900 dark:text-white mt-1">{{ $suratPerjanjian->sales->nama_sales ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Durasi Kontrak</p>
                                @php
                                    $duration = $suratPerjanjian->tanggal_surat->diffInDays($suratPerjanjian->tanggal_selesai);
                                    $months = floor($duration / 30);
                                    $days = $duration % 30;
                                @endphp
                                <p class="font-semibold text-gray-900 dark:text-white mt-1">
                                    @if($months > 0)
                                        {{ $months }} bulan
                                    @endif
                                    @if($days > 0)
                                        {{ $days }} hari
                                    @endif
                                </p>
                            </div>
                        </div>
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
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Pelanggan</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Data pelanggan perjanjian</p>
                            </div>
                        </div>
                    </x-slot>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nama Pelanggan</p>
                            <p class="font-semibold text-gray-900 dark:text-white mt-1">{{ $suratPerjanjian->nama_pelanggan }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                            <p class="font-semibold text-gray-900 dark:text-white mt-1">{{ $suratPerjanjian->email_pelanggan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">No. Telepon</p>
                            <p class="font-semibold text-gray-900 dark:text-white mt-1">{{ $suratPerjanjian->no_telp_pelanggan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Alamat</p>
                            <p class="font-semibold text-gray-900 dark:text-white mt-1">{{ $suratPerjanjian->alamat_pelanggan }}</p>
                        </div>
                    </div>
                </x-ui.card>

                <!-- Contract Parties -->
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
                                <p class="text-sm text-gray-500 dark:text-gray-400">Para pihak yang terlibat</p>
                            </div>
                        </div>
                    </x-slot>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-4 rounded-xl bg-gray-50 dark:bg-dark-hover border border-gray-200 dark:border-dark-border">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Pihak Pertama</p>
                            <p class="font-semibold text-gray-900 dark:text-white mt-1">{{ $suratPerjanjian->nama_pihak_pertama }}</p>
                        </div>
                        <div class="p-4 rounded-xl bg-gray-50 dark:bg-dark-hover border border-gray-200 dark:border-dark-border">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Pihak Kedua</p>
                            <p class="font-semibold text-gray-900 dark:text-white mt-1">{{ $suratPerjanjian->nama_pihak_kedua }}</p>
                        </div>
                    </div>
                </x-ui.card>

                <!-- Contract Items -->
                <x-ui.card>
                    <x-slot name="header">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Item Kontrak</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $suratPerjanjian->detailSurats->count() }} item</p>
                            </div>
                        </div>
                    </x-slot>

                    @if($suratPerjanjian->detailSurats->count() > 0)
                        <div class="overflow-x-auto -mx-6 -mb-6">
                            <table class="w-full">
                                <thead class="bg-gray-50 dark:bg-dark-sidebar border-y border-gray-200 dark:border-dark-border">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider w-12">#</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Spesifikasi</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Harga Satuan</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-dark-border">
                                    @foreach($suratPerjanjian->detailSurats as $index => $detail)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-dark-hover transition-colors">
                                        <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $index + 1 }}</td>
                                        <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $detail->spesifikasi ?? '-' }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-white text-right">{{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-white text-right">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                        <td class="px-4 py-4 text-sm font-semibold text-gray-900 dark:text-white text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50 dark:bg-dark-sidebar border-t-2 border-gray-300 dark:border-dark-border">
                                    <tr>
                                        <td colspan="4" class="px-4 py-4 text-right text-sm font-bold text-gray-900 dark:text-white uppercase">Total Kontrak:</td>
                                        <td class="px-4 py-4 text-right text-lg font-bold text-primary-600 dark:text-primary-400">Rp {{ number_format($suratPerjanjian->nilai_kontrak, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-dark-hover mx-auto flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400">Belum ada detail item kontrak</p>
                        </div>
                    @endif
                </x-ui.card>

                <!-- Terms & Conditions Section -->
                @if($suratPerjanjian->syarat_ketentuan)
                <x-ui.card>
                    <x-slot name="header">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-dark-hover flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Syarat & Ketentuan</h3>
                        </div>
                    </x-slot>
                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $suratPerjanjian->syarat_ketentuan }}</p>
                </x-ui.card>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Total Amount Card -->
                <x-ui.card class="bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900/20 dark:to-primary-800/20 border-primary-200 dark:border-primary-800">
                    <div class="text-center">
                        <p class="text-sm text-primary-600 dark:text-primary-400 font-medium">Nilai Kontrak</p>
                        <p class="text-3xl font-bold text-primary-700 dark:text-primary-300 mt-2">
                            Rp {{ number_format($suratPerjanjian->nilai_kontrak, 0, ',', '.') }}
                        </p>
                        <div class="mt-4 pt-4 border-t border-primary-200 dark:border-primary-700">
                            @php
                                $badgeVariants = [
                                    'Draft' => 'secondary',
                                    'Aktif' => 'info',
                                    'Disetujui' => 'success',
                                    'Kadaluarsa' => 'danger',
                                    'Dibatalkan' => 'warning'
                                ];
                            @endphp
                            <x-ui.badge :variant="$badgeVariants[$suratPerjanjian->status_surat] ?? 'secondary'" :dot="true" size="lg">
                                {{ $suratPerjanjian->status_surat }}
                            </x-ui.badge>
                        </div>
                    </div>
                </x-ui.card>

                <!-- Invoice Progress Card -->
                @if($suratPerjanjian->status_surat === 'Disetujui')
                <x-ui.card>
                    <x-slot name="header">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Progress Invoice</h3>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $suratPerjanjian->invoices->count() }} invoice</span>
                        </div>
                    </x-slot>
                    
                    @php
                        $totalInvoiced = $suratPerjanjian->total_invoiced;
                        $remainingValue = $suratPerjanjian->remaining_contract_value;
                        $percentage = $suratPerjanjian->nilai_kontrak > 0 ? min(100, ($totalInvoiced / $suratPerjanjian->nilai_kontrak) * 100) : 0;
                    @endphp
                    
                    <div class="space-y-4">
                        <!-- Progress Bar -->
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600 dark:text-gray-400">Tertagih</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ number_format($percentage, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                                <div class="bg-gradient-to-r from-primary-500 to-emerald-500 h-3 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl">
                                <p class="text-xs text-emerald-600 dark:text-emerald-400">Sudah Ditagih</p>
                                <p class="font-bold text-emerald-700 dark:text-emerald-300 text-sm mt-1">Rp {{ number_format($totalInvoiced, 0, ',', '.') }}</p>
                            </div>
                            <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl">
                                <p class="text-xs text-amber-600 dark:text-amber-400">Sisa Nilai</p>
                                <p class="font-bold text-amber-700 dark:text-amber-300 text-sm mt-1">Rp {{ number_format($remainingValue, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Invoice List -->
                        @if($suratPerjanjian->invoices->count() > 0)
                        <div class="space-y-2 pt-2 border-t border-gray-200 dark:border-dark-border">
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Invoice Terkait</p>
                            @foreach($suratPerjanjian->invoices->take(3) as $invoice)
                            <a href="{{ route('invoices.show', $invoice->id) }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-dark-hover transition-colors">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                                        <svg class="w-3 h-3 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $invoice->invoice_number }}</span>
                                </div>
                                <span class="text-xs font-medium {{ $invoice->status_pembayaran === 'Lunas' ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}">
                                    Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}
                                </span>
                            </a>
                            @endforeach
                            @if($suratPerjanjian->invoices->count() > 3)
                            <p class="text-xs text-gray-500 dark:text-gray-400 text-center pt-1">
                                +{{ $suratPerjanjian->invoices->count() - 3 }} invoice lainnya
                            </p>
                            @endif
                        </div>
                        @endif

                        <!-- Create Invoice Button -->
                        @if($remainingValue > 0)
                        <a href="{{ route('invoices.createFromPks', $suratPerjanjian->id) }}" class="block w-full py-2 px-4 bg-primary-600 hover:bg-primary-700 text-white text-center rounded-xl text-sm font-medium transition-colors">
                            + Buat Invoice Baru
                        </a>
                        @else
                        <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl text-center">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm font-medium text-emerald-700 dark:text-emerald-300">Kontrak Selesai Ditagih</p>
                        </div>
                        @endif
                    </div>
                </x-ui.card>
                @endif

                <!-- Quick Actions Card -->
                <x-ui.card>
                    <x-slot name="header">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Aksi Cepat</h3>
                    </x-slot>
                    <div class="space-y-3">
                        @can('edit-pks')
                            <a href="{{ route('surat-perjanjians.edit', $suratPerjanjian->id) }}" class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-dark-hover hover:bg-gray-100 dark:hover:bg-dark-sidebar transition-colors">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">Edit PKS</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Ubah data PKS</p>
                                </div>
                            </a>
                        @endcan
                        
                        @can('approve-pks')
                            @if($suratPerjanjian->status_surat === 'Aktif')
                            <button type="button" onclick="approvePKS()" class="w-full flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-dark-hover hover:bg-gray-100 dark:hover:bg-dark-sidebar transition-colors text-left">
                                <div class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">Setujui PKS</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Approve perjanjian ini</p>
                                </div>
                            </button>
                            @endif
                        @endcan

                        <a href="{{ route('invoices.create') }}" class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-dark-hover hover:bg-gray-100 dark:hover:bg-dark-sidebar transition-colors">
                            <div class="w-10 h-10 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Buat Invoice Baru</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Invoice mandiri</p>
                            </div>
                        </a>

                        @if($suratPerjanjian->status_surat === 'Disetujui' && $suratPerjanjian->remaining_contract_value > 0)
                        <a href="{{ route('invoices.createFromPks', $suratPerjanjian->id) }}" class="flex items-center gap-3 p-3 rounded-xl bg-primary-50 dark:bg-primary-900/30 hover:bg-primary-100 dark:hover:bg-primary-900/50 transition-colors border-2 border-primary-200 dark:border-primary-800">
                            <div class="w-10 h-10 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-primary-900 dark:text-primary-100">Invoice dari PKS</p>
                                <p class="text-sm text-primary-600 dark:text-primary-400">Terhubung ke kontrak ini</p>
                            </div>
                        </a>
                        @endif

                        <button type="button" onclick="window.print()" class="w-full flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-dark-hover hover:bg-gray-100 dark:hover:bg-dark-sidebar transition-colors text-left">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Print PKS</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Cetak dokumen</p>
                            </div>
                        </button>
                    </div>
                </x-ui.card>

                <!-- Timeline Card -->
                <x-ui.card>
                    <x-slot name="header">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Timeline</h3>
                    </x-slot>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">PKS Dibuat</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $suratPerjanjian->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($suratPerjanjian->updated_at != $suratPerjanjian->created_at)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Terakhir Diupdate</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $suratPerjanjian->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full {{ $suratPerjanjian->tanggal_selesai->isPast() ? 'bg-red-100 dark:bg-red-900/30' : 'bg-gray-100 dark:bg-gray-800' }} flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 {{ $suratPerjanjian->tanggal_selesai->isPast() ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Tanggal Selesai</p>
                                <p class="text-sm {{ $suratPerjanjian->tanggal_selesai->isPast() ? 'text-red-500' : 'text-gray-500 dark:text-gray-400' }}">{{ $suratPerjanjian->tanggal_selesai->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </x-ui.card>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function submitForApproval() {
            Modal.confirm({
                title: 'Kirim untuk Persetujuan',
                message: 'Apakah Anda yakin ingin mengirim PKS "{{ $suratPerjanjian->no_surat ?? 'PKS-' . str_pad($suratPerjanjian->id, 4, '0', STR_PAD_LEFT) }}" untuk persetujuan Marketing Manager?',
                confirmText: 'Ya, Kirim',
                cancelText: 'Batal',
                variant: 'primary',
                onConfirm: () => {
                    fetch('{{ route('surat-perjanjians.updateStatus', $suratPerjanjian) }}', {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ status_surat: 'Aktif' })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Notification.success('Berhasil!', 'PKS berhasil dikirim untuk persetujuan');
                            setTimeout(() => window.location.reload(), 1500);
                        } else {
                            Notification.error('Gagal!', data.message || 'Gagal mengirim PKS');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Notification.error('Error!', 'Terjadi kesalahan');
                    });
                }
            });
        }

        function approvePKS() {
            Modal.confirm({
                title: 'Setujui PKS',
                message: 'Apakah Anda yakin ingin menyetujui PKS "{{ $suratPerjanjian->no_surat ?? 'PKS-' . str_pad($suratPerjanjian->id, 4, '0', STR_PAD_LEFT) }}"?',
                confirmText: 'Ya, Setujui',
                cancelText: 'Batal',
                variant: 'success',
                onConfirm: () => {
                    fetch('{{ route('surat-perjanjians.approve', $suratPerjanjian) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Notification.success('Berhasil!', data.message || 'PKS berhasil disetujui');
                            setTimeout(() => window.location.reload(), 1500);
                        } else {
                            Notification.error('Gagal!', data.message || 'Gagal menyetujui PKS');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Notification.error('Error!', 'Terjadi kesalahan saat menyetujui PKS');
                    });
                }
            });
        }

        function rejectPKS() {
            Modal.confirm({
                title: 'Tolak PKS',
                message: 'Apakah Anda yakin ingin menolak PKS "{{ $suratPerjanjian->no_surat ?? 'PKS-' . str_pad($suratPerjanjian->id, 4, '0', STR_PAD_LEFT) }}"? PKS akan dikembalikan ke Sales untuk diperbaiki.',
                confirmText: 'Ya, Tolak',
                cancelText: 'Batal',
                variant: 'danger',
                onConfirm: () => {
                    fetch('{{ route('surat-perjanjians.reject', $suratPerjanjian) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Notification.warning('Ditolak!', data.message || 'PKS telah ditolak');
                            setTimeout(() => window.location.reload(), 1500);
                        } else {
                            Notification.error('Gagal!', data.message || 'Gagal menolak PKS');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Notification.error('Error!', 'Terjadi kesalahan saat menolak PKS');
                    });
                }
            });
        }

        function printPKS() {
            window.open('{{ route('surat-perjanjians.show', $suratPerjanjian->id) }}?print=1', '_blank');
        }
    </script>
    @endpush
</x-layout.app>
