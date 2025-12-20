<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Invoice') }}
            </h2>
            <a href="{{ route('invoices.index') }}">
                <x-button variant="secondary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to List
                </x-button>
            </a>
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

                <form action="{{ route('invoices.store') }}" method="POST" class="space-y-6">
                    @csrf

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
                                    :value="old('tanggal_invoice', date('Y-m-d'))" 
                                    required 
                                />
                            </div>

                            <!-- Due Date -->
                            <div>
                                <x-input 
                                    type="date" 
                                    name="jatuh_tempo" 
                                    label="Due Date" 
                                    :value="old('jatuh_tempo')" 
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
                                        <option value="{{ $s->id }}" {{ old('id_sales') == $s->id ? 'selected' : '' }}>
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
                                    <option value="Lunas" {{ old('status_pembayaran') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                    <option value="Belum Lunas" {{ old('status_pembayaran') == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                    <option value="Cicilan" {{ old('status_pembayaran') == 'Cicilan' ? 'selected' : '' }}>Cicilan</option>
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
                                    :value="old('total_harga')" 
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
                                    :value="old('nama_pelanggan')" 
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
                                    :value="old('email')" 
                                />
                            </div>

                            <!-- Phone -->
                            <div>
                                <x-input 
                                    type="text" 
                                    name="no_telp" 
                                    label="Phone Number" 
                                    placeholder="08xx-xxxx-xxxx" 
                                    :value="old('no_telp')" 
                                />
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <x-textarea 
                                    name="alamat" 
                                    label="Address" 
                                    rows="3" 
                                    placeholder="Enter customer address" 
                                    :value="old('alamat')" 
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
                            :value="old('keterangan')" 
                        />
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t">
                        <a href="{{ route('invoices.index') }}">
                            <x-button type="button" variant="secondary">
                                Cancel
                            </x-button>
                        </a>
                        <x-button type="submit" variant="success">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Create Invoice
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>
