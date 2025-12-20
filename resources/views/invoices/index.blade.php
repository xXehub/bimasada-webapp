<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-[#02245B] leading-tight font-poppins">
                {{ __('Invoice Management') }}
            </h2>
            <x-button variant="success" href="{{ route('invoices.create') }}">
                + Add Invoice
            </x-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6">
                    <x-alert type="success">
                        {{ session('success') }}
                    </x-alert>
                </div>
            @endif

            <!-- Filters & Search -->
            <x-card class="mb-6">
                <form method="GET" action="{{ route('invoices.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div>
                            <x-input 
                                type="text" 
                                name="search" 
                                placeholder="Search by customer name, email, phone..."
                                :value="request('search')"
                            />
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <x-select 
                                name="status"
                                :options="[
                                    '' => 'All Status',
                                    'Lunas' => 'Lunas',
                                    'Belum Lunas' => 'Belum Lunas',
                                    'Cicilan' => 'Cicilan'
                                ]"
                                :selected="request('status')"
                            />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-2">
                            <x-button variant="primary" type="submit" class="flex-1">
                                Filter
                            </x-button>
                            <x-button variant="outline" href="{{ route('invoices.index') }}">
                                Reset
                            </x-button>
                        </div>
                    </div>
                </form>
            </x-card>

            <!-- Invoice Table -->
            <x-card>
                <x-table>
                    <x-slot name="header">
                        <th class="sortable">
                            <a href="?sort_by=tanggal_invoice&sort_order={{ request('sort_order') == 'asc' ? 'desc' : 'asc' }}">
                                Invoice Date
                            </a>
                        </th>
                        <th>Customer</th>
                        <th>Email / Phone</th>
                        <th class="sortable">
                            <a href="?sort_by=total_harga&sort_order={{ request('sort_order') == 'asc' ? 'desc' : 'asc' }}">
                                Total
                            </a>
                        </th>
                        <th>Status</th>
                        <th class="sortable">
                            <a href="?sort_by=jatuh_tempo&sort_order={{ request('sort_order') == 'asc' ? 'desc' : 'asc' }}">
                                Due Date
                            </a>
                        </th>
                        <th>Sales</th>
                        <th class="text-center">Actions</th>
                    </x-slot>

                    <x-slot name="body">
                        @forelse($invoices as $invoice)
                            <tr>
                                <td class="font-medium">
                                    {{ $invoice->tanggal_invoice->format('d M Y') }}
                                </td>
                                <td>
                                    <div class="font-semibold text-[#02245B]">
                                        {{ $invoice->nama_pelanggan }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ Str::limit($invoice->alamat, 30) }}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-sm">{{ $invoice->email }}</div>
                                    <div class="text-sm text-gray-500">{{ $invoice->no_telp }}</div>
                                </td>
                                <td class="font-semibold text-[#02245B]">
                                    Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}
                                </td>
                                <td>
                                    @php
                                        $statusMap = [
                                            'Lunas' => 'paid',
                                            'Belum Lunas' => 'pending',
                                            'Cicilan' => 'overdue'
                                        ];
                                        $status = $statusMap[$invoice->status_pembayaran] ?? 'pending';
                                    @endphp
                                    <x-status-badge :status="$status" />
                                </td>
                                <td>
                                    {{ $invoice->jatuh_tempo->format('d M Y') }}
                                    @if($invoice->jatuh_tempo->isPast() && $invoice->status_pembayaran != 'Lunas')
                                        <span class="text-xs text-red-500 block">Overdue!</span>
                                    @endif
                                </td>
                                <td>{{ $invoice->sales->nama_sales ?? '-' }}</td>
                                <td>
                                    <div class="flex justify-center gap-2">
                                        <x-button 
                                            variant="primary" 
                                            size="sm" 
                                            href="{{ route('invoices.show', $invoice) }}"
                                        >
                                            View
                                        </x-button>
                                        <x-button 
                                            variant="secondary" 
                                            size="sm" 
                                            href="{{ route('invoices.edit', $invoice) }}"
                                        >
                                            Edit
                                        </x-button>
                                        <form 
                                            method="POST" 
                                            action="{{ route('invoices.destroy', $invoice) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this invoice?')"
                                            class="inline"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <x-button variant="danger" size="sm" type="submit">
                                                Delete
                                            </x-button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-8 text-gray-500">
                                    No invoices found. 
                                    <a href="{{ route('invoices.create') }}" class="text-[#2387C0] hover:underline">
                                        Create your first invoice
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </x-slot>

                    <x-slot name="footer">
                        {{ $invoices->links('components.pagination') }}
                    </x-slot>
                </x-table>
            </x-card>

        </div>
    </div>
</x-app-layout>
