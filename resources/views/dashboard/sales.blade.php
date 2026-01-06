<x-layout.app title="Dashboard Sales">
    
    <!-- ApexCharts CDN -->
    @push('styles')
    <style>
        .apexcharts-tooltip {
            background: #1f2937 !important;
            border: none !important;
            border-radius: 8px !important;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2) !important;
        }
        .apexcharts-tooltip-title {
            background: #374151 !important;
            border-bottom: none !important;
            color: #fff !important;
        }
        .apexcharts-tooltip-text {
            color: #fff !important;
        }
    </style>
    @endpush

    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                    Selamat Datang, {{ Auth::user()->name }}!
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/>
                    </svg>
                </h2>
                <p class="text-gray-500 dark:text-gray-400">
                    Berikut adalah ringkasan aktivitas Anda hari ini.
                </p>
            </div>
            <div class="hidden sm:flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Total PKS -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 p-6 shadow-lg">
            <div class="relative z-10">
                <p class="text-sm font-medium text-indigo-100">Total PKS</p>
                <p class="text-4xl font-bold text-white mt-2">{{ $pksStats['total'] }}</p>
                <div class="flex items-center gap-2 mt-3">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-white/20 text-white">
                        {{ $pksStats['pending'] }} pending
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-white/20 text-white">
                        {{ $pksStats['approved'] }} approved
                    </span>
                </div>
            </div>
            <div class="absolute right-4 top-4 w-16 h-16 bg-white/10 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-white/5 rounded-full"></div>
        </div>
        
        <!-- Total Invoice -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-600 p-6 shadow-lg">
            <div class="relative z-10">
                <p class="text-sm font-medium text-blue-100">Total Invoice</p>
                <p class="text-4xl font-bold text-white mt-2">{{ $invoiceStats['total'] }}</p>
                <div class="flex items-center gap-2 mt-3">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-white/20 text-white">
                        {{ $invoiceStats['sent'] }} terkirim
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-white/20 text-white">
                        {{ $invoiceStats['paid'] }} lunas
                    </span>
                </div>
            </div>
            <div class="absolute right-4 top-4 w-16 h-16 bg-white/10 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-white/5 rounded-full"></div>
        </div>
        
        <!-- Kuitansi -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 p-6 shadow-lg">
            <div class="relative z-10">
                <p class="text-sm font-medium text-emerald-100">Total Kuitansi</p>
                <p class="text-4xl font-bold text-white mt-2">{{ $kuitansiStats['total'] }}</p>
                <div class="flex items-center gap-2 mt-3">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-white/20 text-white">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ $kuitansiStats['this_month'] }} bulan ini
                    </span>
                </div>
            </div>
            <div class="absolute right-4 top-4 w-16 h-16 bg-white/10 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-white/5 rounded-full"></div>
        </div>
        
        <!-- Total Revenue -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 p-6 shadow-lg">
            <div class="relative z-10">
                <p class="text-sm font-medium text-amber-100">Total Pendapatan</p>
                <p class="text-2xl font-bold text-white mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                <div class="flex items-center gap-2 mt-3">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium {{ $revenueGrowth >= 0 ? 'bg-white/20' : 'bg-red-500/30' }} text-white">
                        @if($revenueGrowth >= 0)
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                        {{ abs($revenueGrowth) }}% dari bulan lalu
                    </span>
                </div>
            </div>
            <div class="absolute right-4 top-4 w-16 h-16 bg-white/10 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-white/5 rounded-full"></div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Revenue Trend Chart -->
        <div class="lg:col-span-2 rounded-2xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Trend Pendapatan</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">6 bulan terakhir</p>
                </div>
                <div class="flex items-center gap-4 text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                        <span class="text-gray-600 dark:text-gray-400">Pendapatan</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                        <span class="text-gray-600 dark:text-gray-400">Invoice</span>
                    </div>
                </div>
            </div>
            <div id="revenue-chart" class="w-full" style="height: 280px; min-height: 280px;"></div>
        </div>
        
        <!-- Document Stats -->
        <div class="rounded-2xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Status Dokumen</h3>
            </div>
            <div id="donut-chart" class="w-full flex items-center justify-center" style="height: 180px;"></div>
            <div class="mt-4 grid grid-cols-2 gap-3">
                <div class="flex items-center gap-2 p-2 rounded-lg bg-emerald-50 dark:bg-emerald-900/20">
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                    <span class="text-xs text-gray-600 dark:text-gray-400">Lunas</span>
                    <span class="ml-auto text-sm font-bold text-emerald-600 dark:text-emerald-400">{{ $invoiceStats['paid'] }}</span>
                </div>
                <div class="flex items-center gap-2 p-2 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                    <div class="w-2.5 h-2.5 rounded-full bg-blue-500"></div>
                    <span class="text-xs text-gray-600 dark:text-gray-400">Terkirim</span>
                    <span class="ml-auto text-sm font-bold text-blue-600 dark:text-blue-400">{{ $invoiceStats['sent'] }}</span>
                </div>
                <div class="flex items-center gap-2 p-2 rounded-lg bg-amber-50 dark:bg-amber-900/20">
                    <div class="w-2.5 h-2.5 rounded-full bg-amber-500"></div>
                    <span class="text-xs text-gray-600 dark:text-gray-400">Draft</span>
                    <span class="ml-auto text-sm font-bold text-amber-600 dark:text-amber-400">{{ $invoiceStats['draft'] }}</span>
                </div>
                <div class="flex items-center gap-2 p-2 rounded-lg bg-red-50 dark:bg-red-900/20">
                    <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                    <span class="text-xs text-gray-600 dark:text-gray-400">Jatuh Tempo</span>
                    <span class="ml-auto text-sm font-bold text-red-600 dark:text-red-400">{{ $invoiceStats['overdue'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Actions & Recent Documents -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Pending Actions -->
        <div class="rounded-2xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Perlu Ditindaklanjuti</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tugas yang memerlukan perhatian</p>
                </div>
                @if($pendingActions->count() > 0)
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">
                        {{ $pendingActions->count() }} tugas
                    </span>
                @endif
            </div>
            
            @if($pendingActions->count() > 0)
                <div class="space-y-3 max-h-80 overflow-y-auto">
                    @foreach($pendingActions as $action)
                        <a href="{{ $action['url'] }}" class="flex items-center gap-4 p-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all group border border-transparent hover:border-gray-200 dark:hover:border-gray-600">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0
                                @if($action['priority'] == 'high') bg-gradient-to-br from-red-500 to-rose-600
                                @else bg-gradient-to-br from-amber-500 to-orange-600 @endif">
                                @if($action['type'] == 'pks_draft')
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                @elseif($action['type'] == 'invoice_draft')
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate group-hover:text-indigo-600 dark:group-hover:text-indigo-400">{{ $action['title'] }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $action['description'] }}</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 font-medium flex items-center justify-center gap-2">Semua tugas sudah selesai! <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg></p>
                    <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">Tidak ada tugas yang perlu ditindaklanjuti</p>
                </div>
            @endif
        </div>
        
        <!-- Recent Documents -->
        <div class="rounded-2xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Invoice Terbaru</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">5 invoice terakhir Anda</p>
                </div>
                <a href="{{ route('invoices.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                    Lihat Semua →
                </a>
            </div>
            
            <div class="space-y-3 max-h-80 overflow-y-auto">
                @forelse($recentInvoices as $invoice)
                    <a href="{{ route('invoices.show', $invoice->id) }}" class="flex items-center gap-4 p-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all group border border-transparent hover:border-gray-200 dark:hover:border-gray-600">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate group-hover:text-indigo-600 dark:group-hover:text-indigo-400">
                                {{ $invoice->no_invoice ?? 'INV-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 truncate">{{ $invoice->nama_pelanggan ?? '-' }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold
                                @if($invoice->status_pembayaran == 'Lunas') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400
                                @elseif($invoice->status_pembayaran == 'Terkirim') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                @elseif($invoice->status_pembayaran == 'Jatuh Tempo') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400
                                @else bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300
                                @endif">
                                {{ $invoice->status_pembayaran }}
                            </span>
                            <p class="text-xs text-gray-400 mt-1">{{ $invoice->created_at->diffForHumans() }}</p>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-12">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400">Belum ada invoice</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart data from PHP
            const monthlyData = @json($monthlyTrend);
            const months = monthlyData.map(d => d.month_short);
            const revenues = monthlyData.map(d => d.revenue);
            const invoices = monthlyData.map(d => d.invoices);
            
            // Dark mode detection
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#9ca3af' : '#6b7280';
            const gridColor = isDark ? '#374151' : '#e5e7eb';
            
            // Revenue Chart - Fixed with proper area + line rendering
            const revenueOptions = {
                series: [{
                    name: 'Pendapatan',
                    type: 'area',
                    data: revenues
                }, {
                    name: 'Invoice',
                    type: 'line',
                    data: invoices
                }],
                chart: {
                    height: 280,
                    type: 'line',
                    toolbar: { show: false },
                    fontFamily: 'Poppins, sans-serif',
                    background: 'transparent',
                    parentHeightOffset: 0,
                    redrawOnParentResize: true,
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    },
                    events: {
                        mounted: function(chartContext, config) {
                            setTimeout(() => window.dispatchEvent(new Event('resize')), 100);
                        }
                    }
                },
                colors: ['#8b5cf6', '#10b981'],
                fill: {
                    type: ['gradient', 'solid'],
                    gradient: {
                        shade: 'light',
                        type: 'vertical',
                        shadeIntensity: 0.5,
                        opacityFrom: 0.5,
                        opacityTo: 0.1,
                        stops: [0, 100]
                    }
                },
                stroke: {
                    width: [2, 3],
                    curve: 'smooth'
                },
                markers: {
                    size: [4, 5],
                    colors: ['#8b5cf6', '#10b981'],
                    strokeWidth: 2,
                    strokeColors: '#fff',
                    hover: { size: 7 }
                },
                xaxis: {
                    categories: months,
                    labels: { 
                        style: { colors: textColor, fontSize: '12px' }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: [{
                    title: { 
                        text: 'Pendapatan (Rp)', 
                        style: { color: textColor, fontSize: '12px', fontWeight: 500 }
                    },
                    labels: {
                        style: { colors: textColor },
                        formatter: function(val) {
                            if (val >= 1000000) return 'Rp ' + (val / 1000000).toFixed(1) + ' Jt';
                            if (val >= 1000) return 'Rp ' + (val / 1000).toFixed(0) + ' Rb';
                            return 'Rp ' + val;
                        }
                    },
                    min: 0
                }, {
                    opposite: true,
                    title: { 
                        text: 'Jumlah Invoice', 
                        style: { color: textColor, fontSize: '12px', fontWeight: 500 }
                    },
                    labels: { style: { colors: textColor } },
                    min: 0,
                    forceNiceScale: true
                }],
                grid: {
                    borderColor: gridColor,
                    strokeDashArray: 4,
                    xaxis: { lines: { show: false } }
                },
                legend: { show: false },
                tooltip: {
                    shared: true,
                    intersect: false,
                    theme: isDark ? 'dark' : 'light',
                    y: [{
                        formatter: function(val) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(val || 0);
                        }
                    }, {
                        formatter: function(val) {
                            return (val || 0) + ' invoice';
                        }
                    }]
                }
            };
            
            const revenueChart = new ApexCharts(document.querySelector("#revenue-chart"), revenueOptions);
            revenueChart.render();
            
            // Donut Chart - Fixed with proper empty state handling
            const donutData = [
                {{ $invoiceStats['paid'] ?? 0 }}, 
                {{ $invoiceStats['sent'] ?? 0 }}, 
                {{ $invoiceStats['draft'] ?? 0 }}, 
                {{ $invoiceStats['overdue'] ?? 0 }}
            ];
            const hasData = donutData.some(v => v > 0);
            
            const donutOptions = {
                series: hasData ? donutData : [1], // Show placeholder if no data
                chart: {
                    type: 'donut',
                    height: 180,
                    fontFamily: 'Poppins, sans-serif',
                    parentHeightOffset: 0
                },
                colors: hasData ? ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'] : ['#e5e7eb'],
                labels: hasData ? ['Lunas', 'Terkirim', 'Draft', 'Jatuh Tempo'] : ['Tidak ada data'],
                legend: { show: false },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '75%',
                            labels: {
                                show: true,
                                name: { 
                                    show: true, 
                                    color: textColor,
                                    fontSize: '14px',
                                    fontWeight: 500,
                                    offsetY: -5
                                },
                                value: { 
                                    show: true, 
                                    color: isDark ? '#fff' : '#111827',
                                    fontSize: '24px',
                                    fontWeight: 700,
                                    offsetY: 5,
                                    formatter: function(val) {
                                        return hasData ? val : '0';
                                    }
                                },
                                total: {
                                    show: true,
                                    label: 'Total',
                                    color: textColor,
                                    fontSize: '14px',
                                    fontWeight: 500,
                                    formatter: function(w) {
                                        if (!hasData) return '0';
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                },
                stroke: { show: false },
                dataLabels: { enabled: false },
                tooltip: { 
                    enabled: hasData,
                    theme: isDark ? 'dark' : 'light'
                },
                states: {
                    hover: { filter: { type: 'darken', value: 0.9 } },
                    active: { filter: { type: 'none' } }
                }
            };
            
            const donutChart = new ApexCharts(document.querySelector("#donut-chart"), donutOptions);
            donutChart.render();
        });
    </script>
    @endpush

</x-layout.app>
