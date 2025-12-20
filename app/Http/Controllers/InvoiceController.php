<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Sales;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get sales list for modal
        $salesList = Sales::all();
        
        // Get stats for cards (all time or filtered)
        $statsQuery = Invoice::query();
        
        $stats = [
            'total' => $statsQuery->count(),
            'paid' => (clone $statsQuery)->where('status_pembayaran', 'Lunas')->count(),
            'pending' => (clone $statsQuery)->where('status_pembayaran', 'Belum Lunas')->count(),
            'installment' => (clone $statsQuery)->where('status_pembayaran', 'Cicilan')->count(),
        ];

        return view('invoices.index', compact('salesList', 'stats'));
    }

    /**
     * Get invoice data for DataTables server-side processing.
     */
    public function getData(Request $request)
    {
        $query = Invoice::with('sales');

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
                    'Cicilan' => 'info'
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
        $salesList = Sales::all();
        return view('invoices.create', compact('salesList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_invoice' => 'required|date',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'total_harga' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|in:Lunas,Belum Lunas,Cicilan',
            'jatuh_tempo' => 'required|date',
            'keterangan' => 'nullable|string',
            'id_sales' => 'required|exists:sales,id',
        ]);

        $invoice = Invoice::create($validated);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('sales', 'detailInvoices');
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $salesList = Sales::all();
        return view('invoices.edit', compact('invoice', 'salesList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'tanggal_invoice' => 'required|date',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'total_harga' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|in:Lunas,Belum Lunas,Cicilan',
            'jatuh_tempo' => 'required|date',
            'keterangan' => 'nullable|string',
            'id_sales' => 'required|exists:sales,id',
        ]);

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

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice berhasil dihapus!');
    }

    /**
     * Show the invoice input page with item management.
     */
    public function input()
    {
        $salesList = Sales::all();
        return view('invoices.input', compact('salesList'));
    }

    /**
     * Store invoice with items.
     */
    public function storeWithItems(Request $request)
    {
        $validated = $request->validate([
            'tanggal_invoice' => 'required|date',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'status_pembayaran' => 'required|in:Lunas,Belum Lunas,Cicilan',
            'jatuh_tempo' => 'required|date',
            'keterangan' => 'nullable|string',
            'id_sales' => 'required|exists:sales,id',
            'items' => 'required|array|min:1',
            'items.*.id_kuitansi' => 'required|string',
            'items.*.jumlah' => 'required|numeric|min:1',
            'items.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        // Calculate total
        $total = 0;
        foreach ($validated['items'] as $item) {
            $total += $item['jumlah'] * $item['harga_satuan'];
        }

        // Create invoice
        $invoice = Invoice::create([
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
}
