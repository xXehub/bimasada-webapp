<?php

namespace App\Http\Controllers;

use App\Models\Kuitansi;
use App\Models\DetailKuitansi;
use App\Models\Invoice;
use App\Models\Sales;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KuitansiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get statistics for dashboard cards
        $stats = [
            'total' => Kuitansi::count(),
            'draft' => Kuitansi::where('status_kuitansi', 'Draft')->count(),
            'terkirim' => Kuitansi::where('status_kuitansi', 'Terkirim')->count(),
            'lunas' => Kuitansi::where('status_kuitansi', 'Lunas')->count(),
            'total_nilai' => Kuitansi::sum('total_bayar'),
        ];

        return view('kuitansis.index', compact('stats'));
    }

    /**
     * Get data for DataTables.
     */
    public function getData(Request $request)
    {
        $query = Kuitansi::with(['sales', 'invoice'])->select('kuitansis.*');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status_kuitansi', $request->status);
        }

        if ($request->filled('sales_id')) {
            $query->where('id_sales', $request->sales_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('tanggal_kuitansi', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('tanggal_kuitansi', '<=', $request->date_to);
        }

        return DataTables::of($query)
            ->addColumn('no_kuitansi_display', function ($kuitansi) {
                return $kuitansi->no_kuitansi ?? 'KTN-' . str_pad($kuitansi->id, 4, '0', STR_PAD_LEFT);
            })
            ->addColumn('customer_display', function ($kuitansi) {
                $html = '<div class="font-medium">' . e($kuitansi->nama_pelanggan) . '</div>';
                if ($kuitansi->no_telp) {
                    $html .= '<div class="text-sm text-gray-500">' . e($kuitansi->no_telp) . '</div>';
                }
                return $html;
            })
            ->addColumn('total_display', function ($kuitansi) {
                return 'Rp ' . number_format($kuitansi->total_bayar, 0, ',', '.');
            })
            ->addColumn('invoice_display', function ($kuitansi) {
                if ($kuitansi->invoice) {
                    return '<a href="' . route('invoices.show', $kuitansi->invoice->id) . '" class="text-blue-600 hover:text-blue-800">' . 
                           ($kuitansi->invoice->no_invoice ?? 'INV-' . str_pad($kuitansi->invoice->id, 4, '0', STR_PAD_LEFT)) . 
                           '</a>';
                }
                return '-';
            })
            ->addColumn('payment_method', function ($kuitansi) {
                $methods = [
                    'Cash' => 'success',
                    'Transfer' => 'info',
                    'Ciro' => 'warning',
                ];
                $color = $methods[$kuitansi->invoice_pembayaran] ?? 'secondary';
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-' . $color . '-100 text-' . $color . '-800">' . 
                       e($kuitansi->invoice_pembayaran) . '</span>';
            })
            ->addColumn('status_badge', function ($kuitansi) {
                $statuses = [
                    'Draft' => 'bg-gray-100 text-gray-800',
                    'Terkirim' => 'bg-blue-100 text-blue-800',
                    'Lunas' => 'bg-green-100 text-green-800',
                    'Batal' => 'bg-red-100 text-red-800',
                ];
                $class = $statuses[$kuitansi->status_kuitansi] ?? 'bg-gray-100 text-gray-800';
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $class . '">' . 
                       e($kuitansi->status_kuitansi) . '</span>';
            })
            ->addColumn('sales_name', function ($kuitansi) {
                return $kuitansi->sales ? $kuitansi->sales->nama_sales : '-';
            })
            ->addColumn('actions', function ($kuitansi) {
                $actions = '<div class="flex items-center gap-2">';
                
                // View button
                $actions .= '<a href="' . route('kuitansis.show', $kuitansi->id) . '" 
                    class="inline-flex items-center p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                    title="Lihat Detail">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </a>';

                // Edit button
                if (auth()->user()->can('edit-kuitansi')) {
                    $actions .= '<a href="' . route('kuitansis.edit', $kuitansi->id) . '" 
                        class="inline-flex items-center p-1.5 text-gray-500 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors"
                        title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>';
                }

                // Print button
                $actions .= '<a href="' . route('kuitansis.show', $kuitansi->id) . '?print=true" 
                    class="inline-flex items-center p-1.5 text-gray-500 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors"
                    title="Cetak" target="_blank">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                </a>';

                // Delete button
                if (auth()->user()->can('delete-kuitansi')) {
                    $actions .= '<button type="button" 
                        onclick="deleteKuitansi(' . $kuitansi->id . ')"
                        class="inline-flex items-center p-1.5 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                        title="Hapus">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>';
                }

                // Mark as Lunas (for Terkirim status)
                if ($kuitansi->status_kuitansi === 'Terkirim') {
                    $actions .= '<button type="button" 
                        onclick="markLunas(' . $kuitansi->id . ')"
                        class="inline-flex items-center p-1.5 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                        title="Tandai Lunas">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </button>';
                }

                $actions .= '</div>';
                return $actions;
            })
            ->rawColumns(['customer_display', 'invoice_display', 'payment_method', 'status_badge', 'actions'])
            ->make(true);
    }

    /**
     * Generate Kuitansi number.
     */
    public function generateKuitansiNumber()
    {
        $year = date('Y');
        $month = date('m');
        
        // Get the last kuitansi number for this month
        $lastKuitansi = Kuitansi::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereNotNull('no_kuitansi')
            ->orderBy('no_kuitansi', 'desc')
            ->first();

        if ($lastKuitansi && preg_match('/KTN-' . $year . '-' . $month . '-(\d+)/', $lastKuitansi->no_kuitansi, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = 1;
        }

        $noKuitansi = 'KTN-' . $year . '-' . $month . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        
        return response()->json(['no_kuitansi' => $noKuitansi]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $salesList = Sales::orderBy('nama_sales')->get();
        $invoices = Invoice::whereDoesntHave('kuitansi')
            ->orWhere('status_invoice', 'Lunas')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Pre-fill from invoice if specified
        $selectedInvoice = null;
        if ($request->filled('invoice_id')) {
            $selectedInvoice = Invoice::find($request->invoice_id);
        }

        // Generate kuitansi number
        $year = date('Y');
        $month = date('m');
        $lastKuitansi = Kuitansi::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereNotNull('no_kuitansi')
            ->orderBy('no_kuitansi', 'desc')
            ->first();

        if ($lastKuitansi && preg_match('/KTN-' . $year . '-' . $month . '-(\d+)/', $lastKuitansi->no_kuitansi, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = 1;
        }
        $noKuitansi = 'KTN-' . $year . '-' . $month . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return view('kuitansis.create', compact('salesList', 'invoices', 'selectedInvoice', 'noKuitansi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kuitansi' => 'nullable|string|max:50|unique:kuitansis,no_kuitansi',
            'tanggal_kuitansi' => 'required|date',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:500',
            'no_telp' => 'nullable|string|max:20',
            'total_bayar' => 'required|numeric|min:0',
            'invoice_pembayaran' => 'required|in:Cash,Transfer,Ciro',
            'keterangan' => 'nullable|string',
            'status_kuitansi' => 'nullable|in:Draft,Terkirim,Lunas,Batal',
            'id_sales' => 'required|exists:sales,id',
            'id_invoice' => 'nullable|exists:invoices,id',
            // Detail items
            'items' => 'nullable|array',
            'items.*.nama_item' => 'required_with:items|string|max:255',
            'items.*.jumlah' => 'required_with:items|integer|min:1',
            'items.*.harga_satuan' => 'required_with:items|numeric|min:0',
        ]);

        // Generate kuitansi number if not provided
        if (empty($validated['no_kuitansi'])) {
            $year = date('Y');
            $month = date('m');
            $lastKuitansi = Kuitansi::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->whereNotNull('no_kuitansi')
                ->orderBy('no_kuitansi', 'desc')
                ->first();

            if ($lastKuitansi && preg_match('/KTN-' . $year . '-' . $month . '-(\d+)/', $lastKuitansi->no_kuitansi, $matches)) {
                $nextNumber = intval($matches[1]) + 1;
            } else {
                $nextNumber = 1;
            }
            $validated['no_kuitansi'] = 'KTN-' . $year . '-' . $month . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        // Set default status
        $validated['status_kuitansi'] = $validated['status_kuitansi'] ?? 'Draft';

        // Create kuitansi
        $kuitansi = Kuitansi::create([
            'no_kuitansi' => $validated['no_kuitansi'],
            'tanggal_kuitansi' => $validated['tanggal_kuitansi'],
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'alamat' => $validated['alamat'] ?? null,
            'no_telp' => $validated['no_telp'] ?? null,
            'total_bayar' => $validated['total_bayar'],
            'invoice_pembayaran' => $validated['invoice_pembayaran'],
            'keterangan' => $validated['keterangan'] ?? null,
            'status_kuitansi' => $validated['status_kuitansi'],
            'id_sales' => $validated['id_sales'],
            'id_invoice' => $validated['id_invoice'] ?? null,
        ]);

        // Create detail items if provided
        if (!empty($validated['items'])) {
            foreach ($validated['items'] as $index => $item) {
                $subtotal = $item['jumlah'] * $item['harga_satuan'];
                DetailKuitansi::create([
                    'id_kuitansi' => $kuitansi->id,
                    'id_txtKtl' => $item['nama_item'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $subtotal,
                ]);
            }
        }

        return redirect()->route('kuitansis.show', $kuitansi->id)
            ->with('success', 'Kuitansi berhasil dibuat.');
    }

    /**
     * Store a newly created resource via quick modal.
     */
    public function storeQuick(Request $request)
    {
        $validated = $request->validate([
            'no_kuitansi' => 'nullable|string|max:50|unique:kuitansis,no_kuitansi',
            'tanggal_kuitansi' => 'required|date',
            'nama_pelanggan' => 'required|string|max:255',
            'total_bayar' => 'required|numeric|min:0',
            'invoice_pembayaran' => 'required|in:Cash,Transfer,Ciro',
            'id_sales' => 'required|exists:sales,id',
            'id_invoice' => 'nullable|exists:invoices,id',
        ]);

        // Generate kuitansi number if not provided
        if (empty($validated['no_kuitansi'])) {
            $year = date('Y');
            $month = date('m');
            $lastKuitansi = Kuitansi::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->whereNotNull('no_kuitansi')
                ->orderBy('no_kuitansi', 'desc')
                ->first();

            if ($lastKuitansi && preg_match('/KTN-' . $year . '-' . $month . '-(\d+)/', $lastKuitansi->no_kuitansi, $matches)) {
                $nextNumber = intval($matches[1]) + 1;
            } else {
                $nextNumber = 1;
            }
            $validated['no_kuitansi'] = 'KTN-' . $year . '-' . $month . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        $kuitansi = Kuitansi::create([
            'no_kuitansi' => $validated['no_kuitansi'],
            'tanggal_kuitansi' => $validated['tanggal_kuitansi'],
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'total_bayar' => $validated['total_bayar'],
            'invoice_pembayaran' => $validated['invoice_pembayaran'],
            'status_kuitansi' => 'Draft',
            'id_sales' => $validated['id_sales'],
            'id_invoice' => $validated['id_invoice'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kuitansi berhasil dibuat.',
            'kuitansi' => $kuitansi,
            'redirect' => route('kuitansis.show', $kuitansi->id),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kuitansi $kuitansi)
    {
        $kuitansi->load(['sales', 'invoice', 'detailKuitansis']);
        
        return view('kuitansis.show', compact('kuitansi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kuitansi $kuitansi)
    {
        $kuitansi->load(['sales', 'invoice', 'detailKuitansis']);
        $salesList = Sales::orderBy('nama_sales')->get();
        $invoices = Invoice::orderBy('created_at', 'desc')->get();
        
        return view('kuitansis.edit', compact('kuitansi', 'salesList', 'invoices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kuitansi $kuitansi)
    {
        $validated = $request->validate([
            'no_kuitansi' => 'nullable|string|max:50|unique:kuitansis,no_kuitansi,' . $kuitansi->id,
            'tanggal_kuitansi' => 'required|date',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:500',
            'no_telp' => 'nullable|string|max:20',
            'total_bayar' => 'required|numeric|min:0',
            'invoice_pembayaran' => 'required|in:Cash,Transfer,Ciro',
            'keterangan' => 'nullable|string',
            'status_kuitansi' => 'nullable|in:Draft,Terkirim,Lunas,Batal',
            'id_sales' => 'required|exists:sales,id',
            'id_invoice' => 'nullable|exists:invoices,id',
            // Detail items
            'items' => 'nullable|array',
            'items.*.id' => 'nullable|exists:detail_kuitansis,id',
            'items.*.nama_item' => 'required_with:items|string|max:255',
            'items.*.jumlah' => 'required_with:items|integer|min:1',
            'items.*.harga_satuan' => 'required_with:items|numeric|min:0',
        ]);

        // Update kuitansi
        $kuitansi->update([
            'no_kuitansi' => $validated['no_kuitansi'] ?? $kuitansi->no_kuitansi,
            'tanggal_kuitansi' => $validated['tanggal_kuitansi'],
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'alamat' => $validated['alamat'] ?? null,
            'no_telp' => $validated['no_telp'] ?? null,
            'total_bayar' => $validated['total_bayar'],
            'invoice_pembayaran' => $validated['invoice_pembayaran'],
            'keterangan' => $validated['keterangan'] ?? null,
            'status_kuitansi' => $validated['status_kuitansi'] ?? $kuitansi->status_kuitansi,
            'id_sales' => $validated['id_sales'],
            'id_invoice' => $validated['id_invoice'] ?? null,
        ]);

        // Update detail items if provided
        if (!empty($validated['items'])) {
            // Delete existing items not in the request
            $existingIds = collect($validated['items'])->pluck('id')->filter()->toArray();
            $kuitansi->detailKuitansis()->whereNotIn('id', $existingIds)->delete();

            foreach ($validated['items'] as $item) {
                $subtotal = $item['jumlah'] * $item['harga_satuan'];
                
                if (!empty($item['id'])) {
                    // Update existing item
                    DetailKuitansi::where('id', $item['id'])->update([
                        'id_txtKtl' => $item['nama_item'],
                        'jumlah' => $item['jumlah'],
                        'harga_satuan' => $item['harga_satuan'],
                        'subtotal' => $subtotal,
                    ]);
                } else {
                    // Create new item
                    DetailKuitansi::create([
                        'id_kuitansi' => $kuitansi->id,
                        'id_txtKtl' => $item['nama_item'],
                        'jumlah' => $item['jumlah'],
                        'harga_satuan' => $item['harga_satuan'],
                        'subtotal' => $subtotal,
                    ]);
                }
            }
        }

        return redirect()->route('kuitansis.show', $kuitansi->id)
            ->with('success', 'Kuitansi berhasil diperbarui.');
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, Kuitansi $kuitansi)
    {
        $validated = $request->validate([
            'status_kuitansi' => 'required|in:Draft,Terkirim,Lunas,Batal',
        ]);

        $kuitansi->update(['status_kuitansi' => $validated['status_kuitansi']]);

        // If marked as Lunas, also update the related invoice
        if ($validated['status_kuitansi'] === 'Lunas' && $kuitansi->id_invoice) {
            Invoice::where('id', $kuitansi->id_invoice)->update(['status_invoice' => 'Lunas']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status kuitansi berhasil diperbarui menjadi ' . $validated['status_kuitansi'],
        ]);
    }

    /**
     * Mark kuitansi as Lunas.
     */
    public function markLunas(Kuitansi $kuitansi)
    {
        $kuitansi->update(['status_kuitansi' => 'Lunas']);

        // Also update the related invoice if exists
        if ($kuitansi->id_invoice) {
            Invoice::where('id', $kuitansi->id_invoice)->update(['status_invoice' => 'Lunas']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Kuitansi berhasil ditandai sebagai Lunas.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kuitansi $kuitansi)
    {
        // Delete related detail items first
        $kuitansi->detailKuitansis()->delete();
        
        // Delete kuitansi
        $kuitansi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kuitansi berhasil dihapus.',
        ]);
    }
}
