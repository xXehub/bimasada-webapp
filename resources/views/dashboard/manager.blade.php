<x-layout.app title="Dashboard Manager">
    
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
                    Dashboard Marketing Manager
                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </h2>
                <p class="text-gray-500 dark:text-gray-400">
                    Pantau kinerja tim dan kelola approval dokumen.
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
    
    <!-- Main Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- PKS Pending Approval -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 p-6 shadow-lg">
            <div class="relative z-10">
                <p class="text-sm font-medium text-amber-100">PKS Menunggu Approval</p>
                <p class="text-4xl font-bold text-white mt-2">{{ $pksStats['pending_approval'] }}</p>
                <a href="{{ route('surat-perjanjians.index') }}?status=Menunggu+Persetujuan" class="inline-flex items-center gap-1 mt-3 text-sm text-white/90 hover:text-white transition-colors">
                    Review sekarang
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            <div class="absolute right-4 top-4 w-16 h-16 bg-white/10 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-white/5 rounded-full"></div>
        </div>
        
        <!-- Total PKS -->
        <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total PKS</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $pksStats['total'] }}</p>
                    <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-2">
                        {{ $pksStats['active'] }} aktif • {{ $pksStats['completed'] }} selesai
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                    <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Total Invoice -->
        <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Invoice</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $invoiceStats['total'] }}</p>
                    <p class="text-xs text-blue-600 dark:text-blue-400 mt-2">
                        {{ $invoiceStats['paid'] }} lunas • {{ $invoiceStats['overdue'] }} jatuh tempo
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Revenue -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 p-6 shadow-lg">
            <div class="relative z-10">
                <p class="text-sm font-medium text-emerald-100">Pendapatan Bulan Ini</p>
                <p class="text-2xl font-bold text-white mt-2">Rp {{ number_format($thisMonthRevenue, 0, ',', '.') }}</p>
                <p class="text-sm text-white/80 mt-2 flex items-center gap-1">
                    @if($revenueGrowth >= 0)
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    @else
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    @endif
                    {{ $revenueGrowth }}% dari bulan lalu
                </p>
            </div>
            <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-white/5 rounded-full"></div>
        </div>
    </div>

    <!-- Charts & Pending PKS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Monthly Trend Chart with ApexCharts -->
        <div class="lg:col-span-2 rounded-2xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Trend 6 Bulan Terakhir</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pendapatan & Dokumen</p>
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
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                        <span class="text-gray-600 dark:text-gray-400">PKS</span>
                    </div>
                </div>
            </div>
            <div id="revenue-chart" class="w-full" style="height: 280px; min-height: 280px;"></div>
        </div>
        
        <!-- PKS Pending Approval List -->
        <div class="rounded-2xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">PKS Pending</h3>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">
                    {{ $pendingPks->count() }}
                </span>
            </div>
            
            @if($pendingPks->count() > 0)
                <div class="space-y-3 max-h-80 overflow-y-auto">
                    @foreach($pendingPks as $pks)
                        <a href="{{ route('surat-perjanjians.show', $pks->id) }}" class="block p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                            <div class="flex items-start justify-between">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate group-hover:text-indigo-600 dark:group-hover:text-indigo-400">
                                        {{ $pks->no_surat }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        {{ $pks->nama_client }}
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                        oleh {{ $pks->salesUser->name ?? 'Unknown' }}
                                    </p>
                                </div>
                                <span class="text-xs text-gray-400 dark:text-gray-500">
                                    {{ $pks->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                        <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada PKS pending</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Sales Performance & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Sales Performance -->
        <div class="rounded-2xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Kinerja Sales</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            <th class="pb-3">Sales</th>
                            <th class="pb-3 text-center">PKS</th>
                            <th class="pb-3 text-center">Invoice</th>
                            <th class="pb-3 text-right">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($salesPerformance as $sales)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white text-sm font-medium">
                                            {{ strtoupper(substr($sales->name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $sales->name }}</span>
                                    </div>
                                </td>
                                <td class="py-3 text-center">
                                    <span class="text-sm text-gray-900 dark:text-white">{{ $sales->pks_count }}</span>
                                    <span class="text-xs text-emerald-500 inline-flex items-center gap-0.5">({{ $sales->pks_approved_count }}<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>)</span>
                                </td>
                                <td class="py-3 text-center">
                                    <span class="text-sm text-gray-900 dark:text-white">{{ $sales->invoice_count }}</span>
                                    <span class="text-xs text-emerald-500 inline-flex items-center gap-0.5">({{ $sales->invoice_paid_count }}<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>)</span>
                                </td>
                                <td class="py-3 text-right">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        Rp {{ number_format($sales->total_revenue ?? 0, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada data sales
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="rounded-2xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aktivitas Terbaru</h3>
            
            <div class="space-y-4 max-h-96 overflow-y-auto">
                @forelse($recentActivity as $activity)
                    <a href="{{ $activity['url'] }}" class="flex items-start gap-3 group">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0
                            @if($activity['type'] == 'pks') bg-indigo-100 dark:bg-indigo-900/30
                            @elseif($activity['type'] == 'invoice') bg-blue-100 dark:bg-blue-900/30
                            @else bg-emerald-100 dark:bg-emerald-900/30 @endif">
                            @if($activity['type'] == 'pks')
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            @elseif($activity['type'] == 'invoice')
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 truncate">
                                {{ $activity['title'] }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity['description'] }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                    @if(in_array($activity['status'], ['Lunas', 'Disetujui', 'Selesai'])) bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400
                                    @elseif(in_array($activity['status'], ['Menunggu Persetujuan', 'Terkirim'])) bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400
                                    @elseif(in_array($activity['status'], ['Dibatalkan', 'Jatuh Tempo'])) bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                    {{ $activity['status'] }}
                                </span>
                                <span class="text-xs text-gray-400 dark:text-gray-500">{{ $activity['date']->diffForHumans() }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-500 dark:text-gray-400">Belum ada aktivitas</p>
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
            const pks = monthlyData.map(d => d.pks);
            
            // Dark mode detection
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#9ca3af' : '#6b7280';
            const gridColor = isDark ? '#374151' : '#e5e7eb';
            
            // Revenue Chart with 3 series - Fixed
            const revenueOptions = {
                series: [{
                    name: 'Pendapatan',
                    type: 'area',
                    data: revenues
                }, {
                    name: 'Invoice',
                    type: 'line',
                    data: invoices
                }, {
                    name: 'PKS',
                    type: 'line',
                    data: pks
                }],
                chart: {
                    height: 280,
                    type: 'line',
                    toolbar: { show: false },
                    fontFamily: 'Poppins, sans-serif',
                    background: 'transparent',
                    parentHeightOffset: 0,
                    redrawOnParentResize: true,
                    events: {
                        mounted: function(chartContext, config) {
                            setTimeout(() => window.dispatchEvent(new Event('resize')), 100);
                        }
                    }
                },
                colors: ['#8b5cf6', '#10b981', '#f59e0b'],
                fill: {
                    type: ['gradient', 'solid', 'solid'],
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
                    width: [2, 3, 3],
                    curve: 'smooth'
                },
                markers: {
                    size: [4, 5, 5],
                    colors: ['#8b5cf6', '#10b981', '#f59e0b'],
                    strokeWidth: 2,
                    strokeColors: '#fff',
                    hover: { size: 7 }
                },
                xaxis: {
                    categories: months,
                    labels: { style: { colors: textColor } },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: [{
                    title: { text: 'Pendapatan (Rp)', style: { color: textColor, fontSize: '12px', fontWeight: 500 } },
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
                    title: { text: 'Jumlah Dokumen', style: { color: textColor, fontSize: '12px', fontWeight: 500 } },
                    labels: { style: { colors: textColor } },
                    min: 0,
                    forceNiceScale: true
                }],
                grid: {
                    borderColor: gridColor,
                    strokeDashArray: 4,
                    padding: { left: 10, right: 10 }
                },
                legend: {
                    show: false
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    theme: isDark ? 'dark' : 'light',
                    y: [{
                        formatter: function(val) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                        }
                    }, {
                        formatter: function(val) {
                            return val + ' invoice';
                        }
                    }, {
                        formatter: function(val) {
                            return val + ' PKS';
                        }
                    }]
                }
            };
            
            const revenueChart = new ApexCharts(document.querySelector("#revenue-chart"), revenueOptions);
            revenueChart.render();
        });
    </script>
    @endpush

</x-layout.app>
