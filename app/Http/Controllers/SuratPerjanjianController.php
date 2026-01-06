<?php

namespace App\Http\Controllers;

use App\Models\SuratPerjanjian;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SuratPerjanjianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get sales list for modal - only needed columns
        $salesList = User::role('Sales')->select('id', 'name')->get();
        
        // OPTIMIZED: Get stats in single query using groupBy
        $statsRaw = SuratPerjanjian::select('status_surat', \DB::raw('COUNT(*) as count'))
            ->groupBy('status_surat')
            ->pluck('count', 'status_surat')
            ->toArray();
        
        $stats = [
            'total' => array_sum($statsRaw),
            'draft' => $statsRaw['Draft'] ?? 0,
            'active' => $statsRaw['Aktif'] ?? 0,
            'approved' => $statsRaw['Disetujui'] ?? 0,
            'expired' => $statsRaw['Kadaluarsa'] ?? 0,
        ];

        return view('surat-perjanjians.index', compact('salesList', 'stats'));
    }

    /**
     * Get data for DataTables server-side processing.
     */
    public function getData(Request $request)
    {
        $query = SuratPerjanjian::with('salesUser');

        // Apply status filter if provided
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status_surat', $request->status);
        }

        return DataTables::of($query)
            ->addColumn('no_surat_display', function ($surat) {
                return $surat->no_surat ?? 'PKS-' . str_pad($surat->id, 4, '0', STR_PAD_LEFT);
            })
            ->addColumn('customer_display', function ($surat) {
                $initials = strtoupper(substr($surat->nama_pelanggan, 0, 2));
                $subText = $surat->email_pelanggan ?? $surat->no_telp_pelanggan ?? '';
                return [
                    'name' => $surat->nama_pelanggan,
                    'initials' => $initials,
                    'sub' => $subText
                ];
            })
            ->addColumn('contract_value_display', function ($surat) {
                return 'Rp ' . number_format($surat->nilai_kontrak, 0, ',', '.');
            })
            ->addColumn('date_display', function ($surat) {
                return $surat->tanggal_surat->format('d M Y');
            })
            ->addColumn('end_date_display', function ($surat) {
                return [
                    'date' => $surat->tanggal_selesai->format('d M Y'),
                    'is_expired' => $surat->tanggal_selesai->isPast()
                ];
            })
            ->addColumn('sales_name', function ($surat) {
                return $surat->salesUser->name ?? '-';
            })
            ->addColumn('status_badge', function ($surat) {
                $variants = [
                    'Draft' => 'secondary',
                    'Aktif' => 'info',
                    'Disetujui' => 'success',
                    'Kadaluarsa' => 'danger',
                    'Dibatalkan' => 'warning'
                ];
                return [
                    'status' => $surat->status_surat,
                    'variant' => $variants[$surat->status_surat] ?? 'secondary'
                ];
            })
            ->addColumn('actions', function ($surat) {
                return $surat->id;
            })
            ->filterColumn('customer_display', function($query, $keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->where('nama_pelanggan', 'like', "%{$keyword}%")
                      ->orWhere('email_pelanggan', 'like', "%{$keyword}%")
                      ->orWhere('no_telp_pelanggan', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('sales_name', function($query, $keyword) {
                $query->whereHas('salesUser', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
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
        $salesList = User::role('Sales')->select('id', 'name')->get();
        return view('surat-perjanjians.create', compact('salesList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_surat' => 'required|date',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat_pelanggan' => 'required|string',
            'no_telp_pelanggan' => 'nullable|string|max:50',
            'email_pelanggan' => 'nullable|email|max:255',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_surat',
            'nilai_kontrak' => 'required|numeric|min:0',
            'syarat_ketentuan' => 'nullable|string',
            'status_surat' => 'required|in:Draft,Aktif,Disetujui,Kadaluarsa,Dibatalkan',
            'nama_pihak_pertama' => 'required|string|max:255',
            'nama_pihak_kedua' => 'required|string|max:255',
            'id_sales' => 'required|exists:users,id',
        ]);

        $surat = SuratPerjanjian::create($validated);

        return redirect()->route('surat-perjanjians.index')
            ->with('success', 'Surat Perjanjian Kerjasama berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratPerjanjian $suratPerjanjian)
    {
        $suratPerjanjian->load('salesUser', 'detailSurats', 'invoices');
        return view('surat-perjanjians.show', compact('suratPerjanjian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratPerjanjian $suratPerjanjian)
    {
        $salesList = User::role('Sales')->select('id', 'name')->get();
        return view('surat-perjanjians.edit', compact('suratPerjanjian', 'salesList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratPerjanjian $suratPerjanjian)
    {
        $validated = $request->validate([
            'tanggal_surat' => 'required|date',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat_pelanggan' => 'required|string',
            'no_telp_pelanggan' => 'nullable|string|max:50',
            'email_pelanggan' => 'nullable|email|max:255',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_surat',
            'nilai_kontrak' => 'required|numeric|min:0',
            'syarat_ketentuan' => 'nullable|string',
            'status_surat' => 'required|in:Draft,Aktif,Disetujui,Kadaluarsa,Dibatalkan',
            'nama_pihak_pertama' => 'required|string|max:255',
            'nama_pihak_kedua' => 'required|string|max:255',
            'id_sales' => 'required|exists:users,id',
        ]);

        $suratPerjanjian->update($validated);

        return redirect()->route('surat-perjanjians.index')
            ->with('success', 'Surat Perjanjian Kerjasama berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratPerjanjian $suratPerjanjian)
    {
        $suratPerjanjian->delete();

        return response()->json([
            'success' => true,
            'message' => 'Surat Perjanjian Kerjasama berhasil dihapus!'
        ]);
    }

    /**
     * Generate next PKS number.
     */
    public function generatePKSNumber()
    {
        $year = date('Y');
        $month = date('m');
        
        // Get last PKS number for current month
        $lastSurat = SuratPerjanjian::whereYear('tanggal_surat', $year)
            ->whereMonth('tanggal_surat', $month)
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastSurat && $lastSurat->no_surat && preg_match('/PKS-\d{4}-\d{2}-(\d{4})/', $lastSurat->no_surat, $matches)) {
            $lastNumber = (int) $matches[1];
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = ($lastSurat ? $lastSurat->id : 0) + 1;
        }
        
        // Format: PKS-2025-01-0001
        $pksNumber = sprintf('PKS-%s-%s-%04d', $year, $month, $nextNumber);
        
        return response()->json(['pks_number' => $pksNumber]);
    }

    /**
     * Store quick PKS from modal.
     */
    public function storeQuick(Request $request)
    {
        $validated = $request->validate([
            'no_surat' => 'nullable|string|max:50|unique:surat_perjanjians,no_surat',
            'nama_pelanggan' => 'required|string|max:255',
            'status_surat' => 'required|in:Draft,Aktif,Disetujui,Kadaluarsa,Dibatalkan',
            'tanggal_surat' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_surat',
            'nilai_kontrak' => 'required|numeric|min:0',
            'id_sales' => 'required|exists:users,id',
        ]);

        // Create PKS with basic info
        $surat = SuratPerjanjian::create([
            'no_surat' => $validated['no_surat'],
            'tanggal_surat' => $validated['tanggal_surat'],
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'alamat_pelanggan' => '-',
            'no_telp_pelanggan' => null,
            'email_pelanggan' => null,
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'nilai_kontrak' => $validated['nilai_kontrak'],
            'syarat_ketentuan' => null,
            'status_surat' => $validated['status_surat'],
            'nama_pihak_pertama' => '-',
            'nama_pihak_kedua' => $validated['nama_pelanggan'],
            'id_sales' => $validated['id_sales'],
        ]);

        // Return JSON response for AJAX
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Surat Perjanjian berhasil dibuat!',
                'redirect' => route('surat-perjanjians.edit', $surat->id)
            ]);
        }

        return redirect()->route('surat-perjanjians.edit', $surat->id)
            ->with('success', 'Surat Perjanjian berhasil dibuat! Silakan lengkapi detail PKS.');
    }

    /**
     * Update status of PKS (for approval workflow).
     */
    public function updateStatus(Request $request, SuratPerjanjian $suratPerjanjian)
    {
        $validated = $request->validate([
            'status_surat' => 'required|in:Draft,Aktif,Disetujui,Kadaluarsa,Dibatalkan',
        ]);

        $suratPerjanjian->update(['status_surat' => $validated['status_surat']]);

        return response()->json([
            'success' => true,
            'message' => 'Status Surat Perjanjian berhasil diupdate!',
            'new_status' => $validated['status_surat']
        ]);
    }

    /**
     * Approve PKS (Marketing Manager only).
     */
    public function approve(SuratPerjanjian $suratPerjanjian)
    {
        if ($suratPerjanjian->status_surat !== 'Aktif') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya PKS dengan status Aktif yang dapat disetujui!'
            ], 400);
        }

        $suratPerjanjian->update(['status_surat' => 'Disetujui']);

        return response()->json([
            'success' => true,
            'message' => 'Surat Perjanjian Kerjasama telah disetujui!'
        ]);
    }

    /**
     * Reject PKS (Marketing Manager only).
     * Returns PKS to Draft status for Sales to revise.
     */
    public function reject(SuratPerjanjian $suratPerjanjian)
    {
        if ($suratPerjanjian->status_surat !== 'Aktif') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya PKS dengan status Aktif yang dapat ditolak!'
            ], 400);
        }

        // Return to Draft so Sales can revise
        $suratPerjanjian->update(['status_surat' => 'Draft']);

        return response()->json([
            'success' => true,
            'message' => 'Surat Perjanjian Kerjasama telah ditolak dan dikembalikan ke Sales untuk diperbaiki.'
        ]);
    }
}
