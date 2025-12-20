<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Invoice') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('invoices.show', $invoice->id) }}">
                    <x-button variant="secondary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        View
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
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <!-- Error Summary -->
                @if ($errors->any())
                    <div class="mb-6">
                        <x-alert type="error">
                            <strong>Please fix the following errors:</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </x-alert>
                    </div>
                @endif

                <form action="{{ route('invoices.update', $invoice->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Invoice Information Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Invoice Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Invoice Date -->
                            <div>
                                <x-input 
                                    type="date" 
                                    name="tanggal_invoice" 
                                    label="Invoice Date" 
                                    :value="old('tanggal_invoice', $invoice->tanggal_invoice->format('Y-m-d'))" 
                                    required 
                                />
                            </div>

                            <!-- Due Date -->
                            <div>
                                <x-input 
                                    type="date" 
                                    name="jatuh_tempo" 
                                    label="Due Date" 
                                    :value="old('jatuh_tempo', $invoice->jatuh_tempo->format('Y-m-d'))" 
                                    required 
                                />
                            </div>

                            <!-- Sales Person -->
                            <div>
                                <x-select 
                                    name="id_sales" 
                                    label="Sales Person" 
                                    required
                                >
                                    <option value="">Select Sales Person</option>
                                    @foreach($sales as $s)
                                        <option value="{{ $s->id }}" 
                                            {{ old('id_sales', $invoice->id_sales) == $s->id ? 'selected' : '' }}>
                                            {{ $s->id_sales }} - {{ $s->nama_sales }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>

                            <!-- Payment Status -->
                            <div>
                                <x-select 
                                    name="status_pembayaran" 
                                    label="Payment Status" 
                                    required
                                >
                                    <option value="">Select Status</option>
                                    <option value="Lunas" {{ old('status_pembayaran', $invoice->status_pembayaran) == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                    <option value="Belum Lunas" {{ old('status_pembayaran', $invoice->status_pembayaran) == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                    <option value="Cicilan" {{ old('status_pembayaran', $invoice->status_pembayaran) == 'Cicilan' ? 'selected' : '' }}>Cicilan</option>
                                </x-select>
                            </div>

                            <!-- Total Amount -->
                            <div class="md:col-span-2">
                                <x-input 
                                    type="number" 
                                    step="0.01" 
                                    name="total_harga" 
                                    label="Total Amount (Rp)" 
                                    placeholder="0.00" 
                                    :value="old('total_harga', $invoice->total_harga)" 
                                    required 
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Customer Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Customer Name -->
                            <div class="md:col-span-2">
                                <x-input 
                                    type="text" 
                                    name="nama_pelanggan" 
                                    label="Customer Name" 
                                    placeholder="Enter customer name" 
                                    :value="old('nama_pelanggan', $invoice->nama_pelanggan)" 
                                    required 
                                />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input 
                                    type="email" 
                                    name="email" 
                                    label="Email Address" 
                                    placeholder="customer@example.com" 
                                    :value="old('email', $invoice->email)" 
                                />
                            </div>

                            <!-- Phone -->
                            <div>
                                <x-input 
                                    type="text" 
                                    name="no_telp" 
                                    label="Phone Number" 
                                    placeholder="08xx-xxxx-xxxx" 
                                    :value="old('no_telp', $invoice->no_telp)" 
                                />
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <x-textarea 
                                    name="alamat" 
                                    label="Address" 
                                    rows="3" 
                                    placeholder="Enter customer address" 
                                    :value="old('alamat', $invoice->alamat)" 
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Additional Notes -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Additional Notes</h3>
                        
                        <x-textarea 
                            name="keterangan" 
                            label="Notes / Keterangan" 
                            rows="4" 
                            placeholder="Enter any additional notes or information (optional)" 
                            :value="old('keterangan', $invoice->keterangan)" 
                        />
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t">
                        <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" 
                            onsubmit="return confirm('Are you sure you want to delete this invoice? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <x-button type="submit" variant="danger">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete Invoice
                            </x-button>
                        </form>

                        <div class="flex space-x-4">
                            <a href="{{ route('invoices.index') }}">
                                <x-button type="button" variant="secondary">
                                    Cancel
                                </x-button>
                            </a>
                            <x-button type="submit" variant="primary">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update Invoice
                            </x-button>
                        </div>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>
