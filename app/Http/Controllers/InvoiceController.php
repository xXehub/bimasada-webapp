<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Sales;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Invoice::with('sales');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_telp', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status_pembayaran', $request->status);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'tanggal_invoice');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $invoices = $query->paginate(10);

        return view('invoices.index', compact('invoices'));
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
}
