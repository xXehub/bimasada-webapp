<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoice Details') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('invoices.edit', $invoice->id) }}">
                    <x-button variant="primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </x-button>
                </a>
                <a href="{{ route('invoices.index') }}">
                    <x-button variant="secondary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to List
                    </x-button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Invoice Summary Card -->
            <x-card>
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Invoice #{{ $invoice->id }}</h3>
                        <p class="text-gray-600 mt-1">Date: {{ $invoice->tanggal_invoice->format('d M Y') }}</p>
                    </div>
                    <div class="text-right">
                        <x-status-badge :status="$invoice->status_pembayaran === 'Lunas' ? 'paid' : 
                            ($invoice->status_pembayaran === 'Belum Lunas' ? 'pending' : 'overdue')">
                            {{ $invoice->status_pembayaran }}
                        </x-status-badge>
                        <p class="text-3xl font-bold text-primary mt-2">
                            Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t pt-6">
                    <!-- Customer Information -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Customer Information</h4>
                        <div class="space-y-2">
                            <div>
                                <p class="text-lg font-semibold text-gray-900">{{ $invoice->nama_pelanggan }}</p>
                            </div>
                            @if($invoice->alamat)
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <p class="text-gray-700">{{ $invoice->alamat }}</p>
                            </div>
                            @endif
                            @if($invoice->email)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-gray-700">{{ $invoice->email }}</p>
                            </div>
                            @endif
                            @if($invoice->no_telp)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <p class="text-gray-700">{{ $invoice->no_telp }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Invoice Details -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Invoice Details</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Invoice Date:</span>
                                <span class="font-medium text-gray-900">{{ $invoice->tanggal_invoice->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Due Date:</span>
                                <span class="font-medium {{ $invoice->jatuh_tempo->isPast() && $invoice->status_pembayaran !== 'Lunas' ? 'text-danger' : 'text-gray-900' }}">
                                    {{ $invoice->jatuh_tempo->format('d M Y') }}
                                    @if($invoice->jatuh_tempo->isPast() && $invoice->status_pembayaran !== 'Lunas')
                                        <span class="text-xs">(Overdue)</span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Sales Person:</span>
                                <span class="font-medium text-gray-900">
                                    {{ $invoice->sales->nama_sales }}
                                    <span class="text-sm text-gray-500">({{ $invoice->sales->id_sales }})</span>
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Payment Status:</span>
                                <x-status-badge :status="$invoice->status_pembayaran === 'Lunas' ? 'paid' : 
                                    ($invoice->status_pembayaran === 'Belum Lunas' ? 'pending' : 'overdue')">
                                    {{ $invoice->status_pembayaran }}
                                </x-status-badge>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes Section -->
                @if($invoice->keterangan)
                <div class="border-t mt-6 pt-6">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Additional Notes</h4>
                    <p class="text-gray-700 whitespace-pre-line">{{ $invoice->keterangan }}</p>
                </div>
                @endif
            </x-card>

            <!-- Invoice Items Table -->
            @if($invoice->detailInvoices->count() > 0)
            <x-card>
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Invoice Items</h3>
                    <p class="text-sm text-gray-600">List of items included in this invoice</p>
                </div>

                <x-table>
                    <x-slot name="header">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                #
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Item / Kuitansi ID
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantity
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Unit Price
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subtotal
                            </th>
                        </tr>
                    </x-slot>

                    @foreach($invoice->detailInvoices as $index => $detail)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $detail->id_kuitansi }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                            {{ number_format($detail->jumlah, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                            Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach

                    <tr class="bg-gray-50 border-t-2 border-gray-200">
                        <td colspan="4" class="px-6 py-4 text-right text-sm font-bold text-gray-900 uppercase">
                            Total Amount:
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-lg font-bold text-primary">
                            Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                </x-table>
            </x-card>
            @else
            <x-card>
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No invoice items</h3>
                    <p class="mt-1 text-sm text-gray-500">This invoice doesn't have any line items yet.</p>
                </div>
            </x-card>
            @endif

            <!-- Related Receipts (Kuitansi) -->
            @if($invoice->kuitansis->count() > 0)
            <x-card>
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Related Receipts (Kuitansi)</h3>
                    <p class="text-sm text-gray-600">Receipts associated with this invoice</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($invoice->kuitansis as $kuitansi)
                    <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-semibold text-gray-900">Kuitansi #{{ $kuitansi->id }}</p>
                                <p class="text-sm text-gray-600">{{ $kuitansi->tanggal_kuitansi->format('d M Y') }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium rounded {{ $kuitansi->invoice_pembayaran === 'Cash' ? 'bg-green-100 text-green-800' : ($kuitansi->invoice_pembayaran === 'Transfer' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800') }}">
                                {{ $kuitansi->invoice_pembayaran }}
                            </span>
                        </div>
                        <p class="text-lg font-bold text-primary">Rp {{ number_format($kuitansi->total_bayar, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
            </x-card>
            @endif

        </div>
    </div>
</x-app-layout>
