<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Sales;
use App\Models\SuratPerjanjian;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get sales list for modal - only needed columns
        $salesList = Sales::select('id', 'nama_sales')->get();
        
        // OPTIMIZED: Get stats in single query using groupBy
        $statsRaw = Invoice::select('status_pembayaran', \DB::raw('COUNT(*) as count'))
            ->groupBy('status_pembayaran')
            ->pluck('count', 'status_pembayaran')
            ->toArray();
        
        $stats = [
            'total' => array_sum($statsRaw),
            'paid' => $statsRaw['Lunas'] ?? 0,
            'pending' => $statsRaw['Belum Lunas'] ?? 0,
            'installment' => $statsRaw['Cicilan'] ?? 0,
        ];

        return view('invoices.index', compact('salesList', 'stats'));
    }

    /**
     * Get invoice data for DataTables server-side processing.
     */
    public function getData(Request $request)
    {
        $query = Invoice::with('sales');

        // Apply status filter if provided
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status_pembayaran', $request->status);
        }

        return DataTables::of($query)
            ->addColumn('invoice_number_display', function ($invoice) {
                return $invoice->no_invoice ?? 'INV-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT);
            })
            ->addColumn('customer_display', function ($invoice) {
                $initials = strtoupper(substr($invoice->nama_pelanggan, 0, 2));
                $subText = $invoice->email ?? $invoice->no_telp ?? '';
                return [
                    'name' => $invoice->nama_pelanggan,
                    'initials' => $initials,
                    'sub' => $subText
                ];
            })
            ->addColumn('amount_display', function ($invoice) {
                return 'Rp ' . number_format($invoice->total_harga, 0, ',', '.');
            })
            ->addColumn('date_display', function ($invoice) {
                return $invoice->tanggal_invoice->format('d M Y');
            })
            ->addColumn('due_date_display', function ($invoice) {
                return [
                    'date' => $invoice->jatuh_tempo->format('d M Y'),
                    'is_overdue' => $invoice->jatuh_tempo->isPast() && $invoice->status_pembayaran != 'Lunas'
                ];
            })
            ->addColumn('sales_name', function ($invoice) {
                return $invoice->sales->nama_sales ?? '-';
            })
            ->addColumn('status_badge', function ($invoice) {
                $variants = [
                    'Lunas' => 'success',
                    'Belum Lunas' => 'warning',
                    'Cicilan' => 'info',
                    'Revisi' => 'danger'
                ];
                return [
                    'status' => $invoice->status_pembayaran,
                    'variant' => $variants[$invoice->status_pembayaran] ?? 'secondary'
                ];
            })
            ->addColumn('actions', function ($invoice) {
                return $invoice->id;
            })
            ->filterColumn('customer_display', function($query, $keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->where('nama_pelanggan', 'like', "%{$keyword}%")
                      ->orWhere('email', 'like', "%{$keyword}%")
                      ->orWhere('no_telp', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('sales_name', function($query, $keyword) {
                $query->whereHas('sales', function($q) use ($keyword) {
                    $q->where('nama_sales', 'like', "%{$keyword}%");
                });
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $salesList = Sales::select('id', 'nama_sales')->get();
        $pksList = SuratPerjanjian::select('id', 'no_surat', 'nama_pelanggan', 'nilai_kontrak', 'status_surat')
            ->where('status_surat', 'Disetujui')
            ->orderBy('created_at', 'desc')
            ->get();
        $noInvoice = $this->generateNextInvoiceNumber();
        return view('invoices.create', compact('salesList', 'pksList', 'noInvoice'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_invoice' => 'nullable|string|max:50|unique:invoices,no_invoice',
            'tanggal_invoice' => 'required|date',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'total_harga' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|in:Lunas,Belum Lunas,Cicilan',
            'jatuh_tempo' => 'required|date',
            'keterangan' => 'nullable|string',
            'id_sales' => 'required|exists:sales,id',
            'id_pks' => 'nullable|exists:surat_perjanjians,id',
            'bukti_pks' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Generate no_invoice if not provided
        if (empty($validated['no_invoice'])) {
            $validated['no_invoice'] = $this->generateNextInvoiceNumber();
        }

        // Handle file upload
        if ($request->hasFile('bukti_pks')) {
            $file = $request->file('bukti_pks');
            $filename = 'bukti_pks_' . time() . '_' . $file->getClientOriginalName();
            $validated['bukti_pks'] = $file->storeAs('invoices/bukti_pks', $filename, 'public');
        }

        $invoice = Invoice::create($validated);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('sales', 'detailInvoices', 'pks', 'kuitansis');
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $salesList = Sales::select('id', 'nama_sales')->get();
        $pksList = SuratPerjanjian::select('id', 'no_surat', 'nama_pelanggan', 'nilai_kontrak', 'status_surat')
            ->where('status_surat', 'Disetujui')
            ->orWhere('id', $invoice->id_pks)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('invoices.edit', compact('invoice', 'salesList', 'pksList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'no_invoice' => 'nullable|string|max:50|unique:invoices,no_invoice,' . $invoice->id,
            'tanggal_invoice' => 'required|date',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'total_harga' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|in:Lunas,Belum Lunas,Cicilan,Revisi',
            'jatuh_tempo' => 'required|date',
            'keterangan' => 'nullable|string',
            'id_sales' => 'required|exists:sales,id',
            'id_pks' => 'nullable|exists:surat_perjanjians,id',
            'bukti_pks' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Handle file upload
        if ($request->hasFile('bukti_pks')) {
            // Delete old file if exists
            if ($invoice->bukti_pks && \Storage::disk('public')->exists($invoice->bukti_pks)) {
                \Storage::disk('public')->delete($invoice->bukti_pks);
            }
            $file = $request->file('bukti_pks');
            $filename = 'bukti_pks_' . time() . '_' . $file->getClientOriginalName();
            $validated['bukti_pks'] = $file->storeAs('invoices/bukti_pks', $filename, 'public');
        }

        $invoice->update($validated);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return response()->json([
            'success' => true,
            'message' => 'Invoice berhasil dihapus!'
        ]);
    }

    /**
     * Show the invoice input page with item management.
     */
    public function input()
    {
        $salesList = Sales::all();
        $pksList = SuratPerjanjian::select('id', 'no_surat', 'nama_pelanggan', 'nilai_kontrak', 'status_surat')
            ->where('status_surat', 'Disetujui')
            ->orderBy('created_at', 'desc')
            ->get();
        $noInvoice = $this->generateNextInvoiceNumber();
        return view('invoices.input', compact('salesList', 'pksList', 'noInvoice'));
    }

    /**
     * Store invoice with items.
     */
    public function storeWithItems(Request $request)
    {
        $validated = $request->validate([
            'no_invoice' => 'nullable|string|max:50|unique:invoices,no_invoice',
            'tanggal_invoice' => 'required|date',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            // Note: Invoice selalu Belum Lunas saat create, status akan otomatis update dari kuitansi
            'status_pembayaran' => 'required|in:Belum Lunas',
            'jatuh_tempo' => 'required|date',
            'keterangan' => 'nullable|string',
            'id_sales' => 'required|exists:sales,id',
            'id_pks' => 'nullable|exists:surat_perjanjians,id',
            'bukti_pks' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'items' => 'required|array|min:1',
            'items.*.id_kuitansi' => 'required|string',
            'items.*.jumlah' => 'required|numeric|min:1',
            'items.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        // Generate no_invoice if not provided
        $noInvoice = $validated['no_invoice'] ?? $this->generateNextInvoiceNumber();

        // Handle file upload
        $buktiPks = null;
        if ($request->hasFile('bukti_pks')) {
            $file = $request->file('bukti_pks');
            $filename = 'bukti_pks_' . time() . '_' . $file->getClientOriginalName();
            $buktiPks = $file->storeAs('invoices/bukti_pks', $filename, 'public');
        }

        // Calculate total
        $total = 0;
        foreach ($validated['items'] as $item) {
            $total += $item['jumlah'] * $item['harga_satuan'];
        }

        // Create invoice
        $invoice = Invoice::create([
            'no_invoice' => $noInvoice,
            'tanggal_invoice' => $validated['tanggal_invoice'],
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'alamat' => $validated['alamat'],
            'no_telp' => $validated['no_telp'],
            'email' => $validated['email'],
            'total_harga' => $total,
            'status_pembayaran' => $validated['status_pembayaran'],
            'jatuh_tempo' => $validated['jatuh_tempo'],
            'keterangan' => $validated['keterangan'],
            'id_sales' => $validated['id_sales'],
            'id_pks' => $validated['id_pks'] ?? null,
            'bukti_pks' => $buktiPks,
        ]);

        // Create detail items
        foreach ($validated['items'] as $item) {
            $invoice->detailInvoices()->create([
                'id_kuitansi' => $item['id_kuitansi'],
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $item['harga_satuan'],
                'subtotal' => $item['jumlah'] * $item['harga_satuan'],
            ]);
        }

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Invoice dengan items berhasil dibuat!');
    }

    /**
     * Generate next invoice number.
     */
    public function generateInvoiceNumber()
    {
        $year = date('Y');
        $month = date('m');
        
        // Get last invoice number for current month
        $lastInvoice = Invoice::whereYear('tanggal_invoice', $year)
            ->whereMonth('tanggal_invoice', $month)
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastInvoice) {
            // Try to extract number from existing invoice_number if it exists
            if ($lastInvoice->invoice_number && preg_match('/INV-\d{4}-\d{2}-(\d{4})/', $lastInvoice->invoice_number, $matches)) {
                $lastNumber = (int) $matches[1];
                $nextNumber = $lastNumber + 1;
            } else {
                // Fallback to ID-based numbering
                $nextNumber = $lastInvoice->id + 1;
            }
        } else {
            $nextNumber = 1;
        }
        
        // Format: INV-2025-12-0001
        $invoiceNumber = sprintf('INV-%s-%s-%04d', $year, $month, $nextNumber);
        
        return response()->json(['invoice_number' => $invoiceNumber]);
    }

    /**
     * Store quick invoice from modal.
     */
    public function storeQuick(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|string|max:50|unique:invoices,invoice_number',
            'no_kontrak' => 'nullable|string|max:50',
            'nama_pelanggan' => 'required|string|max:255',
            'status_pembayaran' => 'required|in:Lunas,Belum Lunas,Cicilan',
            'tanggal_invoice' => 'required|date',
            'id_sales' => 'required|exists:sales,id',
        ]);

        // Create invoice with basic info
        $invoice = Invoice::create([
            'invoice_number' => $validated['invoice_number'],
            'no_kontrak' => $validated['no_kontrak'],
            'tanggal_invoice' => $validated['tanggal_invoice'],
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'alamat' => null,
            'no_telp' => null,
            'email' => null,
            'total_harga' => 0, // Default 0, can be updated later
            'status_pembayaran' => $validated['status_pembayaran'],
            'jatuh_tempo' => now()->addDays(30), // Default 30 days
            'keterangan' => null,
            'id_sales' => $validated['id_sales'],
        ]);

        // Return JSON response for AJAX
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Invoice berhasil dibuat!',
                'redirect' => route('invoices.edit', $invoice->id)
            ]);
        }

        return redirect()->route('invoices.edit', $invoice->id)
            ->with('success', 'Invoice berhasil dibuat! Silakan lengkapi detail invoice.');
    }

    /**
     * Create invoice from PKS (Surat Perjanjian Kerjasama).
     */
    public function createFromPks(SuratPerjanjian $pks)
    {
        // Check if PKS is approved
        if ($pks->status_surat !== 'Disetujui') {
            return redirect()->back()
                ->with('error', 'Hanya PKS dengan status Disetujui yang dapat dibuat Invoice!');
        }

        $salesList = Sales::all();
        
        // Pre-fill data from PKS
        $prefillData = [
            'nama_pelanggan' => $pks->nama_pelanggan,
            'alamat' => $pks->alamat_pelanggan,
            'no_telp' => $pks->no_telp_pelanggan,
            'email' => $pks->email_pelanggan,
            'id_sales' => $pks->id_sales,
            'no_kontrak' => $pks->no_surat,
            'id_pks' => $pks->id,
        ];
        
        // Calculate remaining contract value
        $remainingValue = $pks->remaining_contract_value;
        
        return view('invoices.create-from-pks', compact('pks', 'salesList', 'prefillData', 'remainingValue'));
    }

    /**
     * Store invoice created from PKS.
     */
    public function storeFromPks(Request $request, SuratPerjanjian $pks)
    {
        // Validate PKS status
        if ($pks->status_surat !== 'Disetujui') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya PKS dengan status Disetujui yang dapat dibuat Invoice!'
            ], 400);
        }

        $validated = $request->validate([
            'invoice_number' => 'required|string|max:50|unique:invoices,invoice_number',
            'tanggal_invoice' => 'required|date',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'total_harga' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|in:Lunas,Belum Lunas,Cicilan',
            'jatuh_tempo' => 'required|date',
            'keterangan' => 'nullable|string',
            'id_sales' => 'required|exists:sales,id',
        ]);

        // Check if total doesn't exceed remaining contract value
        $remainingValue = $pks->remaining_contract_value;
        if ($validated['total_harga'] > $remainingValue) {
            return response()->json([
                'success' => false,
                'message' => "Total invoice tidak boleh melebihi sisa nilai kontrak (Rp " . number_format($remainingValue, 0, ',', '.') . ")"
            ], 400);
        }

        // Create invoice linked to PKS
        $invoice = Invoice::create([
            'invoice_number' => $validated['invoice_number'],
            'no_kontrak' => $pks->no_surat,
            'tanggal_invoice' => $validated['tanggal_invoice'],
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'alamat' => $validated['alamat'],
            'no_telp' => $validated['no_telp'],
            'email' => $validated['email'],
            'total_harga' => $validated['total_harga'],
            'status_pembayaran' => $validated['status_pembayaran'],
            'jatuh_tempo' => $validated['jatuh_tempo'],
            'keterangan' => $validated['keterangan'],
            'id_sales' => $validated['id_sales'],
            'id_pks' => $pks->id,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Invoice berhasil dibuat dari PKS!',
                'redirect' => route('invoices.show', $invoice->id)
            ]);
        }

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Invoice berhasil dibuat dari PKS!');
    }

    /**
     * Get available PKS list for invoice creation.
     */
    public function getAvailablePks()
    {
        $pksList = SuratPerjanjian::where('status_surat', 'Disetujui')
            ->with('sales')
            ->get()
            ->filter(function ($pks) {
                return $pks->remaining_contract_value > 0;
            })
            ->map(function ($pks) {
                return [
                    'id' => $pks->id,
                    'no_surat' => $pks->no_surat,
                    'nama_pelanggan' => $pks->nama_pelanggan,
                    'nilai_kontrak' => $pks->nilai_kontrak,
                    'total_invoiced' => $pks->total_invoiced,
                    'remaining_value' => $pks->remaining_contract_value,
                    'sales_name' => $pks->sales->nama_sales ?? '-',
                ];
            });

        return response()->json($pksList->values());
    }

    /**
     * Request revision for invoice (Marketing Manager only).
     * Returns invoice to Sales for revision.
     */
    public function requestRevision(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'keterangan' => 'nullable|string|max:500',
        ]);

        // Add revision note to keterangan
        $revisionNote = $validated['keterangan'] ?? 'Perlu revisi oleh Marketing Manager';
        $existingNote = $invoice->keterangan ? $invoice->keterangan . "\n\n" : '';
        $newNote = $existingNote . "[REVISI " . now()->format('d/m/Y H:i') . "]: " . $revisionNote;

        $invoice->update([
            'status_pembayaran' => 'Revisi',
            'keterangan' => $newNote,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Invoice telah dikembalikan ke Sales untuk direvisi.',
        ]);
    }

    /**
     * Approve invoice (Marketing Manager only).
     */
    public function approveInvoice(Invoice $invoice)
    {
        $invoice->update([
            'status_pembayaran' => 'Belum Lunas',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Invoice telah disetujui dan siap dikirim ke client.',
        ]);
    }

    /**
     * Update invoice status.
     */
    public function updateStatus(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'status_pembayaran' => 'required|in:Lunas,Belum Lunas,Cicilan,Revisi',
        ]);

        $invoice->update(['status_pembayaran' => $validated['status_pembayaran']]);

        return response()->json([
            'success' => true,
            'message' => 'Status invoice berhasil diperbarui menjadi ' . $validated['status_pembayaran'],
            'new_status' => $validated['status_pembayaran']
        ]);
    }

    /**
     * Generate next invoice number.
     */
    protected function generateNextInvoiceNumber(): string
    {
        $year = date('Y');
        $month = date('m');
        $prefix = 'INV-' . $year . $month . '-';
        
        $lastInvoice = Invoice::where('no_invoice', 'like', $prefix . '%')
            ->orderByRaw("CAST(SUBSTRING(no_invoice, ?) AS INTEGER) DESC", [strlen($prefix) + 1])
            ->first();
        
        if ($lastInvoice && preg_match('/INV-\d{6}-(\d{4})/', $lastInvoice->no_invoice, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = 1;
        }
        
        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
