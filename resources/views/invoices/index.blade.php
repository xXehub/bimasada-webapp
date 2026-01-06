<x-layout.app title="Invoice Management">
    @push('styles')
    <!-- DataTables CSS - Using minimal CSS, custom styling below -->
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
        #invoices-table_wrapper {
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
        #invoices-table_wrapper {
            position: relative;
            min-height: auto;
        }
        
        /* Only apply min-height when processing */
        #invoices-table_wrapper.processing {
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
    </style>
    @endpush

    <!-- Max-width Container for 80% layout -->
    <div class="mb-8">
        <div x-data="invoiceManagement()" class="space-y-8">
            
            <!-- Page Header -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Invoice Management</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Manage and track all your invoices</p>
                </div>
            <div class="flex flex-wrap gap-3">
                <!-- Quick Modal Button -->
                <x-ui.button 
                    variant="success" 
                    x-on:click="$dispatch('open-modal', 'add-invoice')"
                >
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </x-slot>
                    Quick Add
                </x-ui.button>
                
                <x-ui.button variant="primary" href="{{ route('invoices.input') }}">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </x-slot>
                    Input Invoice
                </x-ui.button>
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
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Invoices</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </x-ui.card>
            
            <x-ui.card class="!p-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-md bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Paid</p>
                        <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $stats['paid'] }}</p>
                    </div>
                </div>
            </x-ui.card>
            
            <x-ui.card class="!p-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-md bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pending</p>
                        <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $stats['pending'] }}</p>
                    </div>
                </div>
            </x-ui.card>
            
            <x-ui.card class="!p-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-md bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Installment</p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['installment'] }}</p>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <!-- Filters & Search -->
        <x-ui.card>
            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Per Page (Kiri) -->
                <div class="w-full lg:w-48">
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

                <!-- Status Filter -->
                <div class="w-full lg:w-48">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Status
                    </label>
                    <select 
                        x-model="statusFilter"
                        x-on:change="applyFilter()"
                        class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                    >
                        <option value="">All Status</option>
                        <option value="Lunas">Lunas</option>
                        <option value="Belum Lunas">Belum Lunas</option>
                        <option value="Cicilan">Cicilan</option>
                        <option value="Revisi">Revisi</option>
                    </select>
                </div>

                <!-- Search (Kanan, flex-1) -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Search
                    </label>
                    <x-ui.input 
                        type="text" 
                        x-model="searchQuery"
                        x-on:input.debounce.300ms="applySearch()"
                        placeholder="Search by customer name, email, phone..."
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

        <!-- Invoice Table with DataTables -->
        <div class="bg-white dark:bg-dark-card rounded-md border border-gray-200 dark:border-dark-border shadow-soft overflow-hidden">
            <!-- Table Header Info -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-dark-border flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-md bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Invoice List</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">View and manage all invoices</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400" x-text="tableInfo"></span>
                </div>
            </div>
            
            <!-- Table Container -->
            <div class="overflow-x-auto">
                <table id="invoices-table" class="w-full">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Sales</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables will populate this -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Delete Confirmation Modal - Using Reusable Component -->
        <!-- Modal will be handled by JavaScript -->
    </div>
    <!-- End Max-width Container -->

    <!-- Add Invoice Modal -->
    @include('invoices.partials.add-invoice-modal', ['salesList' => $salesList ?? []])

    @push('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    
    <script>
        function invoiceManagement() {
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
                    
                    this.dataTable = $('#invoices-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{ route("invoices.data") }}',
                            data: function(d) {
                                // Send custom filters to server
                                d.status = self.statusFilter;
                                d.search = {
                                    value: self.searchQuery
                                };
                            }
                        },
                        columns: [
                            { 
                                data: 'invoice_number_display',
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
                                data: 'amount_display',
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
                                        'danger': 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400',
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
                                data: 'due_date_display',
                                render: function(data) {
                                    let html = `<span class="text-gray-900 dark:text-white">${data.date}</span>`;
                                    if (data.is_overdue) {
                                        html += ` <span class="inline-flex items-center px-1.5 py-0.5 rounded-md text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400">Overdue</span>`;
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
                                data: 'actions',
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    const invoiceNumber = row.invoice_number_display;
                                    const canDelete = @can('delete-invoices') true @else false @endcan;
                                    
                                    let html = `
                                        <div class="flex items-center justify-center gap-1">
                                            <a href="/invoices/${data}" class="p-2 rounded-lg text-gray-500 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors" title="View">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <a href="/invoices/${data}/edit" class="p-2 rounded-lg text-gray-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                    `;
                                    
                                    if (canDelete) {
                                        html += `
                                            <button type="button" onclick="window.dispatchEvent(new CustomEvent('delete-invoice', { detail: { id: ${data}, number: '${invoiceNumber}' } }))" class="p-2 rounded-lg text-gray-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Delete">
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
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No invoices yet</h3>
                                    <p class="text-gray-500 dark:text-gray-400 mb-6 text-center max-w-sm">Get started by creating your first invoice to manage your business transactions.</p>
                                    <a href="{{ route('invoices.input') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary-600 to-primary-500 text-white rounded-lg hover:from-primary-700 hover:to-primary-600 transition-all shadow-lg shadow-primary-600/25 font-medium">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Create Invoice
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
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No results found</h3>
                                    <p class="text-gray-500 dark:text-gray-400 text-center max-w-sm">Try adjusting your search or filter to find what you're looking for.</p>
                                </div>
                            `,
                            info: "Showing _START_ to _END_ of _TOTAL_ invoices",
                            infoEmpty: "No invoices available",
                            infoFiltered: "(filtered from _MAX_ total)",
                            lengthMenu: "Show _MENU_ entries",
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

                    // Listen for delete invoice event
                    window.addEventListener('delete-invoice', (e) => {
                        this.deleteInvoice(e.detail.id, e.detail.number);
                    });
                },

                applySearch() {
                    if (this.dataTable) {
                        // Trigger AJAX reload with new search value
                        this.dataTable.ajax.reload();
                    }
                },

                applyFilter() {
                    if (this.dataTable) {
                        // Trigger AJAX reload with new filter value
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

                deleteInvoice(id, invoiceNumber) {
                    Modal.confirmDelete({
                        itemName: invoiceNumber,
                        message: 'Apakah Anda yakin ingin menghapus invoice ini? Tindakan ini tidak dapat dibatalkan.',
                        onConfirm: () => {
                            
                            fetch(`/invoices/${id}`, {
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
                                    // Reload DataTable
                                    this.dataTable.ajax.reload();
                                    
                                    // Show success notification
                                    Notification.success('Berhasil!', data.message || 'Invoice berhasil dihapus');
                                } else {
                                    Notification.error('Gagal!', data.message || 'Gagal menghapus invoice');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Notification.error('Error!', 'Terjadi kesalahan saat menghapus invoice');
                            });
                        }
                    });
                }
            }
        }
    </script>
    @endpush
</x-layout.app>
