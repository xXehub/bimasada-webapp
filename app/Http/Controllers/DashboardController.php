<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Kuitansi;
use App\Models\SuratPerjanjian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // Cache duration in seconds (10 minutes for remote DB)
    const CACHE_TTL = 600;

    public function index()
    {
        $user = Auth::user();
        
        // Get cached roles to avoid DB query
        $cached = Cache::get("user_roles_perms_{$user->id}");
        $roles = $cached['roles'] ?? [];
        
        // Get role-based dashboard data (using cache first)
        if (in_array('Marketing Manager', $roles) || (!$cached && $user->hasRole('Marketing Manager'))) {
            return $this->managerDashboard();
        } elseif (in_array('Sales', $roles) || (!$cached && $user->hasRole('Sales'))) {
            return $this->salesDashboard();
        } else {
            return $this->adminDashboard();
        }
    }

    /**
     * Dashboard untuk Sales - OPTIMIZED
     */
    private function salesDashboard()
    {
        $user = Auth::user();
        $cacheKey = "dashboard_sales_{$user->id}";
        
        $data = Cache::remember($cacheKey, self::CACHE_TTL, function () use ($user) {
            // OPTIMIZED: Single query for PKS stats using groupBy
            $pksStatRaw = DB::table('surat_perjanjians')
                ->select('status_surat', DB::raw('COUNT(*) as count'))
                ->where('id_sales', $user->id)
                ->groupBy('status_surat')
                ->pluck('count', 'status_surat')
                ->toArray();

            $pksStats = [
                'total' => array_sum($pksStatRaw),
                'draft' => $pksStatRaw['Draft'] ?? 0,
                'pending' => $pksStatRaw['Aktif'] ?? 0,
                'approved' => $pksStatRaw['Disetujui'] ?? 0,
                'active' => $pksStatRaw['Disetujui'] ?? 0,
                'completed' => $pksStatRaw['Selesai'] ?? 0,
            ];

            // OPTIMIZED: Single query for Invoice stats
            $invoiceStatRaw = DB::table('invoices')
                ->select('status_pembayaran', DB::raw('COUNT(*) as count'))
                ->where('id_sales', $user->id)
                ->groupBy('status_pembayaran')
                ->pluck('count', 'status_pembayaran')
                ->toArray();

            $invoiceStats = [
                'total' => array_sum($invoiceStatRaw),
                'draft' => $invoiceStatRaw['Draft'] ?? 0,
                'sent' => $invoiceStatRaw['Terkirim'] ?? 0,
                'partial' => $invoiceStatRaw['Dibayar Sebagian'] ?? 0,
                'paid' => $invoiceStatRaw['Lunas'] ?? 0,
                'overdue' => $invoiceStatRaw['Jatuh Tempo'] ?? 0,
            ];

            // OPTIMIZED: Single query for Kuitansi stats
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            
            $kuitansiData = DB::table('kuitansis')
                ->join('invoices', 'kuitansis.id_invoice', '=', 'invoices.id')
                ->where('invoices.id_sales', $user->id)
                ->select(
                    DB::raw('COUNT(*) as total'),
                    DB::raw("SUM(CASE WHEN EXTRACT(MONTH FROM kuitansis.tanggal_kuitansi) = {$currentMonth} AND EXTRACT(YEAR FROM kuitansis.tanggal_kuitansi) = {$currentYear} THEN 1 ELSE 0 END) as this_month")
                )
                ->first();

            $kuitansiStats = [
                'total' => $kuitansiData->total ?? 0,
                'this_month' => $kuitansiData->this_month ?? 0,
            ];

            // OPTIMIZED: Revenue in single query
            $revenueData = DB::table('invoices')
                ->where('id_sales', $user->id)
                ->where('status_pembayaran', 'Lunas')
                ->select(
                    DB::raw('COALESCE(SUM(total_harga), 0) as total_revenue'),
                    DB::raw('COALESCE(SUM(CASE WHEN EXTRACT(MONTH FROM updated_at) = ' . Carbon::now()->month . ' AND EXTRACT(YEAR FROM updated_at) = ' . Carbon::now()->year . ' THEN total_harga ELSE 0 END), 0) as this_month'),
                    DB::raw('COALESCE(SUM(CASE WHEN EXTRACT(MONTH FROM updated_at) = ' . Carbon::now()->subMonth()->month . ' AND EXTRACT(YEAR FROM updated_at) = ' . Carbon::now()->subMonth()->year . ' THEN total_harga ELSE 0 END), 0) as last_month')
                )
                ->first();

            $totalRevenue = $revenueData->total_revenue ?? 0;
            $thisMonthRevenue = $revenueData->this_month ?? 0;
            $lastMonthRevenue = $revenueData->last_month ?? 0;

            $revenueGrowth = $lastMonthRevenue > 0 
                ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
                : ($thisMonthRevenue > 0 ? 100 : 0);

            // Monthly trend for Sales (6 months)
            $sixMonthsAgo = Carbon::now()->subMonths(5)->startOfMonth();
            
            $monthlyInvoices = DB::table('invoices')
                ->select(
                    DB::raw("TO_CHAR(created_at, 'YYYY-MM') as month_key"),
                    DB::raw('COUNT(*) as count')
                )
                ->where('id_sales', $user->id)
                ->where('created_at', '>=', $sixMonthsAgo)
                ->groupBy(DB::raw("TO_CHAR(created_at, 'YYYY-MM')"))
                ->pluck('count', 'month_key')
                ->toArray();

            $monthlyRevenue = DB::table('kuitansis')
                ->join('invoices', 'kuitansis.id_invoice', '=', 'invoices.id')
                ->select(
                    DB::raw("TO_CHAR(kuitansis.tanggal_kuitansi, 'YYYY-MM') as month_key"),
                    DB::raw('COALESCE(SUM(kuitansis.total_bayar), 0) as total')
                )
                ->where('invoices.id_sales', $user->id)
                ->where('kuitansis.tanggal_kuitansi', '>=', $sixMonthsAgo)
                ->groupBy(DB::raw("TO_CHAR(kuitansis.tanggal_kuitansi, 'YYYY-MM')"))
                ->pluck('total', 'month_key')
                ->toArray();

            $monthlyTrend = collect();
            for ($i = 5; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                $key = $month->format('Y-m');
                $monthlyTrend->push([
                    'month' => $month->format('M Y'),
                    'month_short' => $month->format('M'),
                    'invoices' => $monthlyInvoices[$key] ?? 0,
                    'revenue' => $monthlyRevenue[$key] ?? 0,
                ]);
            }

            return compact(
                'pksStats',
                'invoiceStats',
                'kuitansiStats',
                'totalRevenue',
                'thisMonthRevenue',
                'revenueGrowth',
                'monthlyTrend'
            );
        });

        // Non-cached data (real-time) - OPTIMIZED with select()
        $recentPks = SuratPerjanjian::where('id_sales', $user->id)
            ->select('id', 'no_surat', 'nama_pelanggan', 'status_surat', 'created_at')
            ->latest()
            ->take(5)
            ->get();

        $recentInvoices = Invoice::where('id_sales', $user->id)
            ->select('id', 'nama_pelanggan', 'status_pembayaran', 'jatuh_tempo', 'created_at')
            ->latest()
            ->take(5)
            ->get();

        // Pending Actions - OPTIMIZED: single query per type with select
        $pendingActions = collect();
        
        // PKS Draft
        SuratPerjanjian::where('id_sales', $user->id)
            ->where('status_surat', 'Draft')
            ->select('id', 'no_surat', 'created_at')
            ->take(5)
            ->get()
            ->each(function ($pks) use ($pendingActions) {
                $pendingActions->push([
                    'type' => 'pks_draft',
                    'title' => 'PKS Draft: ' . $pks->no_surat,
                    'description' => 'Kirim untuk persetujuan',
                    'url' => route('surat-perjanjians.show', $pks->id),
                    'priority' => 'medium',
                    'date' => $pks->created_at,
                ]);
            });

        // Invoice Draft
        Invoice::where('id_sales', $user->id)
            ->where('status_pembayaran', 'Draft')
            ->select('id', 'created_at')
            ->take(5)
            ->get()
            ->each(function ($inv) use ($pendingActions) {
                $pendingActions->push([
                    'type' => 'invoice_draft',
                    'title' => 'Invoice Draft: INV-' . str_pad($inv->id, 4, '0', STR_PAD_LEFT),
                    'description' => 'Kirim ke client',
                    'url' => route('invoices.show', $inv->id),
                    'priority' => 'medium',
                    'date' => $inv->created_at,
                ]);
            });

        // Invoice Jatuh Tempo
        Invoice::where('id_sales', $user->id)
            ->where('status_pembayaran', 'Jatuh Tempo')
            ->select('id', 'jatuh_tempo')
            ->take(5)
            ->get()
            ->each(function ($inv) use ($pendingActions) {
                $pendingActions->push([
                    'type' => 'invoice_overdue',
                    'title' => 'Invoice Jatuh Tempo: INV-' . str_pad($inv->id, 4, '0', STR_PAD_LEFT),
                    'description' => 'Follow up pembayaran',
                    'url' => route('invoices.show', $inv->id),
                    'priority' => 'high',
                    'date' => $inv->jatuh_tempo,
                ]);
            });

        $pendingActions = $pendingActions->sortByDesc('priority')->take(10);

        return view('dashboard.sales', array_merge($data, compact(
            'recentPks',
            'recentInvoices',
            'pendingActions'
        )));
    }

    /**
     * Dashboard untuk Marketing Manager - OPTIMIZED
     */
    private function managerDashboard()
    {
        $cacheKey = "dashboard_manager";
        
        $data = Cache::remember($cacheKey, self::CACHE_TTL, function () {
            // OPTIMIZED: Single query for PKS stats
            $pksStatRaw = DB::table('surat_perjanjians')
                ->select('status_surat', DB::raw('COUNT(*) as count'))
                ->groupBy('status_surat')
                ->pluck('count', 'status_surat')
                ->toArray();

            $pksStats = [
                'total' => array_sum($pksStatRaw),
                'pending_approval' => $pksStatRaw['Aktif'] ?? 0,
                'approved' => $pksStatRaw['Disetujui'] ?? 0,
                'active' => $pksStatRaw['Disetujui'] ?? 0,
                'completed' => $pksStatRaw['Selesai'] ?? 0,
                'cancelled' => $pksStatRaw['Dibatalkan'] ?? 0,
            ];

            // OPTIMIZED: Single query for Invoice stats
            $invoiceStatRaw = DB::table('invoices')
                ->select('status_pembayaran', DB::raw('COUNT(*) as count'))
                ->groupBy('status_pembayaran')
                ->pluck('count', 'status_pembayaran')
                ->toArray();

            $invoiceStats = [
                'total' => array_sum($invoiceStatRaw),
                'draft' => $invoiceStatRaw['Draft'] ?? 0,
                'sent' => $invoiceStatRaw['Terkirim'] ?? 0,
                'partial' => $invoiceStatRaw['Dibayar Sebagian'] ?? 0,
                'paid' => $invoiceStatRaw['Lunas'] ?? 0,
                'overdue' => $invoiceStatRaw['Jatuh Tempo'] ?? 0,
            ];

            // OPTIMIZED: Single query for Kuitansi stats
            $now = Carbon::now();
            $kuitansiData = DB::table('kuitansis')
                ->select(
                    DB::raw('COUNT(*) as total'),
                    DB::raw('COALESCE(SUM(total_bayar), 0) as total_amount'),
                    DB::raw('SUM(CASE WHEN EXTRACT(MONTH FROM tanggal_kuitansi) = ' . $now->month . ' AND EXTRACT(YEAR FROM tanggal_kuitansi) = ' . $now->year . ' THEN 1 ELSE 0 END) as this_month')
                )
                ->first();

            $kuitansiStats = [
                'total' => $kuitansiData->total ?? 0,
                'this_month' => $kuitansiData->this_month ?? 0,
                'total_amount' => $kuitansiData->total_amount ?? 0,
            ];

            // OPTIMIZED: Revenue in single query
            $totalRevenue = DB::table('invoices')
                ->where('status_pembayaran', 'Lunas')
                ->sum('total_harga') ?? 0;
                
            $pendingRevenue = DB::table('invoices')
                ->whereIn('status_pembayaran', ['Terkirim', 'Dibayar Sebagian'])
                ->sum('total_harga') ?? 0;

            $thisMonth = Carbon::now();
            $lastMonth = Carbon::now()->subMonth();

            $revenueByMonth = DB::table('kuitansis')
                ->select(
                    DB::raw('COALESCE(SUM(CASE WHEN EXTRACT(MONTH FROM tanggal_kuitansi) = ' . $thisMonth->month . ' AND EXTRACT(YEAR FROM tanggal_kuitansi) = ' . $thisMonth->year . ' THEN total_bayar ELSE 0 END), 0) as this_month'),
                    DB::raw('COALESCE(SUM(CASE WHEN EXTRACT(MONTH FROM tanggal_kuitansi) = ' . $lastMonth->month . ' AND EXTRACT(YEAR FROM tanggal_kuitansi) = ' . $lastMonth->year . ' THEN total_bayar ELSE 0 END), 0) as last_month')
                )
                ->first();

            $thisMonthRevenue = $revenueByMonth->this_month ?? 0;
            $lastMonthRevenue = $revenueByMonth->last_month ?? 0;

            $revenueGrowth = $lastMonthRevenue > 0 
                ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
                : ($thisMonthRevenue > 0 ? 100 : 0);

            // OPTIMIZED: Monthly trend in SINGLE query instead of 18 queries
            $sixMonthsAgo = Carbon::now()->subMonths(5)->startOfMonth();
            
            $monthlyPks = DB::table('surat_perjanjians')
                ->select(
                    DB::raw("TO_CHAR(created_at, 'YYYY-MM') as month_key"),
                    DB::raw('COUNT(*) as count')
                )
                ->where('created_at', '>=', $sixMonthsAgo)
                ->groupBy(DB::raw("TO_CHAR(created_at, 'YYYY-MM')"))
                ->pluck('count', 'month_key')
                ->toArray();

            $monthlyInvoices = DB::table('invoices')
                ->select(
                    DB::raw("TO_CHAR(created_at, 'YYYY-MM') as month_key"),
                    DB::raw('COUNT(*) as count')
                )
                ->where('created_at', '>=', $sixMonthsAgo)
                ->groupBy(DB::raw("TO_CHAR(created_at, 'YYYY-MM')"))
                ->pluck('count', 'month_key')
                ->toArray();

            $monthlyRevenue = DB::table('kuitansis')
                ->select(
                    DB::raw("TO_CHAR(tanggal_kuitansi, 'YYYY-MM') as month_key"),
                    DB::raw('COALESCE(SUM(total_bayar), 0) as total')
                )
                ->where('tanggal_kuitansi', '>=', $sixMonthsAgo)
                ->groupBy(DB::raw("TO_CHAR(tanggal_kuitansi, 'YYYY-MM')"))
                ->pluck('total', 'month_key')
                ->toArray();

            $monthlyTrend = collect();
            for ($i = 5; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                $key = $month->format('Y-m');
                $monthlyTrend->push([
                    'month' => $month->format('M Y'),
                    'month_short' => $month->format('M'),
                    'pks' => $monthlyPks[$key] ?? 0,
                    'invoices' => $monthlyInvoices[$key] ?? 0,
                    'revenue' => $monthlyRevenue[$key] ?? 0,
                ]);
            }

            // OPTIMIZED: Sales Performance with single query
            $salesPerformance = User::role('Sales')
                ->select('users.id', 'users.name')
                ->withCount([
                    'suratPerjanjians as pks_count',
                    'suratPerjanjians as pks_approved_count' => fn($q) => $q->where('status_surat', 'Disetujui'),
                    'invoices as invoice_count',
                    'invoices as invoice_paid_count' => fn($q) => $q->where('status_pembayaran', 'Lunas'),
                ])
                ->withSum(['invoices as total_revenue' => fn($q) => $q->where('status_pembayaran', 'Lunas')], 'total_harga')
                ->get();

            return compact(
                'pksStats',
                'invoiceStats',
                'kuitansiStats',
                'totalRevenue',
                'pendingRevenue',
                'thisMonthRevenue',
                'revenueGrowth',
                'monthlyTrend',
                'salesPerformance'
            );
        });

        // Non-cached data - real time with select() for speed
        $pendingPks = SuratPerjanjian::where('status_surat', 'Aktif')
            ->with('salesUser:id,name')
            ->select('id', 'no_surat', 'nama_pelanggan', 'id_sales', 'created_at')
            ->latest()
            ->take(10)
            ->get();

        // Recent Activity - OPTIMIZED with select()
        $recentPksActivity = SuratPerjanjian::select('id', 'no_surat', 'nama_pelanggan', 'status_surat', 'created_at')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($pks) => [
                'type' => 'pks',
                'title' => 'PKS: ' . $pks->no_surat,
                'description' => 'Client: ' . ($pks->nama_pelanggan ?? 'Unknown'),
                'status' => $pks->status_surat,
                'url' => route('surat-perjanjians.show', $pks->id),
                'date' => $pks->created_at,
            ]);

        $recentInvoiceActivity = Invoice::select('id', 'nama_pelanggan', 'status_pembayaran', 'created_at')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($inv) => [
                'type' => 'invoice',
                'title' => 'Invoice: INV-' . str_pad($inv->id, 4, '0', STR_PAD_LEFT),
                'description' => 'Client: ' . ($inv->nama_pelanggan ?? 'Unknown'),
                'status' => $inv->status_pembayaran,
                'url' => route('invoices.show', $inv->id),
                'date' => $inv->created_at,
            ]);

        $recentKuitansiActivity = Kuitansi::select('id', 'no_kuitansi', 'total_bayar', 'status_kuitansi', 'created_at')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($k) => [
                'type' => 'kuitansi',
                'title' => 'Kuitansi: ' . $k->no_kuitansi,
                'description' => 'Rp ' . number_format($k->total_bayar ?? 0, 0, ',', '.'),
                'status' => $k->status_kuitansi,
                'url' => route('kuitansis.show', $k->id),
                'date' => $k->created_at,
            ]);

        $recentActivity = $recentPksActivity
            ->concat($recentInvoiceActivity)
            ->concat($recentKuitansiActivity)
            ->sortByDesc('date')
            ->take(10);

        return view('dashboard.manager', array_merge($data, compact(
            'pendingPks',
            'recentActivity'
        )));
    }

    /**
     * Dashboard untuk Admin
     */
    private function adminDashboard()
    {
        return $this->managerDashboard();
    }

    /**
     * API untuk chart data - with caching
     */
    public function getChartData(Request $request)
    {
        $type = $request->get('type', 'revenue');
        $period = $request->get('period', 6);
        $cacheKey = "chart_data_{$type}_{$period}";

        $data = Cache::remember($cacheKey, self::CACHE_TTL, function () use ($type, $period) {
            $result = collect();

            for ($i = $period - 1; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                
                switch ($type) {
                    case 'revenue':
                        $value = Kuitansi::whereMonth('tanggal_kuitansi', $month->month)
                            ->whereYear('tanggal_kuitansi', $month->year)
                            ->sum('total_bayar');
                        break;
                    case 'pks':
                        $value = SuratPerjanjian::whereMonth('created_at', $month->month)
                            ->whereYear('created_at', $month->year)
                            ->count();
                        break;
                    case 'invoices':
                        $value = Invoice::whereMonth('created_at', $month->month)
                            ->whereYear('created_at', $month->year)
                            ->count();
                        break;
                    default:
                        $value = 0;
                }

                $result->push([
                    'label' => $month->format('M'),
                    'value' => $value,
                ]);
            }

            return $result;
        });

        return response()->json($data);
    }

    /**
     * Clear dashboard cache - call when data changes
     */
    public static function clearCache(?int $salesId = null)
    {
        Cache::forget('dashboard_manager');
        Cache::forget('chart_data_revenue_6');
        Cache::forget('chart_data_pks_6');
        Cache::forget('chart_data_invoices_6');
        
        if ($salesId) {
            Cache::forget("dashboard_sales_{$salesId}");
        }
    }
}
