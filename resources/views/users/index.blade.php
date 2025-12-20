<x-layout.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    @push('styles')
    <style>
        /* DataTables Custom Styling - Matching Invoice Design System */
        #users-table_wrapper {
            width: 100%;
        }

        #users-table_wrapper .dt-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
        }

        .dark #users-table_wrapper .dt-footer {
            background: #1f2937;
            border-color: #374151;
        }

        #users-table_wrapper .dataTables_info {
            color: #6b7280;
            font-size: 0.875rem;
            margin: 0;
        }

        .dark #users-table_wrapper .dataTables_info {
            color: #9ca3af;
        }

        #users-table_wrapper .dataTables_paginate {
            margin: 0;
        }

        #users-table_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5rem 0.75rem;
            margin: 0 0.125rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            background: white;
            color: #374151;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.15s;
            min-width: 2.5rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .dark #users-table_wrapper .dataTables_paginate .paginate_button {
            background: #374151;
            border-color: #4b5563;
            color: #d1d5db;
        }

        #users-table_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
            color: #111827;
        }

        .dark #users-table_wrapper .dataTables_paginate .paginate_button:hover {
            background: #4b5563;
            border-color: #6b7280;
            color: #f9fafb;
        }

        #users-table_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            border-color: #4f46e5;
            color: white;
            font-weight: 600;
        }

        #users-table_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: linear-gradient(135deg, #4338ca 0%, #3730a3 100%);
            border-color: #4338ca;
            color: white;
        }

        #users-table_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        #users-table {
            width: 100% !important;
            border-collapse: separate;
            border-spacing: 0;
        }

        #users-table thead th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }

        .dark #users-table thead th {
            background: #1f2937;
            color: #9ca3af;
            border-color: #374151;
        }

        #users-table tbody td {
            padding: 1rem 1.5rem;
            color: #111827;
            font-size: 0.875rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .dark #users-table tbody td {
            color: #f9fafb;
            border-color: #374151;
        }

        #users-table tbody tr {
            transition: background-color 0.15s;
        }

        #users-table tbody tr:hover {
            background: #f9fafb;
        }

        .dark #users-table tbody tr:hover {
            background: #1f2937;
        }

        #users-table tbody tr:last-child td {
            border-bottom: none;
        }

        div.dataTables_processing {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 2rem;
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
            z-index: 9999;
        }

        .dark div.dataTables_processing {
            background: #1f2937;
            border-color: #374151;
        }
    </style>
    @endpush

    <div class="mb-8">
        <div x-data="userManagement()" class="space-y-8">
            
            <!-- Page Header -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">User Management</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Manage system users and their roles</p>
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

            <!-- DataTable Card -->
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

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        function userManagement() {
            return {
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
                            url: '{{ route('users.data') }}',
                            type: 'GET'
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
                }
            };
        }

        // Delete user function
        function deleteUser(userId) {
            if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                return;
            }

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
                    
                    // Show success message
                    alert(data.message);
                } else {
                    alert(data.message || 'Failed to delete user');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the user');
            });
        }
    </script>
    @endpush
</x-layout.app>
