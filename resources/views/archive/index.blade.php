<x-layout.app title="Document Archive">
    @push('styles')
    <style>
        /* ============================================
           BIMASADA Archive DataTables Custom Styling
           Matching global design system
        ============================================ */
        
        /* Keyframe Animations */
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        
        .animate-spin {
            animation: spin 1s linear infinite;
        }
        
        /* Hide default DataTables elements we're replacing */
        .dataTables_filter,
        .dataTables_length {
            display: none !important;
        }
        
        /* Table Container */
        #archive-table_wrapper {
            width: 100%;
        }
        
        /* Table Base Styling */
        table.dataTable {
            width: 100% !important;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        /* Table Header */
        table.dataTable thead th {
            padding: 0.875rem 1rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
            border-bottom: 1px solid;
        }
        
        .light table.dataTable thead th,
        :root:not(.dark) table.dataTable thead th {
            background-color: rgb(249 250 251);
            color: rgb(75 85 99);
            border-color: rgb(229 231 235);
        }
        
        .dark table.dataTable thead th {
            background-color: rgb(30 32 38);
            color: rgb(209 213 219);
            border-color: rgb(55 65 81);
        }
        
        /* Table Body */
        table.dataTable tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid;
        }
        
        .light table.dataTable tbody td,
        :root:not(.dark) table.dataTable tbody td {
            border-color: rgb(243 244 246);
        }
        
        .dark table.dataTable tbody td {
            border-color: rgb(55 65 81);
        }
        
        /* Table Rows */
        table.dataTable tbody tr {
            transition: background-color 0.15s ease;
        }
        
        .light table.dataTable tbody tr,
        :root:not(.dark) table.dataTable tbody tr {
            background-color: white;
        }
        
        .light table.dataTable tbody tr:hover,
        :root:not(.dark) table.dataTable tbody tr:hover {
            background-color: rgb(249 250 251);
        }
        
        .dark table.dataTable tbody tr {
            background-color: rgb(24 26 32);
        }
        
        .dark table.dataTable tbody tr:hover {
            background-color: rgb(30 32 38);
        }
        
        /* Sorting Icons */
        table.dataTable thead th.sorting,
        table.dataTable thead th.sorting_asc,
        table.dataTable thead th.sorting_desc {
            cursor: pointer;
            position: relative;
            padding-right: 1.75rem;
        }
        
        table.dataTable thead th.sorting::after,
        table.dataTable thead th.sorting_asc::after,
        table.dataTable thead th.sorting_desc::after {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.75rem;
            opacity: 0.5;
        }
        
        table.dataTable thead th.sorting::after {
            content: "⇅";
        }
        
        table.dataTable thead th.sorting_asc::after {
            content: "↑";
            opacity: 1;
        }
        
        .light table.dataTable thead th.sorting_asc::after,
        :root:not(.dark) table.dataTable thead th.sorting_asc::after {
            color: rgb(79 70 229);
        }
        
        .dark table.dataTable thead th.sorting_asc::after {
            color: rgb(129 140 248);
        }
        
        table.dataTable thead th.sorting_desc::after {
            content: "↓";
            opacity: 1;
        }
        
        .light table.dataTable thead th.sorting_desc::after,
        :root:not(.dark) table.dataTable thead th.sorting_desc::after {
            color: rgb(79 70 229);
        }
        
        .dark table.dataTable thead th.sorting_desc::after {
            color: rgb(129 140 248);
        }
        
        /* Info Text */
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
        
        /* Pagination Container */
        .dataTables_paginate {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            padding: 1rem 1.5rem;
        }
        
        /* Pagination Buttons */
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
        
        /* Current Page Button */
        .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, rgb(79 70 229) 0%, rgb(99 102 241) 100%) !important;
            color: white !important;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.25);
        }
        
        /* Disabled Pagination */
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
        
        /* Processing Indicator - Loading State */
        .dataTables_wrapper {
            position: relative;
        }
        
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
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .dark .dataTables_processing {
            background-color: rgb(30 32 38);
            color: rgb(156 163 175);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
        }
        
        /* Table wrapper relative positioning for loading */
        #archive-table_wrapper {
            position: relative;
            min-height: auto;
        }
        
        /* Only apply min-height when processing */
        #archive-table_wrapper.processing {
            min-height: 400px;
        }
        
        /* Empty Table State */
        .dataTables_empty {
            padding: 3rem !important;
            text-align: center;
        }
        
        /* Remove default DataTables borders */
        table.dataTable.no-footer {
            border-bottom: none;
        }
        
        table.dataTable.stripe tbody tr.odd,
        table.dataTable.display tbody tr.odd {
            background-color: transparent;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            table.dataTable thead th,
            table.dataTable tbody td {
                padding: 0.75rem 0.5rem;
            }
            
            .dataTables_paginate {
                justify-content: center;
                flex-wrap: wrap;
            }
        }
        
        /* Filter tabs */
        .filter-tab {
            transition: all 0.15s ease;
            border-bottom: 2px solid transparent;
        }
        
        .filter-tab:hover {
            border-color: rgb(209 213 219);
        }
        
        .dark .filter-tab:hover {
            border-color: rgb(75 85 99);
        }
        
        .filter-tab.active {
            border-color: rgb(79 70 229) !important;
            color: rgb(79 70 229) !important;
        }
        
        .dark .filter-tab.active {
            border-color: rgb(129 140 248) !important;
            color: rgb(129 140 248) !important;
        }
    </style>
    @endpush

    <!-- Main Content Container -->
    <div class="mb-8">
        <div x-data="archiveManagement()" class="space-y-8">
            
            <!-- Page Header -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Document Archive</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Arsip semua dokumen PKS, Invoice, dan Kuitansi</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('archive.relations') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        Lihat Relasi
                    </a>
                    <button type="button" x-on:click="exportData()"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Export CSV
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <x-ui.card class="!p-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-md bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Dokumen</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_documents']) }}</p>
                        </div>
                    </div>
                </x-ui.card>
                
                <x-ui.card class="!p-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-md bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">PKS</p>
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($stats['pks']['total']) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $stats['pks']['active'] }} aktif</p>
                        </div>
                    </div>
                </x-ui.card>
                
                <x-ui.card class="!p-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-md bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Invoice</p>
                            <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($stats['invoice']['total']) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $stats['invoice']['paid'] }} lunas</p>
                        </div>
                    </div>
                </x-ui.card>
                
                <x-ui.card class="!p-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-md bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Revenue</p>
                            <p class="text-xl font-bold text-amber-600 dark:text-amber-400">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </x-ui.card>
            </div>

            <!-- Filters & Search -->
            <x-ui.card>
                <!-- Type Tabs -->
                <div class="border-b border-gray-200 dark:border-gray-700 -mx-6 -mt-6 px-6 mb-4">
                    <nav class="flex -mb-px" aria-label="Document Types">
                        <button type="button" x-on:click="changeType('all')" :class="{ 'active': typeFilter === 'all' }" class="filter-tab px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            Semua
                        </button>
                        <button type="button" x-on:click="changeType('pks')" :class="{ 'active': typeFilter === 'pks' }" class="filter-tab px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            PKS
                        </button>
                        <button type="button" x-on:click="changeType('invoice')" :class="{ 'active': typeFilter === 'invoice' }" class="filter-tab px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            Invoice
                        </button>
                        <button type="button" x-on:click="changeType('kuitansi')" :class="{ 'active': typeFilter === 'kuitansi' }" class="filter-tab px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            Kuitansi
                        </button>
                    </nav>
                </div>
                
                <!-- Advanced Filters -->
                <div class="flex flex-col lg:flex-row gap-4">
                    <!-- Per Page -->
                    <div class="w-full lg:w-32">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Show entries
                        </label>
                        <input 
                            type="number"
                            x-model="perPage"
                            x-on:blur="changePageLength()"
                            x-on:keyup.enter="changePageLength()"
                            min="1"
                            max="1000"
                            placeholder="10"
                            class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                        >
                    </div>

                    <!-- Date From -->
                    <div class="w-full lg:w-44">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Dari Tanggal
                        </label>
                        <input type="date" x-model="dateFrom" x-on:change="applyFilter()"
                               class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                    </div>

                    <!-- Date To -->
                    <div class="w-full lg:w-44">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Sampai Tanggal
                        </label>
                        <input type="date" x-model="dateTo" x-on:change="applyFilter()"
                               class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                    </div>

                    @if($salesList->count() > 0)
                    <!-- Sales Filter -->
                    <div class="w-full lg:w-48">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Sales
                        </label>
                        <select x-model="salesFilter" x-on:change="applyFilter()"
                                class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                            <option value="">Semua Sales</option>
                            @foreach($salesList as $sales)
                                <option value="{{ $sales->id }}">{{ $sales->nama_sales }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <!-- Search -->
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Search
                        </label>
                        <x-ui.input 
                            type="text" 
                            x-model="searchQuery"
                            x-on:input.debounce.300ms="applySearch()"
                            placeholder="Cari nomor dokumen, pelanggan..."
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
                        <x-ui.button variant="ghost" x-on:click="resetFilters()">
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

            <!-- Archive Table with DataTables -->
            <div class="bg-white dark:bg-dark-card rounded-md border border-gray-200 dark:border-dark-border shadow-soft overflow-hidden">
                <!-- Table Header Info -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-dark-border flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-md bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Daftar Dokumen</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Lihat dan kelola semua dokumen arsip</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500 dark:text-gray-400" x-text="tableInfo"></span>
                    </div>
                </div>
                
                <!-- Table Container -->
                <div class="overflow-x-auto">
                    <table id="archive-table" class="w-full">
                        <thead>
                            <tr>
                                <th>Tipe</th>
                                <th>Nomor</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Nilai</th>
                                <th>Status</th>
                                <th>Sales</th>
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
    </div>

    @push('scripts')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        function archiveManagement() {
            return {
                searchQuery: '',
                typeFilter: 'all',
                dateFrom: '',
                dateTo: '',
                salesFilter: '',
                perPage: '10',
                tableInfo: '',
                dataTable: null,

                init() {
                    this.initDataTable();
                },

                initDataTable() {
                    const self = this;
                    
                    this.dataTable = $('#archive-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{ route("archive.data") }}',
                            data: function(d) {
                                d.type = self.typeFilter;
                                d.date_from = self.dateFrom;
                                d.date_to = self.dateTo;
                                d.sales_id = self.salesFilter;
                                d.search = {
                                    value: self.searchQuery
                                };
                            }
                        },
                        columns: [
                            { 
                                data: 'type_badge',
                                orderable: false,
                                render: function(data) {
                                    const types = {
                                        'PKS': 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                                        'Invoice': 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400',
                                        'Kuitansi': 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400'
                                    };
                                    const typeClass = types[data] || 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300';
                                    return `<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold ${typeClass}">${data}</span>`;
                                }
                            },
                            { 
                                data: 'number',
                                render: function(data) {
                                    return `<span class="font-mono text-sm font-semibold text-primary-600 dark:text-primary-400">${data}</span>`;
                                }
                            },
                            { 
                                data: 'date',
                                render: function(data) {
                                    return `<span class="text-gray-900 dark:text-white">${data}</span>`;
                                }
                            },
                            { 
                                data: 'customer',
                                render: function(data) {
                                    const initials = data ? data.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase() : '??';
                                    return `
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-dark-hover flex items-center justify-center flex-shrink-0">
                                                <span class="text-xs font-semibold text-gray-600 dark:text-gray-300">${initials}</span>
                                            </div>
                                            <span class="font-medium text-gray-900 dark:text-white truncate">${data || '-'}</span>
                                        </div>
                                    `;
                                }
                            },
                            { 
                                data: 'amount_formatted',
                                render: function(data) {
                                    return `<span class="font-semibold text-gray-900 dark:text-white">${data}</span>`;
                                }
                            },
                            { 
                                data: 'status_badge',
                                orderable: false,
                                render: function(data) {
                                    // Parse status badge HTML or return as is
                                    return data;
                                }
                            },
                            { 
                                data: 'sales',
                                render: function(data) {
                                    return `<span class="text-gray-700 dark:text-gray-300">${data || '-'}</span>`;
                                }
                            },
                            { 
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    return `
                                        <div class="flex items-center justify-center gap-1">
                                            <a href="${row.url}" class="p-2 rounded-lg text-gray-500 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors" title="Lihat">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <a href="${row.edit_url}" class="p-2 rounded-lg text-gray-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    `;
                                }
                            }
                        ],
                        order: [[2, 'desc']],
                        pageLength: 10,
                        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                        language: {
                            processing: `
                                <div class="flex items-center justify-center gap-3 py-8">
                                    <div class="relative">
                                        <div class="w-10 h-10 rounded-full border-4 border-primary-200 dark:border-primary-900"></div>
                                        <div class="absolute top-0 left-0 w-10 h-10 rounded-full border-4 border-transparent border-t-primary-600 animate-spin"></div>
                                    </div>
                                    <span class="text-gray-600 dark:text-gray-400 font-medium">Loading...</span>
                                </div>
                            `,
                            emptyTable: `
                                <div class="flex flex-col items-center justify-center py-16">
                                    <div class="w-20 h-20 rounded-xl bg-gradient-to-br from-gray-100 to-gray-50 dark:from-gray-800 dark:to-gray-900 flex items-center justify-center mb-5 shadow-inner">
                                        <svg class="w-10 h-10 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Belum ada dokumen</h3>
                                    <p class="text-gray-500 dark:text-gray-400 mb-6 text-center max-w-sm">Mulai dengan membuat dokumen PKS, Invoice, atau Kuitansi baru.</p>
                                </div>
                            `,
                            zeroRecords: `
                                <div class="flex flex-col items-center justify-center py-16">
                                    <div class="w-20 h-20 rounded-xl bg-gradient-to-br from-amber-100 to-amber-50 dark:from-amber-900/30 dark:to-amber-900/10 flex items-center justify-center mb-5">
                                        <svg class="w-10 h-10 text-amber-500 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Tidak ada hasil</h3>
                                    <p class="text-gray-500 dark:text-gray-400 text-center max-w-sm">Coba sesuaikan pencarian atau filter untuk menemukan dokumen.</p>
                                </div>
                            `,
                            info: "Menampilkan _START_ - _END_ dari _TOTAL_ dokumen",
                            infoEmpty: "Tidak ada dokumen",
                            infoFiltered: "(difilter dari _MAX_ total)",
                            lengthMenu: "Tampilkan _MENU_ entri",
                            paginate: {
                                first: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>`,
                                last: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>`,
                                next: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>`,
                                previous: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>`
                            }
                        },
                        dom: 'rt<"dt-footer"ip>',
                        drawCallback: function(settings) {
                            // Update table info
                            const info = self.dataTable.page.info();
                            if (info.recordsTotal > 0) {
                                self.tableInfo = `${info.start + 1}-${info.end} of ${info.recordsTotal}`;
                            } else {
                                self.tableInfo = '';
                            }
                        }
                    });
                },

                changeType(type) {
                    this.typeFilter = type;
                    this.applyFilter();
                },

                applySearch() {
                    if (this.dataTable) {
                        this.dataTable.ajax.reload();
                    }
                },

                applyFilter() {
                    if (this.dataTable) {
                        this.dataTable.ajax.reload();
                    }
                },

                changePageLength() {
                    if (this.dataTable) {
                        const length = parseInt(this.perPage) || 10;
                        this.dataTable.page.len(length).draw();
                    }
                },

                resetFilters() {
                    this.searchQuery = '';
                    this.typeFilter = 'all';
                    this.dateFrom = '';
                    this.dateTo = '';
                    this.salesFilter = '';
                    this.perPage = '10';
                    if (this.dataTable) {
                        this.dataTable.page.len(10).ajax.reload();
                    }
                },

                exportData() {
                    const params = new URLSearchParams({
                        type: this.typeFilter,
                        date_from: this.dateFrom,
                        date_to: this.dateTo,
                        sales_id: this.salesFilter
                    });
                    window.location.href = '{{ route("archive.export") }}?' + params.toString();
                }
            }
        }
    </script>
    @endpush
</x-layout.app>
