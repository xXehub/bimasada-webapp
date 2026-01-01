<x-layout.app>
    <x-slot name="title">Daftar Kuitansi</x-slot>

    @push('styles')
    <style>
        /* Custom DataTables Styling */
        .dataTables_wrapper {
            font-family: inherit;
        }
        
        .dataTables_filter,
        .dataTables_length {
            display: none !important;
        }
        
        #kuitansi-table thead th {
            padding: 0.875rem 1rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
            border-bottom: 1px solid;
        }
        
        .light #kuitansi-table thead th,
        :root:not(.dark) #kuitansi-table thead th {
            background-color: rgb(249 250 251);
            color: rgb(75 85 99);
            border-color: rgb(229 231 235);
        }
        
        .dark #kuitansi-table thead th {
            background-color: rgb(30 32 38);
            color: rgb(209 213 219);
            border-color: rgb(55 65 81);
        }
        
        #kuitansi-table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid;
        }
        
        .light #kuitansi-table tbody td,
        :root:not(.dark) #kuitansi-table tbody td {
            border-color: rgb(243 244 246);
        }
        
        .dark #kuitansi-table tbody td {
            border-color: rgb(55 65 81);
        }
        
        #kuitansi-table tbody tr {
            transition: background-color 0.15s ease;
        }
        
        .light #kuitansi-table tbody tr,
        :root:not(.dark) #kuitansi-table tbody tr {
            background-color: white;
        }
        
        .light #kuitansi-table tbody tr:hover,
        :root:not(.dark) #kuitansi-table tbody tr:hover {
            background-color: rgb(249 250 251);
        }
        
        .dark #kuitansi-table tbody tr {
            background-color: rgb(24 26 32);
        }
        
        .dark #kuitansi-table tbody tr:hover {
            background-color: rgb(30 32 38);
        }

        /* Sorting Icons */
        #kuitansi-table thead th.sorting,
        #kuitansi-table thead th.sorting_asc,
        #kuitansi-table thead th.sorting_desc {
            cursor: pointer;
            position: relative;
            padding-right: 1.75rem;
        }
        
        #kuitansi-table thead th.sorting::after,
        #kuitansi-table thead th.sorting_asc::after,
        #kuitansi-table thead th.sorting_desc::after {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.75rem;
            opacity: 0.5;
        }
        
        #kuitansi-table thead th.sorting::after { content: "⇅"; }
        #kuitansi-table thead th.sorting_asc::after { content: "↑"; opacity: 1; }
        #kuitansi-table thead th.sorting_desc::after { content: "↓"; opacity: 1; }
        
        .light #kuitansi-table thead th.sorting_asc::after,
        .light #kuitansi-table thead th.sorting_desc::after,
        :root:not(.dark) #kuitansi-table thead th.sorting_asc::after,
        :root:not(.dark) #kuitansi-table thead th.sorting_desc::after {
            color: rgb(79 70 229);
        }
        
        .dark #kuitansi-table thead th.sorting_asc::after,
        .dark #kuitansi-table thead th.sorting_desc::after {
            color: rgb(129 140 248);
        }

        /* Pagination */
        .dataTables_info {
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
        }
        
        .light .dataTables_info,
        :root:not(.dark) .dataTables_info {
            color: rgb(107 114 128);
        }
        
        .dark .dataTables_info {
            color: rgb(156 163 175);
        }

        .dataTables_paginate {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            padding: 1rem 1.5rem;
        }
        
        .dataTables_paginate .paginate_button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.25rem;
            height: 2.25rem;
            padding: 0 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.15s ease;
            border: none !important;
            background: transparent !important;
        }
        
        .light .dataTables_paginate .paginate_button,
        :root:not(.dark) .dataTables_paginate .paginate_button {
            color: rgb(75 85 99);
        }
        
        .light .dataTables_paginate .paginate_button:hover:not(.disabled):not(.current),
        :root:not(.dark) .dataTables_paginate .paginate_button:hover:not(.disabled):not(.current) {
            background-color: rgb(243 244 246) !important;
            color: rgb(17 24 39);
        }
        
        .dark .dataTables_paginate .paginate_button {
            color: rgb(156 163 175);
        }
        
        .dark .dataTables_paginate .paginate_button:hover:not(.disabled):not(.current) {
            background-color: rgb(55 65 81) !important;
            color: white;
        }
        
        .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, rgb(79 70 229) 0%, rgb(99 102 241) 100%) !important;
            color: white !important;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.25);
        }
        
        .dataTables_paginate .paginate_button.disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        /* Footer Area */
        .dt-footer {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding: 1rem 1.5rem;
            border-top: 1px solid;
        }
        
        @media (min-width: 640px) {
            .dt-footer {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }
        
        .light .dt-footer,
        :root:not(.dark) .dt-footer {
            border-color: rgb(229 231 235);
            background-color: rgb(249 250 251);
        }
        
        .dark .dt-footer {
            border-color: rgb(55 65 81);
            background-color: rgb(24 26 32);
        }

        /* Processing Indicator */
        .dataTables_processing {
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            margin: 0 !important;
            padding: 2rem 3rem !important;
            border-radius: 0.75rem !important;
            z-index: 1000 !important;
        }
        
        .light .dataTables_processing,
        :root:not(.dark) .dataTables_processing {
            background-color: white;
            color: rgb(75 85 99);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .dark .dataTables_processing {
            background-color: rgb(30 32 38);
            color: rgb(156 163 175);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
        }

        /* Animation for stats cards */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .stats-card {
            animation: slideUp 0.5s ease-out forwards;
        }
        
        .stats-card:nth-child(1) { animation-delay: 0ms; }
        .stats-card:nth-child(2) { animation-delay: 100ms; }
        .stats-card:nth-child(3) { animation-delay: 200ms; }
        .stats-card:nth-child(4) { animation-delay: 300ms; }
        .stats-card:nth-child(5) { animation-delay: 400ms; }
    </style>
    @endpush

    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Daftar Kuitansi</h1>
                <p class="mt-1 text-gray-500 dark:text-gray-400">Kelola kuitansi pembayaran pelanggan</p>
            </div>
            <div class="flex items-center gap-3">
                @can('create-kuitansi')
                <x-ui.button variant="secondary" x-data @click="openAddKuitansiModal()">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </x-slot>
                    Kuitansi Cepat
                </x-ui.button>
                <x-ui.button variant="primary" href="{{ route('kuitansis.create') }}">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </x-slot>
                    Buat Kuitansi
                </x-ui.button>
                @endcan
            </div>
        </div>
    </div>

    <div x-data="kuitansiManagement()" class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Total Kuitansi -->
            <x-ui.card class="stats-card overflow-visible">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-primary-500/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Kuitansi</p>
                    </div>
                </div>
            </x-ui.card>

            <!-- Draft -->
            <x-ui.card class="stats-card overflow-visible">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center flex-shrink-0 shadow-lg shadow-gray-500/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['draft'] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Draft</p>
                    </div>
                </div>
            </x-ui.card>

            <!-- Terkirim -->
            <x-ui.card class="stats-card overflow-visible">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-500/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['terkirim'] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Terkirim</p>
                    </div>
                </div>
            </x-ui.card>

            <!-- Lunas -->
            <x-ui.card class="stats-card overflow-visible">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-emerald-500/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['lunas'] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Lunas</p>
                    </div>
                </div>
            </x-ui.card>

            <!-- Total Nilai -->
            <x-ui.card class="stats-card overflow-visible">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-amber-500/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">Rp {{ number_format($stats['total_nilai'], 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Nilai</p>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <!-- Filter Section -->
        <x-ui.card>
            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Status Filter -->
                <div class="w-full lg:w-48">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Status</label>
                    <select 
                        x-model="statusFilter"
                        @change="applyFilter()"
                        class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                    >
                        <option value="">Semua Status</option>
                        <option value="Draft">Draft</option>
                        <option value="Terkirim">Terkirim</option>
                        <option value="Lunas">Lunas</option>
                        <option value="Batal">Batal</option>
                    </select>
                </div>

                <!-- Date From -->
                <div class="w-full lg:w-48">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Tanggal Dari</label>
                    <input 
                        type="date" 
                        x-model="dateFrom"
                        @change="applyFilter()"
                        class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                    >
                </div>

                <!-- Date To -->
                <div class="w-full lg:w-48">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Tanggal Sampai</label>
                    <input 
                        type="date" 
                        x-model="dateTo"
                        @change="applyFilter()"
                        class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                    >
                </div>

                <!-- Search -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Cari</label>
                    <x-ui.input 
                        type="text" 
                        x-model="searchQuery"
                        @input.debounce.300ms="applySearch()"
                        placeholder="Cari nama pelanggan, no. kuitansi..."
                    >
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </x-slot>
                    </x-ui.input>
                </div>

                <!-- Reset Button -->
                <div class="flex items-end">
                    <x-ui.button variant="ghost" @click="resetFilters()">
                        <x-slot name="icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </x-slot>
                        Reset
                    </x-ui.button>
                </div>
            </div>
        </x-ui.card>

        <!-- Kuitansi Table -->
        <div class="bg-white dark:bg-dark-card rounded-xl border border-gray-200 dark:border-dark-border shadow-soft overflow-hidden">
            <!-- Table Header Info -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-dark-border flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Daftar Kuitansi</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola semua kuitansi pembayaran</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400" x-text="tableInfo"></span>
                </div>
            </div>
            
            <!-- Table Container -->
            <div class="overflow-x-auto">
                <table id="kuitansi-table" class="w-full">
                    <thead>
                        <tr>
                            <th>No. Kuitansi</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Invoice</th>
                            <th>Pembayaran</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables will populate this -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Kuitansi Modal -->
    @include('kuitansis.partials.add-kuitansi-modal')

    @push('scripts')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    
    <script>
        function kuitansiManagement() {
            return {
                searchQuery: '',
                statusFilter: '',
                dateFrom: '',
                dateTo: '',
                tableInfo: '',
                dataTable: null,

                init() {
                    this.initDataTable();
                },

                initDataTable() {
                    const self = this;
                    
                    this.dataTable = $('#kuitansi-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{ route("kuitansis.data") }}',
                            data: function(d) {
                                d.status = self.statusFilter;
                                d.date_from = self.dateFrom;
                                d.date_to = self.dateTo;
                                d.search = { value: self.searchQuery };
                            }
                        },
                        columns: [
                            { 
                                data: 'no_kuitansi_display',
                                render: function(data) {
                                    return `<span class="font-mono text-sm font-semibold text-primary-600 dark:text-primary-400">${data}</span>`;
                                }
                            },
                            { 
                                data: 'tanggal_kuitansi',
                                render: function(data) {
                                    return `<span class="text-gray-900 dark:text-white">${data}</span>`;
                                }
                            },
                            { 
                                data: 'customer_display',
                                render: function(data, type, row) {
                                    const initials = row.nama_pelanggan ? row.nama_pelanggan.substring(0, 2).toUpperCase() : '??';
                                    return `
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-dark-hover flex items-center justify-center flex-shrink-0">
                                                <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">${initials}</span>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-medium text-gray-900 dark:text-white truncate">${row.nama_pelanggan}</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 truncate">${row.no_telp || '-'}</p>
                                            </div>
                                        </div>
                                    `;
                                }
                            },
                            { data: 'invoice_display' },
                            { data: 'payment_method' },
                            { 
                                data: 'total_display',
                                render: function(data) {
                                    return `<span class="font-semibold text-gray-900 dark:text-white">${data}</span>`;
                                }
                            },
                            { data: 'status_badge' },
                            { 
                                data: 'id',
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    const canDelete = @can('delete-kuitansi') true @else false @endcan;
                                    const canEdit = @can('edit-kuitansi') true @else false @endcan;
                                    const status = row.status_kuitansi;
                                    
                                    let html = `
                                        <div class="flex items-center justify-center gap-1">
                                            <a href="/kuitansis/${data}" class="p-2 rounded-lg text-gray-500 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors" title="View">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                    `;
                                    
                                    if (canEdit) {
                                        html += `
                                            <a href="/kuitansis/${data}/edit" class="p-2 rounded-lg text-gray-500 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-colors" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        `;
                                    }

                                    // Mark Lunas button for Terkirim status
                                    if (status === 'Terkirim' && canEdit) {
                                        html += `
                                            <button onclick="markLunas(${data})" class="p-2 rounded-lg text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors" title="Tandai Lunas">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </button>
                                        `;
                                    }

                                    // Print button
                                    html += `
                                        <a href="/kuitansis/${data}?print=true" target="_blank" class="p-2 rounded-lg text-gray-500 hover:text-purple-600 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors" title="Print">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                            </svg>
                                        </a>
                                    `;
                                    
                                    if (canDelete) {
                                        html += `
                                            <button onclick="deleteKuitansi(${data})" class="p-2 rounded-lg text-gray-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        `;
                                    }
                                    
                                    html += '</div>';
                                    return html;
                                }
                            }
                        ],
                        order: [[1, 'desc']],
                        pageLength: 10,
                        language: {
                            processing: '<div class="flex items-center gap-3"><div class="animate-spin w-5 h-5 border-2 border-primary-600 border-t-transparent rounded-full"></div><span>Memuat data...</span></div>',
                            emptyTable: '<div class="py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada data kuitansi</div>',
                            info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
                            infoEmpty: 'Tidak ada data',
                            infoFiltered: '(difilter dari _MAX_ total data)',
                            lengthMenu: 'Tampilkan _MENU_ data',
                            zeroRecords: 'Tidak ada data yang cocok',
                            paginate: {
                                first: '«',
                                last: '»',
                                next: '›',
                                previous: '‹'
                            }
                        },
                        drawCallback: function(settings) {
                            self.tableInfo = `${settings._iDisplayStart + 1} - ${settings._iDisplayStart + settings._iDisplayLength > settings.fnRecordsDisplay() ? settings.fnRecordsDisplay() : settings._iDisplayStart + settings._iDisplayLength} dari ${settings.fnRecordsDisplay()} data`;
                        },
                        dom: '<"dt-top"<"dt-length"l><"dt-search"f>>rt<"dt-footer"<"dt-info"i><"dt-paging"p>>'
                    });
                },

                applyFilter() {
                    if (this.dataTable) {
                        this.dataTable.ajax.reload();
                    }
                },

                applySearch() {
                    if (this.dataTable) {
                        this.dataTable.search(this.searchQuery).draw();
                    }
                },

                resetFilters() {
                    this.searchQuery = '';
                    this.statusFilter = '';
                    this.dateFrom = '';
                    this.dateTo = '';
                    if (this.dataTable) {
                        this.dataTable.search('').ajax.reload();
                    }
                }
            }
        }

        function deleteKuitansi(id) {
            if (confirm('Apakah Anda yakin ingin menghapus kuitansi ini?')) {
                fetch(`/kuitansis/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.dispatchEvent(new CustomEvent('notify', { 
                            detail: { type: 'success', message: data.message }
                        }));
                        $('#kuitansi-table').DataTable().ajax.reload();
                    } else {
                        window.dispatchEvent(new CustomEvent('notify', { 
                            detail: { type: 'error', message: data.message || 'Gagal menghapus kuitansi' }
                        }));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    window.dispatchEvent(new CustomEvent('notify', { 
                        detail: { type: 'error', message: 'Terjadi kesalahan saat menghapus kuitansi' }
                    }));
                });
            }
        }

        function markLunas(id) {
            if (confirm('Apakah Anda yakin ingin menandai kuitansi ini sebagai Lunas?')) {
                fetch(`/kuitansis/${id}/mark-lunas`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.dispatchEvent(new CustomEvent('notify', { 
                            detail: { type: 'success', message: data.message }
                        }));
                        $('#kuitansi-table').DataTable().ajax.reload();
                    } else {
                        window.dispatchEvent(new CustomEvent('notify', { 
                            detail: { type: 'error', message: data.message || 'Gagal mengubah status' }
                        }));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    window.dispatchEvent(new CustomEvent('notify', { 
                        detail: { type: 'error', message: 'Terjadi kesalahan saat mengubah status' }
                    }));
                });
            }
        }

        function openAddKuitansiModal() {
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'add-kuitansi-modal' }));
            // Generate kuitansi number
            fetch('{{ route("kuitansis.generateNumber") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modal_no_kuitansi').value = data.no_kuitansi;
                });
        }
    </script>
    @endpush
</x-layout.app>
