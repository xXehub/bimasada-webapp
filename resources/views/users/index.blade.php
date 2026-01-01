<x-layout.app title="User Management">
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
        #users-table_wrapper {
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
        #users-table_wrapper {
            position: relative;
            min-height: auto;
        }
        
        /* Only apply min-height when processing */
        #users-table_wrapper.processing {
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
        <div x-data="userManagement()" class="space-y-8">
            
            <!-- Page Header -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">User Management</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Manage and track all system users</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <x-ui.button variant="primary" href="{{ route('users.create') }}">
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </x-slot>
                        Add New User
                    </x-ui.button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <x-ui.card class="!p-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-md bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Users</p>
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
                            <p class="text-sm text-gray-500 dark:text-gray-400">Active Users</p>
                            <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $stats['active'] }}</p>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Administrators</p>
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['admins'] }}</p>
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

                    <!-- Role Filter -->
                    <div class="w-full lg:w-48">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Role
                        </label>
                        <select 
                            x-model="roleFilter"
                            x-on:change="applyFilter()"
                            class="w-full px-4 py-2.5 bg-white dark:bg-dark-hover border border-gray-300 dark:border-dark-border rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                        >
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="manager">Manager</option>
                            <option value="staff">Staff</option>
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
                            placeholder="Search by name, email..."
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

            <!-- User Table with DataTables -->
            <div class="bg-white dark:bg-dark-card rounded-md border border-gray-200 dark:border-dark-border shadow-soft overflow-hidden">
                <!-- Table Header Info -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-dark-border flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-md bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">User List</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">View and manage all users</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500 dark:text-gray-400" x-text="tableInfo"></span>
                    </div>
                </div>
                
                <!-- Table Container -->
                <div class="overflow-x-auto">
                    <table id="users-table" class="w-full">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th class="text-center">Actions</th>
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
    <!-- End Max-width Container -->

    @push('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    
    <script>
        function userManagement() {
            return {
                searchQuery: '',
                roleFilter: '',
                perPage: '10',
                tableInfo: '',
                dataTable: null,

                init() {
                    this.initDataTable();
                },

                initDataTable() {
                    const self = this;
                    
                    this.dataTable = $('#users-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{ route("users.data") }}',
                            data: function(d) {
                                // Send custom filters to server
                                d.role = self.roleFilter;
                                d.search = {
                                    value: self.searchQuery
                                };
                            }
                        },
                        columns: [
                            { 
                                data: 'name',
                                render: function(data, type, row) {
                                    return `
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-100 to-primary-50 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center flex-shrink-0">
                                                <span class="text-sm font-semibold text-primary-700 dark:text-primary-400">${data.charAt(0).toUpperCase()}</span>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-medium text-gray-900 dark:text-white truncate">${data}</p>
                                            </div>
                                        </div>
                                    `;
                                }
                            },
                            { 
                                data: 'email',
                                render: function(data) {
                                    return `<span class="text-gray-700 dark:text-gray-300">${data}</span>`;
                                }
                            },
                            { 
                                data: 'roles',
                                orderable: false,
                                searchable: false
                            },
                            { 
                                data: 'status',
                                orderable: false,
                                searchable: false
                            },
                            { 
                                data: 'created_at',
                                render: function(data) {
                                    const date = new Date(data);
                                    return `<span class="text-gray-700 dark:text-gray-300">${date.toLocaleDateString('en-US', {
                                        year: 'numeric',
                                        month: 'short',
                                        day: 'numeric'
                                    })}</span>`;
                                }
                            },
                            { 
                                data: 'action',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            }
                        ],
                        order: [[4, 'desc']],
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No users yet</h3>
                                    <p class="text-gray-500 dark:text-gray-400 mb-6 text-center max-w-sm">Get started by creating your first user account.</p>
                                    <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary-600 to-primary-500 text-white rounded-lg hover:from-primary-700 hover:to-primary-600 transition-all shadow-lg shadow-primary-600/25 font-medium">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Create User
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
                            info: "Showing _START_ to _END_ of _TOTAL_ users",
                            infoEmpty: "No users available",
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
                },

                changePageLength() {
                    if (this.dataTable && this.perPage) {
                        this.dataTable.page.len(parseInt(this.perPage)).draw();
                    }
                },

                applyFilter() {
                    if (this.dataTable) {
                        this.dataTable.ajax.reload();
                    }
                },

                applySearch() {
                    if (this.dataTable) {
                        this.dataTable.ajax.reload();
                    }
                },

                resetFilters() {
                    this.searchQuery = '';
                    this.roleFilter = '';
                    this.perPage = '10';
                    if (this.dataTable) {
                        this.dataTable.page.len(10).draw();
                        this.dataTable.ajax.reload();
                    }
                }
            };
        }

        // Delete user function with modal
        function deleteUser(userId, userName = '') {
            Modal.confirmDelete({
                itemName: userName,
                onConfirm: () => {
                    // Show loading notification
                    Notification.info('Menghapus...', 'Sedang menghapus user', 0);
                    
                    fetch(`/users/${userId}`, {
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
                            $('#users-table').DataTable().ajax.reload();
                            
                            // Show success notification
                            Notification.success('Berhasil!', data.message || 'User berhasil dihapus');
                        } else {
                            Notification.error('Gagal!', data.message || 'Gagal menghapus user');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Notification.error('Error!', 'Terjadi kesalahan saat menghapus user');
                    });
                }
            });
        }
    </script>
    @endpush
</x-layout.app>
