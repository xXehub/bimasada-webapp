<x-layout.app title="Dashboard">
    
    @section('page-title', 'Dashboard')
    @section('breadcrumb')
        <span class="text-primary">Dashboard</span>
    @endsection
    
    <!-- Welcome Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-secondary-900 dark:text-white mb-2">
            Selamat Datang, {{ Auth::user()->name ?? 'User' }}! 👋
        </h2>
        <p class="text-secondary-500 dark:text-secondary-400">
            Berikut adalah ringkasan aktivitas sistem invoice hari ini.
        </p>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Total Invoice -->
        <x-ui.card class="relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-secondary-500 dark:text-secondary-400">Total Invoice</p>
                    <p class="text-3xl font-bold text-secondary-900 dark:text-white mt-1">128</p>
                    <p class="text-xs text-success mt-2 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        +12% dari bulan lalu
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-primary/10 dark:bg-primary/20 flex items-center justify-center">
                    <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-primary/5 dark:bg-primary/10 rounded-full blur-xl"></div>
        </x-ui.card>
        
        <!-- Pending -->
        <x-ui.card class="relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-secondary-500 dark:text-secondary-400">Menunggu Approval</p>
                    <p class="text-3xl font-bold text-secondary-900 dark:text-white mt-1">24</p>
                    <p class="text-xs text-warning mt-2 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                        5 urgent
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-warning/10 dark:bg-warning/20 flex items-center justify-center">
                    <svg class="w-7 h-7 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-warning/5 dark:bg-warning/10 rounded-full blur-xl"></div>
        </x-ui.card>
        
        <!-- Approved -->
        <x-ui.card class="relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-secondary-500 dark:text-secondary-400">Disetujui</p>
                    <p class="text-3xl font-bold text-secondary-900 dark:text-white mt-1">89</p>
                    <p class="text-xs text-success mt-2 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Minggu ini: +15
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-success/10 dark:bg-success/20 flex items-center justify-center">
                    <svg class="w-7 h-7 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-success/5 dark:bg-success/10 rounded-full blur-xl"></div>
        </x-ui.card>
        
        <!-- Total Revenue -->
        <x-ui.card class="relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-secondary-500 dark:text-secondary-400">Total Pendapatan</p>
                    <p class="text-3xl font-bold text-secondary-900 dark:text-white mt-1">Rp 1.2M</p>
                    <p class="text-xs text-success mt-2 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        +8% dari bulan lalu
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-info/10 dark:bg-info/20 flex items-center justify-center">
                    <svg class="w-7 h-7 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-info/5 dark:bg-info/10 rounded-full blur-xl"></div>
        </x-ui.card>
        
    </div>
    
    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Recent Invoices -->
        <div class="lg:col-span-2">
            <x-ui.card :padding="false">
                <x-slot name="header">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-secondary-900 dark:text-white">Invoice Terbaru</h3>
                        <a href="{{ route('invoices.index') }}" class="text-sm font-medium text-primary hover:text-primary-dark dark:text-primary-400 dark:hover:text-primary-300 transition-colors">
                            Lihat Semua →
                        </a>
                    </div>
                </x-slot>
                
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No. Invoice</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="font-medium text-secondary-900 dark:text-white">INV-2024-001</td>
                                <td>PT ABC Indonesia</td>
                                <td>Rp 15.500.000</td>
                                <td><x-ui.badge variant="success" dot>Approved</x-ui.badge></td>
                                <td>20 Dec 2024</td>
                            </tr>
                            <tr>
                                <td class="font-medium text-secondary-900 dark:text-white">INV-2024-002</td>
                                <td>CV Maju Jaya</td>
                                <td>Rp 8.750.000</td>
                                <td><x-ui.badge variant="warning" dot>Pending</x-ui.badge></td>
                                <td>19 Dec 2024</td>
                            </tr>
                            <tr>
                                <td class="font-medium text-secondary-900 dark:text-white">INV-2024-003</td>
                                <td>PT XYZ Corp</td>
                                <td>Rp 23.000.000</td>
                                <td><x-ui.badge variant="success" dot>Approved</x-ui.badge></td>
                                <td>19 Dec 2024</td>
                            </tr>
                            <tr>
                                <td class="font-medium text-secondary-900 dark:text-white">INV-2024-004</td>
                                <td>UD Berkah Mandiri</td>
                                <td>Rp 5.200.000</td>
                                <td><x-ui.badge variant="danger" dot>Rejected</x-ui.badge></td>
                                <td>18 Dec 2024</td>
                            </tr>
                            <tr>
                                <td class="font-medium text-secondary-900 dark:text-white">INV-2024-005</td>
                                <td>PT Sejahtera</td>
                                <td>Rp 12.300.000</td>
                                <td><x-ui.badge variant="secondary" dot>Draft</x-ui.badge></td>
                                <td>18 Dec 2024</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </x-ui.card>
        </div>
        
        <!-- Quick Actions & Activity -->
        <div class="space-y-6">
            
            <!-- Quick Actions -->
            <x-ui.card>
                <h3 class="text-lg font-semibold text-secondary-900 dark:text-white mb-4">Aksi Cepat</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('invoices.create') }}" class="flex items-center gap-3 p-3 rounded-xl bg-primary/5 dark:bg-primary/10 hover:bg-primary/10 dark:hover:bg-primary/20 transition-colors group">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 dark:bg-primary/20 flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors">
                            <svg class="w-5 h-5 text-primary group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-secondary-900 dark:text-white">Buat Invoice Baru</p>
                            <p class="text-xs text-secondary-500 dark:text-secondary-400">Input invoice baru</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('invoices.index') }}" class="flex items-center gap-3 p-3 rounded-xl bg-secondary-50 dark:bg-dark-hover hover:bg-secondary-100 dark:hover:bg-secondary-800 transition-colors group">
                        <div class="w-10 h-10 rounded-xl bg-secondary-100 dark:bg-secondary-800 flex items-center justify-center">
                            <svg class="w-5 h-5 text-secondary-600 dark:text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-secondary-900 dark:text-white">Lihat Semua Invoice</p>
                            <p class="text-xs text-secondary-500 dark:text-secondary-400">Kelola invoice</p>
                        </div>
                    </a>
                    
                    <a href="#" class="flex items-center gap-3 p-3 rounded-xl bg-secondary-50 dark:bg-dark-hover hover:bg-secondary-100 dark:hover:bg-secondary-800 transition-colors group">
                        <div class="w-10 h-10 rounded-xl bg-secondary-100 dark:bg-secondary-800 flex items-center justify-center">
                            <svg class="w-5 h-5 text-secondary-600 dark:text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-secondary-900 dark:text-white">Data Pelanggan</p>
                            <p class="text-xs text-secondary-500 dark:text-secondary-400">Kelola pelanggan</p>
                        </div>
                    </a>
                </div>
            </x-ui.card>
            
            <!-- Recent Activity -->
            <x-ui.card>
                <h3 class="text-lg font-semibold text-secondary-900 dark:text-white mb-4">Aktivitas Terbaru</h3>
                
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-secondary-900 dark:text-white">
                                <span class="font-medium">INV-2024-001</span> disetujui
                            </p>
                            <p class="text-xs text-secondary-500 dark:text-secondary-400">2 jam yang lalu</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-secondary-900 dark:text-white">
                                Invoice baru <span class="font-medium">INV-2024-005</span> dibuat
                            </p>
                            <p class="text-xs text-secondary-500 dark:text-secondary-400">4 jam yang lalu</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-warning/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-warning" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-secondary-900 dark:text-white">
                                <span class="font-medium">INV-2024-003</span> diperbarui
                            </p>
                            <p class="text-xs text-secondary-500 dark:text-secondary-400">Kemarin, 15:30</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-danger/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-danger" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-secondary-900 dark:text-white">
                                <span class="font-medium">INV-2024-004</span> ditolak
                            </p>
                            <p class="text-xs text-secondary-500 dark:text-secondary-400">Kemarin, 10:15</p>
                        </div>
                    </div>
                </div>
            </x-ui.card>
            
        </div>
        
    </div>
    
</x-layout.app>