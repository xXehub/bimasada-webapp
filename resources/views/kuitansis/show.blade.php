@extends('layouts.app')

@section('title', 'Detail Kuitansi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('kuitansis.index') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $kuitansi->no_kuitansi ?? 'KTN-' . str_pad($kuitansi->id, 4, '0', STR_PAD_LEFT) }}</h1>
                <p class="mt-1 text-sm text-gray-500">Detail kuitansi pembayaran</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @can('edit-kuitansi')
            <a href="{{ route('kuitansis.edit', $kuitansi->id) }}" 
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
            @endcan
            <a href="{{ route('pdf.kuitansi', $kuitansi) }}" target="_blank"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download PDF
            </a>
            <a href="{{ route('pdf.kuitansi.stream', $kuitansi) }}" target="_blank"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Status Banner -->
            @php
                $statusColors = [
                    'Draft' => 'bg-gray-50 border-gray-200 text-gray-700',
                    'Terkirim' => 'bg-blue-50 border-blue-200 text-blue-700',
                    'Lunas' => 'bg-green-50 border-green-200 text-green-700',
                    'Batal' => 'bg-red-50 border-red-200 text-red-700',
                ];
                $statusColor = $statusColors[$kuitansi->status_kuitansi] ?? 'bg-gray-50 border-gray-200 text-gray-700';
            @endphp
            <div class="p-4 rounded-lg border {{ $statusColor }}">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        @if($kuitansi->status_kuitansi === 'Lunas')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @elseif($kuitansi->status_kuitansi === 'Terkirim')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        @endif
                        <div>
                            <p class="font-semibold">Status: {{ $kuitansi->status_kuitansi }}</p>
                            <p class="text-sm opacity-75">Tanggal: {{ $kuitansi->tanggal_kuitansi->format('d F Y') }}</p>
                        </div>
                    </div>
                    @if($kuitansi->status_kuitansi === 'Terkirim')
                        <button type="button" onclick="markLunas()"
                            class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Tandai Lunas
                        </button>
                    @elseif($kuitansi->status_kuitansi === 'Draft')
                        <button type="button" onclick="updateStatus('Terkirim')"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Kirim Kuitansi
                        </button>
                    @endif
                </div>
            </div>

            <!-- Customer Info -->
            <x-ui.card>
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Informasi Pelanggan</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Pelanggan</p>
                            <p class="mt-1 text-base text-gray-900">{{ $kuitansi->nama_pelanggan }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">No. Telepon</p>
                            <p class="mt-1 text-base text-gray-900">{{ $kuitansi->no_telp ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm font-medium text-gray-500">Alamat</p>
                            <p class="mt-1 text-base text-gray-900">{{ $kuitansi->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <!-- Payment Info -->
            <x-ui.card>
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Informasi Pembayaran</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Metode Pembayaran</p>
                            @php
                                $methodColors = [
                                    'Cash' => 'bg-green-100 text-green-800',
                                    'Transfer' => 'bg-blue-100 text-blue-800',
                                    'Ciro' => 'bg-yellow-100 text-yellow-800',
                                ];
                            @endphp
                            <p class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $methodColors[$kuitansi->invoice_pembayaran] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $kuitansi->invoice_pembayaran }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Invoice Terkait</p>
                            <p class="mt-1 text-base text-gray-900">
                                @if($kuitansi->invoice)
                                    <a href="{{ route('invoices.show', $kuitansi->invoice->id) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                        {{ $kuitansi->invoice->no_invoice ?? 'INV-' . str_pad($kuitansi->invoice->id, 4, '0', STR_PAD_LEFT) }}
                                    </a>
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Bayar</p>
                            <p class="mt-1 text-xl font-bold text-gray-900">Rp {{ number_format($kuitansi->total_bayar, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    @if($kuitansi->keterangan)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Keterangan</p>
                        <p class="mt-1 text-base text-gray-900">{{ $kuitansi->keterangan }}</p>
                    </div>
                    @endif
                </div>
            </x-ui.card>

            <!-- Detail Items -->
            @if($kuitansi->detailKuitansis->count() > 0)
            <x-ui.card>
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Detail Item</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Harga Satuan</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($kuitansi->detailKuitansis as $index => $detail)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $detail->id_txtKtl }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ $detail->jumlah }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-right text-sm font-semibold text-gray-900">Total:</td>
                                <td class="px-6 py-4 text-right text-sm font-bold text-gray-900">Rp {{ number_format($kuitansi->detailKuitansis->sum('subtotal'), 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-ui.card>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <x-ui.card>
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Aksi Cepat</h3>
                </div>
                <div class="p-4 space-y-2">
                    @can('edit-kuitansi')
                    <a href="{{ route('kuitansis.edit', $kuitansi->id) }}" 
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Kuitansi
                    </a>
                    @endcan

                    <a href="{{ route('pdf.kuitansi', $kuitansi) }}" target="_blank"
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download PDF Kuitansi
                    </a>

                    @if($kuitansi->invoice)
                    <a href="{{ route('invoices.show', $kuitansi->invoice->id) }}"
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Lihat Invoice
                    </a>
                    @endif

                    @can('delete-kuitansi')
                    <button type="button" onclick="deleteKuitansi()"
                        class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Kuitansi
                    </button>
                    @endcan
                </div>
            </x-ui.card>

            <!-- Info -->
            <x-ui.card>
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Informasi</h3>
                </div>
                <div class="p-4 space-y-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Sales</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $kuitansi->sales?->nama_sales ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Dibuat</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $kuitansi->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Terakhir Diubah</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $kuitansi->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </x-ui.card>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function markLunas() {
        if (confirm('Apakah Anda yakin ingin menandai kuitansi ini sebagai Lunas?')) {
            fetch('{{ route("kuitansis.markLunas", $kuitansi->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Gagal mengubah status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengubah status');
            });
        }
    }

    function updateStatus(status) {
        fetch('{{ route("kuitansis.updateStatus", $kuitansi->id) }}', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status_kuitansi: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Gagal mengubah status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengubah status');
        });
    }

    function deleteKuitansi() {
        if (confirm('Apakah Anda yakin ingin menghapus kuitansi ini? Tindakan ini tidak dapat dibatalkan.')) {
            fetch('{{ route("kuitansis.destroy", $kuitansi->id) }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '{{ route("kuitansis.index") }}';
                } else {
                    alert(data.message || 'Gagal menghapus kuitansi');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus kuitansi');
            });
        }
    }
</script>
@endpush
