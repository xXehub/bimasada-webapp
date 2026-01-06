<x-layout.app>
    <x-slot name="title">Surat Perjanjian Kerjasama (PKS)</x-slot>

    @push('styles')
    <style>
        /* ============================================
           BIMASADA DataTables Custom Styling
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
        #pks-table_wrapper {
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
        #pks-table_wrapper {
            position: relative;
            min-height: auto;
        }
        
        /* Only apply min-height when processing */
        #pks-table_wrapper.processing {
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

        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 0.5rem;
        }
        .overflow-x-auto::-webkit-scrollbar-track {
            background-color: rgb(243 244 246);
            border-radius: 9999px;
        }
        .dark .overflow-x-auto::-webkit-scrollbar-track {
            background-color: rgb(55 65 81);
        }
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background-color: rgb(209 213 219);
            border-radius: 9999px;
        }
        .dark .overflow-x-auto::-webkit-scrollbar-thumb {
            background-color: rgb(75 85 99);
        }

        /* Animation for stats cards */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .stats-card {
            animation: slideUp 0.5s ease-out forwards;
        }
        
        .stats-card:nth-child(1) { animation-delay: 0ms; }
        .stats-card:nth-child(2) { animation-delay: 100ms; }
        .stats-card:nth-child(3) { animation-delay: 200ms; }
        .stats-card:nth-child(4) { animation-delay: 300ms; }
    </style>
    @endpush

    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Surat Perjanjian Kerjasama</h1>
                <p class="mt-1 text-gray-500 dark:text-gray-400">Kelola dan buat Surat Perjanjian Kerjasama (PKS)</p>
            </div>
            <div class="flex items-center gap-3">
                @can('create-pks')
                <x-ui.button variant="primary" x-data @click="$dispatch('open-modal', 'add-pks-modal')">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </x-slot>
                    Buat PKS
                </x-ui.button>
                @endcan
            </div>
        </div>
    </div>

    <!-- Max-width Container for content -->
    <div x-data="pksManagement()" class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total PKS -->
            <x-ui.card class="stats-card overflow-visible">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-primary-500/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total PKS</p>
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

            <!-- Aktif -->
            <x-ui.card class="stats-card overflow-visible">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-500/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['active'] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Aktif</p>
                    </div>
                </div>
            </x-ui.card>

            <!-- Disetujui -->
            <x-ui.card class="stats-card overflow-visible">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-emerald-500/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['approved'] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Disetujui</p>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <!-- Filter Section -->
        <x-ui.card>
            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Status Filter (Kiri) -->
                <div class="w-full lg:w-48">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Status
                    </label>
                    <select 
                        x-model="statusFilter"
                        x-on:change="applyFilter()"
                        class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                    >
                        <option value="">Semua Status</option>
                        <option value="Draft">Draft</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Disetujui">Disetujui</option>
                        <option value="Kadaluarsa">Kadaluarsa</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                    </select>
                </div>

                <!-- Search (Kanan, flex-1) -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Cari
                    </label>
                    <x-ui.input 
                        type="text" 
                        x-model="searchQuery"
                        x-on:input.debounce.300ms="applySearch()"
                        placeholder="Cari nama pelanggan, email, telepon..."
                    >
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </x-slot>
                    </x-ui.input>
                </div>

                <!-- Buttons -->
                <div class="flex items-end gap-2">
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

        <!-- PKS Table with DataTables -->
        <div class="bg-white dark:bg-dark-card rounded-md border border-gray-200 dark:border-dark-border shadow-soft overflow-hidden">
            <!-- Table Header Info -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-dark-border flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-md bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Daftar PKS</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola semua surat perjanjian kerjasama</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400" x-text="tableInfo"></span>
                </div>
            </div>
            
            <!-- Table Container -->
            <div class="overflow-x-auto">
                <table id="pks-table" class="w-full">
                    <thead>
                        <tr>
                            <th>No. PKS</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Nilai Kontrak</th>
                            <th>Status</th>
                            <th>Tanggal Selesai</th>
                            <th>Sales</th>
                            <th class="text-center">Approval</th>
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
    <!-- End Max-width Container -->

    <!-- Add PKS Modal -->
    @include('surat-perjanjians.partials.add-pks-modal', ['salesList' => $salesList ?? []])

    @push('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    
    <script>
        function pksManagement() {
            return {
                searchQuery: '',
                statusFilter: '',
                perPage: '10',
                tableInfo: '',
                dataTable: null,

                init() {
                    this.initDataTable();
                },

                initDataTable() {
                    const self = this;
                    
                    this.dataTable = $('#pks-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{ route("surat-perjanjians.data") }}',
                            data: function(d) {
                                d.status = self.statusFilter;
                                d.search = {
                                    value: self.searchQuery
                                };
                            }
                        },
                        columns: [
                            { 
                                data: 'no_surat_display',
                                render: function(data, type, row) {
                                    return `<span class="font-mono text-sm font-semibold text-primary-600 dark:text-primary-400">${data}</span>`;
                                }
                            },
                            { 
                                data: 'date_display',
                                render: function(data) {
                                    return `<span class="text-gray-900 dark:text-white">${data}</span>`;
                                }
                            },
                            { 
                                data: 'customer_display',
                                render: function(data) {
                                    return `
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-dark-hover flex items-center justify-center flex-shrink-0">
                                                <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">${data.initials}</span>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-medium text-gray-900 dark:text-white truncate">${data.name}</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 truncate">${data.sub || '-'}</p>
                                            </div>
                                        </div>
                                    `;
                                }
                            },
                            { 
                                data: 'contract_value_display',
                                render: function(data) {
                                    return `<span class="font-semibold text-gray-900 dark:text-white">${data}</span>`;
                                }
                            },
                            { 
                                data: 'status_badge',
                                render: function(data) {
                                    const variants = {
                                        'success': 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400',
                                        'warning': 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400',
                                        'info': 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                                        'danger': 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
                                        'secondary': 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300'
                                    };
                                    const variantClass = variants[data.variant] || variants.secondary;
                                    return `
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold ${variantClass}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            ${data.status}
                                        </span>
                                    `;
                                }
                            },
                            { 
                                data: 'end_date_display',
                                render: function(data) {
                                    let html = `<span class="text-gray-900 dark:text-white">${data.date}</span>`;
                                    if (data.is_expired) {
                                        html += ` <span class="inline-flex items-center px-1.5 py-0.5 rounded-md text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400">Expired</span>`;
                                    }
                                    return html;
                                }
                            },
                            { 
                                data: 'sales_name',
                                render: function(data) {
                                    return `<span class="text-gray-700 dark:text-gray-300">${data}</span>`;
                                }
                            },
                            {
                                // Approval column
                                data: 'id',
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    const pksNumber = row.no_surat_display;
                                    const canApprove = @can('approve-pks') true @else false @endcan;
                                    const statusData = row.status_badge;
                                    
                                    // Only show approval buttons for Aktif status and user with permission
                                    if (canApprove && statusData.status === 'Aktif') {
                                        return `
                                            <div class="flex items-center justify-center gap-1">
                                                <button type="button" onclick="window.dispatchEvent(new CustomEvent('approve-pks', { detail: { id: ${data}, number: '${pksNumber}' } }))" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 shadow-sm transition-all" title="Setujui">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    Approve
                                                </button>
                                                <button type="button" onclick="window.dispatchEvent(new CustomEvent('reject-pks', { detail: { id: ${data}, number: '${pksNumber}' } }))" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 shadow-sm transition-all" title="Tolak">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                    Reject
                                                </button>
                                            </div>
                                        `;
                                    }
                                    
                                    // Show status indicator for other statuses
                                    if (statusData.status === 'Disetujui') {
                                        return `<span class="inline-flex items-center gap-1 text-xs text-emerald-600 dark:text-emerald-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Approved</span>`;
                                    } else if (statusData.status === 'Dibatalkan') {
                                        return `<span class="inline-flex items-center gap-1 text-xs text-red-600 dark:text-red-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Rejected</span>`;
                                    }
                                    
                                    return `<span class="text-xs text-gray-400 dark:text-gray-500">-</span>`;
                                }
                            },
                            { 
                                data: 'actions',
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    const pksNumber = row.no_surat_display;
                                    const canDelete = @can('delete-pks') true @else false @endcan;
                                    const canEdit = @can('edit-pks') true @else false @endcan;
                                    
                                    let html = `
                                        <div class="flex items-center justify-center gap-1">
                                            <a href="/surat-perjanjians/${data}" class="p-2 rounded-lg text-gray-500 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors" title="View">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                    `;
                                    
                                    if (canEdit) {
                                        html += `
                                            <a href="/surat-perjanjians/${data}/edit" class="p-2 rounded-lg text-gray-500 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-colors" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        `;
                                    }
                                    
                                    // Print button - use PDF route
                                    html += `
                                        <a href="/pdf/pks/${data}" target="_blank" class="p-2 rounded-lg text-gray-500 hover:text-purple-600 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors" title="Download PDF">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </a>
                                    `;
                                    if (canDelete) {
                                        html += `
                                            <button type="button" onclick="window.dispatchEvent(new CustomEvent('delete-pks', { detail: { id: ${data}, number: '${pksNumber}' } }))" class="p-2 rounded-lg text-gray-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Delete">
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Belum ada PKS</h3>
                                    <p class="text-gray-500 dark:text-gray-400 mb-6 text-center max-w-sm">Mulai dengan membuat Surat Perjanjian Kerjasama pertama Anda.</p>
                                    <a href="{{ route('surat-perjanjians.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary-600 to-primary-500 text-white rounded-lg hover:from-primary-700 hover:to-primary-600 transition-all shadow-lg shadow-primary-600/25 font-medium">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Buat PKS
                                    </a>
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
                                    <p class="text-gray-500 dark:text-gray-400 text-center max-w-sm">Coba sesuaikan pencarian atau filter untuk menemukan yang Anda cari.</p>
                                </div>
                            `,
                            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ PKS",
                            infoEmpty: "Tidak ada PKS tersedia",
                            infoFiltered: "(difilter dari _MAX_ total)",
                            lengthMenu: "Tampilkan _MENU_ data",
                            paginate: {
                                first: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>`,
                                last: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>`,
                                next: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>`,
                                previous: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>`
                            }
                        },
                        dom: 'rt<"dt-footer"ip>',
                        drawCallback: function(settings) {
                            const info = self.dataTable.page.info();
                            if (info.recordsTotal > 0) {
                                self.tableInfo = `${info.start + 1}-${info.end} dari ${info.recordsTotal}`;
                            } else {
                                self.tableInfo = '';
                            }
                        }
                    });

                    // Listen for delete PKS event
                    window.addEventListener('delete-pks', (e) => {
                        this.deletePKS(e.detail.id, e.detail.number);
                    });

                    // Listen for approve PKS event
                    window.addEventListener('approve-pks', (e) => {
                        this.approvePKS(e.detail.id, e.detail.number);
                    });

                    // Listen for reject PKS event
                    window.addEventListener('reject-pks', (e) => {
                        this.rejectPKS(e.detail.id, e.detail.number);
                    });
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
                    this.statusFilter = '';
                    this.perPage = '10';
                    if (this.dataTable) {
                        this.dataTable.page.len(10).ajax.reload();
                    }
                },

                deletePKS(id, pksNumber) {
                    Modal.confirmDelete({
                        itemName: pksNumber,
                        message: 'Apakah Anda yakin ingin menghapus PKS ini? Tindakan ini tidak dapat dibatalkan.',
                        onConfirm: () => {
                            fetch(`/surat-perjanjians/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    this.dataTable.ajax.reload();
                                    Notification.success('Berhasil!', data.message || 'PKS berhasil dihapus');
                                } else {
                                    Notification.error('Gagal!', data.message || 'Gagal menghapus PKS');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Notification.error('Error!', 'Terjadi kesalahan saat menghapus PKS');
                            });
                        }
                    });
                },

                approvePKS(id, pksNumber) {
                    Modal.confirm({
                        title: 'Setujui PKS',
                        message: `Apakah Anda yakin ingin menyetujui PKS "${pksNumber}"?`,
                        confirmText: 'Ya, Setujui',
                        cancelText: 'Batal',
                        variant: 'success',
                        onConfirm: () => {
                            fetch(`/surat-perjanjians/${id}/approve`, {
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
                                    this.dataTable.ajax.reload();
                                    Notification.success('Berhasil!', data.message || 'PKS berhasil disetujui');
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
                },

                rejectPKS(id, pksNumber) {
                    Modal.confirm({
                        title: 'Tolak PKS',
                        message: `Apakah Anda yakin ingin menolak PKS "${pksNumber}"? PKS akan dibatalkan dan tidak dapat diproses lebih lanjut.`,
                        confirmText: 'Ya, Tolak',
                        cancelText: 'Batal',
                        variant: 'danger',
                        onConfirm: () => {
                            fetch(`/surat-perjanjians/${id}/reject`, {
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
                                    this.dataTable.ajax.reload();
                                    Notification.success('Berhasil!', data.message || 'PKS berhasil ditolak');
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
            }
        }
    </script>
    @endpush
</x-layout.app>
