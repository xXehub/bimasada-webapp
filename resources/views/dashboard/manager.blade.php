<x-layout.app title="Dashboard Manager">
    
    <!-- Welcome Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
            Dashboard Marketing Manager 📊
        </h2>
        <p class="text-gray-500 dark:text-gray-400">
            Pantau kinerja tim dan kelola approval dokumen.
        </p>
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
        
        <!-- Monthly Trend Chart -->
        <div class="lg:col-span-2 rounded-2xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Trend 6 Bulan Terakhir</h3>
            
            <div class="space-y-4">
                @foreach($monthlyTrend as $data)
                    <div class="flex items-center gap-4">
                        <span class="w-16 text-sm text-gray-500 dark:text-gray-400">{{ $data['month'] }}</span>
                        <div class="flex-1 flex items-center gap-2">
                            <div class="flex-1 bg-gray-100 dark:bg-gray-700 rounded-full h-2.5 overflow-hidden">
                                @php
                                    $maxRevenue = $monthlyTrend->max('revenue') ?: 1;
                                    $percentage = ($data['revenue'] / $maxRevenue) * 100;
                                @endphp
                                <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="w-28 text-sm font-medium text-gray-900 dark:text-white text-right">
                                Rp {{ number_format($data['revenue'] / 1000000, 1) }}M
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between text-sm">
                <span class="text-gray-500 dark:text-gray-400">Total Pendapatan</span>
                <span class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
            </div>
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
                                        oleh {{ $pks->sales->name ?? 'Unknown' }}
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
                                    <span class="text-xs text-gray-400">({{ $sales->pks_approved_count }}✓)</span>
                                </td>
                                <td class="py-3 text-center">
                                    <span class="text-sm text-gray-900 dark:text-white">{{ $sales->invoice_count }}</span>
                                    <span class="text-xs text-gray-400">({{ $sales->invoice_paid_count }}✓)</span>
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

</x-layout.app>
