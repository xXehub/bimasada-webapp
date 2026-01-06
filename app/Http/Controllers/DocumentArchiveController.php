<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Kuitansi;
use App\Models\SuratPerjanjian;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DocumentArchiveController extends Controller
{
    const CACHE_TTL = 300; // 5 minutes

    /**
     * Display the archive index page
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get all sales for filter dropdown (Manager only)
        $salesList = $user->hasRole('Marketing Manager') 
            ? Sales::orderBy('nama_sales')->get() 
            : collect();

        // Get statistics with caching
        $cacheKey = $user->hasRole('Marketing Manager') 
            ? 'archive_stats_all' 
            : "archive_stats_sales_{$user->id}";

        $stats = Cache::remember($cacheKey, self::CACHE_TTL, function () use ($user) {
            return $this->getArchiveStats($user);
        });

        return view('archive.index', compact('salesList', 'stats'));
    }

    /**
     * Get archive statistics - OPTIMIZED
     */
    private function getArchiveStats($user)
    {
        $isManager = $user->hasRole('Marketing Manager');
        
        // PKS Stats - OPTIMIZED: Single query with groupBy
        $pksQuery = DB::table('surat_perjanjians')
            ->select('status_surat', DB::raw('COUNT(*) as count'));
        if (!$isManager) {
            $pksQuery->where('id_sales', $user->id);
        }
        $pksRaw = $pksQuery->groupBy('status_surat')->pluck('count', 'status_surat')->toArray();
        
        $pksStats = [
            'total' => array_sum($pksRaw),
            'active' => $pksRaw['Aktif'] ?? 0,
            'completed' => $pksRaw['Selesai'] ?? 0,
            'cancelled' => $pksRaw['Dibatalkan'] ?? 0,
        ];

        // Invoice Stats - OPTIMIZED: Single query with groupBy
        $invoiceQuery = DB::table('invoices')
            ->select('status_pembayaran', DB::raw('COUNT(*) as count'));
        if (!$isManager) {
            $invoiceQuery->where('id_sales', $user->id);
        }
        $invoiceRaw = $invoiceQuery->groupBy('status_pembayaran')->pluck('count', 'status_pembayaran')->toArray();
        
        $invoiceStats = [
            'total' => array_sum($invoiceRaw),
            'paid' => $invoiceRaw['Lunas'] ?? 0,
            'pending' => ($invoiceRaw['Terkirim'] ?? 0) + ($invoiceRaw['Dibayar Sebagian'] ?? 0),
            'overdue' => $invoiceRaw['Jatuh Tempo'] ?? 0,
        ];

        // Kuitansi Stats - OPTIMIZED: Single query
        $now = Carbon::now();
        $kuitansiQuery = DB::table('kuitansis')
            ->select(
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM tanggal_kuitansi) = ' . $now->month . ' AND EXTRACT(YEAR FROM tanggal_kuitansi) = ' . $now->year . ' THEN 1 ELSE 0 END) as this_month')
            );
        if (!$isManager) {
            $kuitansiQuery->join('invoices', 'kuitansis.id_invoice', '=', 'invoices.id')
                          ->where('invoices.id_sales', $user->id);
        }
        $kuitansiRaw = $kuitansiQuery->first();
        
        $kuitansiStats = [
            'total' => $kuitansiRaw->total ?? 0,
            'this_month' => $kuitansiRaw->this_month ?? 0,
        ];

        // Total Revenue - OPTIMIZED
        $revenueQuery = DB::table('invoices')
            ->where('status_pembayaran', 'Lunas');
        if (!$isManager) {
            $revenueQuery->where('id_sales', $user->id);
        }
        $totalRevenue = $revenueQuery->sum('total_harga') ?? 0;

        return [
            'pks' => $pksStats,
            'invoice' => $invoiceStats,
            'kuitansi' => $kuitansiStats,
            'total_revenue' => $totalRevenue,
            'total_documents' => $pksStats['total'] + $invoiceStats['total'] + $kuitansiStats['total'],
        ];
    }

    /**
     * Get archive data for DataTables (unified view)
     */
    public function getData(Request $request)
    {
        $user = Auth::user();
        $isManager = $user->hasRole('Marketing Manager');
        
        $type = $request->get('type', 'all');
        $status = $request->get('status');
        $salesId = $request->get('sales_id');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $search = $request->get('search')['value'] ?? '';

        $documents = collect();

        // Get PKS documents
        if ($type === 'all' || $type === 'pks') {
            $pksQuery = SuratPerjanjian::with('sales');
            
            if (!$isManager) {
                $pksQuery->where('id_sales', $user->id);
            } elseif ($salesId) {
                $pksQuery->where('id_sales', $salesId);
            }
            
            if ($status && $type === 'pks') {
                $pksQuery->where('status_surat', $status);
            }
            
            if ($dateFrom) {
                $pksQuery->whereDate('tanggal_surat', '>=', $dateFrom);
            }
            if ($dateTo) {
                $pksQuery->whereDate('tanggal_surat', '<=', $dateTo);
            }
            
            if ($search) {
                $pksQuery->where(function($q) use ($search) {
                    $q->where('no_surat', 'like', "%{$search}%")
                      ->orWhere('nama_pelanggan', 'like', "%{$search}%");
                });
            }

            $pksDocs = $pksQuery->get()->map(function($pks) {
                return [
                    'id' => $pks->id,
                    'type' => 'PKS',
                    'type_badge' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">PKS</span>',
                    'number' => $pks->no_surat,
                    'date' => $pks->tanggal_surat ? $pks->tanggal_surat->format('d M Y') : '-',
                    'date_raw' => $pks->tanggal_surat ? $pks->tanggal_surat->format('Y-m-d') : '',
                    'customer' => $pks->nama_pelanggan,
                    'amount' => $pks->nilai_kontrak,
                    'amount_formatted' => 'Rp ' . number_format($pks->nilai_kontrak ?? 0, 0, ',', '.'),
                    'status' => $pks->status_surat,
                    'status_badge' => $this->getPksStatusBadge($pks->status_surat),
                    'sales' => $pks->sales->nama_sales ?? '-',
                    'url' => route('surat-perjanjians.show', $pks->id),
                    'edit_url' => route('surat-perjanjians.edit', $pks->id),
                    'created_at' => $pks->created_at->format('Y-m-d H:i:s'),
                ];
            });

            $documents = $documents->concat($pksDocs);
        }

        // Get Invoice documents
        if ($type === 'all' || $type === 'invoice') {
            $invoiceQuery = Invoice::with('sales');
            
            if (!$isManager) {
                $invoiceQuery->where('id_sales', $user->id);
            } elseif ($salesId) {
                $invoiceQuery->where('id_sales', $salesId);
            }
            
            if ($status && $type === 'invoice') {
                $invoiceQuery->where('status_pembayaran', $status);
            }
            
            if ($dateFrom) {
                $invoiceQuery->whereDate('tanggal_invoice', '>=', $dateFrom);
            }
            if ($dateTo) {
                $invoiceQuery->whereDate('tanggal_invoice', '<=', $dateTo);
            }
            
            if ($search) {
                $invoiceQuery->where(function($q) use ($search) {
                    $q->where('invoice_number', 'like', "%{$search}%")
                      ->orWhere('nama_pelanggan', 'like', "%{$search}%");
                });
            }

            $invoiceDocs = $invoiceQuery->get()->map(function($inv) {
                return [
                    'id' => $inv->id,
                    'type' => 'Invoice',
                    'type_badge' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Invoice</span>',
                    'number' => $inv->invoice_number,
                    'date' => $inv->tanggal_invoice ? $inv->tanggal_invoice->format('d M Y') : '-',
                    'date_raw' => $inv->tanggal_invoice ? $inv->tanggal_invoice->format('Y-m-d') : '',
                    'customer' => $inv->nama_pelanggan,
                    'amount' => $inv->total_harga,
                    'amount_formatted' => 'Rp ' . number_format($inv->total_harga ?? 0, 0, ',', '.'),
                    'status' => $inv->status_pembayaran,
                    'status_badge' => $this->getInvoiceStatusBadge($inv->status_pembayaran),
                    'sales' => $inv->sales->nama_sales ?? '-',
                    'url' => route('invoices.show', $inv->id),
                    'edit_url' => route('invoices.edit', $inv->id),
                    'created_at' => $inv->created_at->format('Y-m-d H:i:s'),
                ];
            });

            $documents = $documents->concat($invoiceDocs);
        }

        // Get Kuitansi documents
        if ($type === 'all' || $type === 'kuitansi') {
            $kuitansiQuery = Kuitansi::with(['invoice.sales']);
            
            if (!$isManager) {
                $kuitansiQuery->whereHas('invoice', fn($q) => $q->where('id_sales', $user->id));
            } elseif ($salesId) {
                $kuitansiQuery->whereHas('invoice', fn($q) => $q->where('id_sales', $salesId));
            }
            
            if ($status && $type === 'kuitansi') {
                $kuitansiQuery->where('status_kuitansi', $status);
            }
            
            if ($dateFrom) {
                $kuitansiQuery->whereDate('tanggal_kuitansi', '>=', $dateFrom);
            }
            if ($dateTo) {
                $kuitansiQuery->whereDate('tanggal_kuitansi', '<=', $dateTo);
            }
            
            if ($search) {
                $kuitansiQuery->where(function($q) use ($search) {
                    $q->where('no_kuitansi', 'like', "%{$search}%")
                      ->orWhere('nama_pelanggan', 'like', "%{$search}%");
                });
            }

            $kuitansiDocs = $kuitansiQuery->get()->map(function($k) {
                return [
                    'id' => $k->id,
                    'type' => 'Kuitansi',
                    'type_badge' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">Kuitansi</span>',
                    'number' => $k->no_kuitansi,
                    'date' => $k->tanggal_kuitansi ? $k->tanggal_kuitansi->format('d M Y') : '-',
                    'date_raw' => $k->tanggal_kuitansi ? $k->tanggal_kuitansi->format('Y-m-d') : '',
                    'customer' => $k->nama_pelanggan,
                    'amount' => $k->total_bayar,
                    'amount_formatted' => 'Rp ' . number_format($k->total_bayar ?? 0, 0, ',', '.'),
                    'status' => $k->status_kuitansi,
                    'status_badge' => $this->getKuitansiStatusBadge($k->status_kuitansi),
                    'sales' => $k->invoice->sales->nama_sales ?? '-',
                    'url' => route('kuitansis.show', $k->id),
                    'edit_url' => route('kuitansis.edit', $k->id),
                    'created_at' => $k->created_at->format('Y-m-d H:i:s'),
                ];
            });

            $documents = $documents->concat($kuitansiDocs);
        }

        // Sort by date (newest first)
        $documents = $documents->sortByDesc('created_at')->values();

        // Manual pagination for DataTables
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        
        $total = $documents->count();
        $filtered = $documents->slice($start, $length)->values();

        return response()->json([
            'draw' => intval($request->get('draw')),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $filtered,
        ]);
    }

    /**
     * Show document relations for a specific customer/PKS
     */
    public function showRelations(Request $request, $pksId = null)
    {
        $user = Auth::user();
        $isManager = $user->hasRole('Marketing Manager');

        if ($pksId) {
            // Show relations for specific PKS
            $pks = SuratPerjanjian::with(['sales', 'invoices.kuitansis'])->findOrFail($pksId);
            
            // Authorization check
            if (!$isManager && $pks->id_sales !== $user->id) {
                abort(403, 'Unauthorized access');
            }

            $relations = [
                'pks' => $pks,
                'invoices' => $pks->invoices,
                'kuitansis' => $pks->invoices->flatMap->kuitansis,
                'timeline' => $this->buildTimeline($pks),
            ];

            return view('archive.relations', compact('relations', 'pks'));
        }

        // Get all PKS with relations for index
        $pksQuery = SuratPerjanjian::with(['sales', 'invoices.kuitansis'])
            ->withCount(['invoices', 'invoices as paid_invoices_count' => function($q) {
                $q->where('status_pembayaran', 'Lunas');
            }]);

        if (!$isManager) {
            $pksQuery->where('id_sales', $user->id);
        }

        $pksList = $pksQuery->latest()->paginate(10);

        return view('archive.relations-index', compact('pksList'));
    }

    /**
     * Build timeline for a PKS
     */
    private function buildTimeline($pks)
    {
        $timeline = collect();

        // PKS created
        $timeline->push([
            'type' => 'pks_created',
            'date' => $pks->created_at,
            'title' => 'PKS Dibuat',
            'description' => "PKS {$pks->no_surat} dibuat",
            'icon' => 'document',
            'color' => 'blue',
        ]);

        // PKS status changes (if approved)
        if ($pks->status_surat === 'Disetujui' || $pks->status_surat === 'Aktif' || $pks->status_surat === 'Selesai') {
            $timeline->push([
                'type' => 'pks_approved',
                'date' => $pks->updated_at,
                'title' => 'PKS Disetujui',
                'description' => "PKS {$pks->no_surat} telah disetujui",
                'icon' => 'check',
                'color' => 'green',
            ]);
        }

        // Invoices
        foreach ($pks->invoices as $invoice) {
            $timeline->push([
                'type' => 'invoice_created',
                'date' => $invoice->created_at,
                'title' => 'Invoice Dibuat',
                'description' => "Invoice {$invoice->invoice_number} - " . number_format($invoice->total_harga ?? 0, 0, ',', '.'),
                'icon' => 'receipt',
                'color' => 'green',
                'url' => route('invoices.show', $invoice->id),
            ]);

            // Kuitansis for this invoice
            foreach ($invoice->kuitansis as $kuitansi) {
                $timeline->push([
                    'type' => 'kuitansi_created',
                    'date' => $kuitansi->created_at,
                    'title' => 'Pembayaran Diterima',
                    'description' => "Kuitansi {$kuitansi->no_kuitansi} - Rp " . number_format($kuitansi->total_bayar ?? 0, 0, ',', '.'),
                    'icon' => 'cash',
                    'color' => 'purple',
                    'url' => route('kuitansis.show', $kuitansi->id),
                ]);
            }

            if ($invoice->status_pembayaran === 'Lunas') {
                $timeline->push([
                    'type' => 'invoice_paid',
                    'date' => $invoice->updated_at,
                    'title' => 'Invoice Lunas',
                    'description' => "Invoice {$invoice->invoice_number} telah lunas",
                    'icon' => 'check-circle',
                    'color' => 'green',
                ]);
            }
        }

        // PKS completed
        if ($pks->status_surat === 'Selesai') {
            $timeline->push([
                'type' => 'pks_completed',
                'date' => $pks->updated_at,
                'title' => 'PKS Selesai',
                'description' => "PKS {$pks->no_surat} telah selesai",
                'icon' => 'flag',
                'color' => 'gray',
            ]);
        }

        return $timeline->sortBy('date')->values();
    }

    /**
     * Export documents to Excel
     */
    public function export(Request $request)
    {
        $user = Auth::user();
        $isManager = $user->hasRole('Marketing Manager');
        
        $type = $request->get('type', 'all');
        $format = $request->get('format', 'csv');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $salesId = $request->get('sales_id');

        $data = collect();
        $filename = 'document_archive_' . Carbon::now()->format('Y-m-d_His');

        // Build export data based on type
        if ($type === 'all' || $type === 'pks') {
            $query = SuratPerjanjian::with('sales');
            if (!$isManager) $query->where('id_sales', $user->id);
            if ($salesId && $isManager) $query->where('id_sales', $salesId);
            if ($dateFrom) $query->whereDate('tanggal_surat', '>=', $dateFrom);
            if ($dateTo) $query->whereDate('tanggal_surat', '<=', $dateTo);

            $data = $data->concat($query->get()->map(fn($p) => [
                'Tipe' => 'PKS',
                'Nomor' => $p->no_surat,
                'Tanggal' => $p->tanggal_surat?->format('d/m/Y'),
                'Pelanggan' => $p->nama_pelanggan,
                'Nilai' => $p->nilai_kontrak,
                'Status' => $p->status_surat,
                'Sales' => $p->sales->nama_sales ?? '-',
            ]));
        }

        if ($type === 'all' || $type === 'invoice') {
            $query = Invoice::with('sales');
            if (!$isManager) $query->where('id_sales', $user->id);
            if ($salesId && $isManager) $query->where('id_sales', $salesId);
            if ($dateFrom) $query->whereDate('tanggal_invoice', '>=', $dateFrom);
            if ($dateTo) $query->whereDate('tanggal_invoice', '<=', $dateTo);

            $data = $data->concat($query->get()->map(fn($i) => [
                'Tipe' => 'Invoice',
                'Nomor' => $i->invoice_number,
                'Tanggal' => $i->tanggal_invoice?->format('d/m/Y'),
                'Pelanggan' => $i->nama_pelanggan,
                'Nilai' => $i->total_harga,
                'Status' => $i->status_pembayaran,
                'Sales' => $i->sales->nama_sales ?? '-',
            ]));
        }

        if ($type === 'all' || $type === 'kuitansi') {
            $query = Kuitansi::with('invoice.sales');
            if (!$isManager) $query->whereHas('invoice', fn($q) => $q->where('id_sales', $user->id));
            if ($salesId && $isManager) $query->whereHas('invoice', fn($q) => $q->where('id_sales', $salesId));
            if ($dateFrom) $query->whereDate('tanggal_kuitansi', '>=', $dateFrom);
            if ($dateTo) $query->whereDate('tanggal_kuitansi', '<=', $dateTo);

            $data = $data->concat($query->get()->map(fn($k) => [
                'Tipe' => 'Kuitansi',
                'Nomor' => $k->no_kuitansi,
                'Tanggal' => $k->tanggal_kuitansi?->format('d/m/Y'),
                'Pelanggan' => $k->nama_pelanggan,
                'Nilai' => $k->total_bayar,
                'Status' => $k->status_kuitansi,
                'Sales' => $k->invoice->sales->nama_sales ?? '-',
            ]));
        }

        // Generate CSV
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['Tipe', 'Nomor', 'Tanggal', 'Pelanggan', 'Nilai', 'Status', 'Sales']);
            
            // Data
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Status badge helpers
     */
    private function getPksStatusBadge($status)
    {
        $badges = [
            'Draft' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Draft</span>',
            'Menunggu Persetujuan' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">Menunggu</span>',
            'Disetujui' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Disetujui</span>',
            'Aktif' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">Aktif</span>',
            'Selesai' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">Selesai</span>',
            'Dibatalkan' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Dibatalkan</span>',
        ];
        return $badges[$status] ?? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">' . $status . '</span>';
    }

    private function getInvoiceStatusBadge($status)
    {
        $badges = [
            'Draft' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Draft</span>',
            'Terkirim' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">Terkirim</span>',
            'Dibayar Sebagian' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">Sebagian</span>',
            'Lunas' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Lunas</span>',
            'Jatuh Tempo' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Jatuh Tempo</span>',
            'Belum Lunas' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400">Belum Lunas</span>',
        ];
        return $badges[$status] ?? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">' . $status . '</span>';
    }

    private function getKuitansiStatusBadge($status)
    {
        $badges = [
            'Draft' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Draft</span>',
            'Terverifikasi' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Terverifikasi</span>',
            'Lunas' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Lunas</span>',
        ];
        return $badges[$status] ?? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">' . $status . '</span>';
    }

    /**
     * Clear archive cache
     */
    public static function clearCache(?int $salesId = null)
    {
        Cache::forget('archive_stats_all');
        if ($salesId) {
            Cache::forget("archive_stats_sales_{$salesId}");
        }
    }
}
