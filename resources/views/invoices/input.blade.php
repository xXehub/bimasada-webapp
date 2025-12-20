<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Input Invoice') }}
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

    <div class="py-12" x-data="invoiceInput()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
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

            <form action="{{ route('invoices.storeWithItems') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Invoice Header Information -->
                <x-card>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Invoice Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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

                        <!-- Sales Person -->
                        <div class="md:col-span-3">
                            <x-select 
                                name="id_sales" 
                                label="Sales Person" 
                                required
                            >
                                <option value="">Select Sales Person</option>
                                @foreach($salesList as $s)
                                    <option value="{{ $s->id }}" {{ old('id_sales') == $s->id ? 'selected' : '' }}>
                                        {{ $s->id_sales }} - {{ $s->nama_sales }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>
                    </div>
                </x-card>

                <!-- Customer Information -->
                <x-card>
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
                </x-card>

                <!-- Invoice Items Table -->
                <x-card>
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="text-lg font-semibold text-gray-900">Invoice Items</h3>
                        <x-button type="button" variant="success" @click="addItem">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Add Item
                        </x-button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                                        #
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Item / Kuitansi ID <span class="text-danger">*</span>
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                                        Quantity <span class="text-danger">*</span>
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">
                                        Unit Price (Rp) <span class="text-danger">*</span>
                                    </th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-48">
                                        Subtotal (Rp)
                                    </th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <template x-for="(item, index) in items" :key="index">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span x-text="index + 1"></span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <input 
                                                type="text" 
                                                :name="'items[' + index + '][id_kuitansi]'" 
                                                x-model="item.id_kuitansi"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                                placeholder="Enter item ID or description"
                                                required
                                            />
                                        </td>
                                        <td class="px-4 py-4">
                                            <input 
                                                type="number" 
                                                :name="'items[' + index + '][jumlah]'" 
                                                x-model.number="item.jumlah"
                                                @input="calculateSubtotal(index)"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                                placeholder="0"
                                                min="1"
                                                step="1"
                                                required
                                            />
                                        </td>
                                        <td class="px-4 py-4">
                                            <input 
                                                type="number" 
                                                :name="'items[' + index + '][harga_satuan]'" 
                                                x-model.number="item.harga_satuan"
                                                @input="calculateSubtotal(index)"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                                placeholder="0.00"
                                                min="0"
                                                step="0.01"
                                                required
                                            />
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-medium">
                                            <span x-text="formatCurrency(item.subtotal)"></span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-center">
                                            <button 
                                                type="button" 
                                                @click="removeItem(index)"
                                                class="text-danger hover:text-red-700 transition-colors"
                                                :disabled="items.length === 1"
                                                :class="{ 'opacity-50 cursor-not-allowed': items.length === 1 }"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <!-- Empty State -->
                    <div x-show="items.length === 0" class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No items added</h3>
                        <p class="mt-1 text-sm text-gray-500">Click "Add Item" button to add invoice items.</p>
                    </div>
                </x-card>

                <!-- Calculation Summary -->
                <x-card>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Summary</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-gray-700">
                            <span class="text-base">Subtotal:</span>
                            <span class="text-xl font-medium" x-text="formatCurrency(grandTotal)"></span>
                        </div>
                        
                        <div class="flex justify-between items-center text-gray-700 border-t pt-3">
                            <span class="text-base">PPN (11%):</span>
                            <span class="text-xl font-medium" x-text="formatCurrency(ppn)"></span>
                        </div>
                        
                        <div class="flex justify-between items-center border-t-2 border-primary pt-4">
                            <span class="text-lg font-bold text-gray-900">Grand Total:</span>
                            <span class="text-3xl font-bold text-primary" x-text="formatCurrency(totalWithPPN)"></span>
                        </div>
                    </div>
                </x-card>

                <!-- Additional Notes -->
                <x-card>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Additional Notes</h3>
                    
                    <x-textarea 
                        name="keterangan" 
                        label="Notes / Keterangan" 
                        rows="4" 
                        placeholder="Enter any additional notes or information (optional)" 
                        :value="old('keterangan')" 
                    />
                </x-card>

                <!-- Action Buttons -->
                <x-card>
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            <span class="text-danger">*</span> Required fields
                        </div>
                        <div class="flex space-x-4">
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
                    </div>
                </x-card>

            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function invoiceInput() {
            return {
                items: [{
                    id_kuitansi: '',
                    jumlah: 1,
                    harga_satuan: 0,
                    subtotal: 0
                }],
                
                get grandTotal() {
                    return this.items.reduce((sum, item) => sum + (item.subtotal || 0), 0);
                },
                
                get ppn() {
                    return this.grandTotal * 0.11; // 11% PPN
                },
                
                get totalWithPPN() {
                    return this.grandTotal + this.ppn;
                },
                
                addItem() {
                    this.items.push({
                        id_kuitansi: '',
                        jumlah: 1,
                        harga_satuan: 0,
                        subtotal: 0
                    });
                },
                
                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                },
                
                calculateSubtotal(index) {
                    const item = this.items[index];
                    item.subtotal = (item.jumlah || 0) * (item.harga_satuan || 0);
                },
                
                formatCurrency(value) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(value || 0);
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
