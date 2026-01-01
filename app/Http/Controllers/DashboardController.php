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
    // Cache duration in seconds (5 minutes)
    const CACHE_TTL = 300;

    public function index()
    {
        $user = Auth::user();
        
        // Get role-based dashboard data
        if ($user->hasRole('Marketing Manager')) {
            return $this->managerDashboard();
        } elseif ($user->hasRole('Sales')) {
            return $this->salesDashboard();
        } else {
            return $this->adminDashboard();
        }
    }

    /**
     * Dashboard untuk Sales
     */
    private function salesDashboard()
    {
        $user = Auth::user();
        $cacheKey = "dashboard_sales_{$user->id}";
        
        $data = Cache::remember($cacheKey, self::CACHE_TTL, function () use ($user) {
            // PKS Statistics (milik Sales ini) - using correct column: status_surat
            $pksStats = [
                'total' => SuratPerjanjian::where('id_sales', $user->id)->count(),
                'draft' => SuratPerjanjian::where('id_sales', $user->id)->where('status_surat', 'Draft')->count(),
                'pending' => SuratPerjanjian::where('id_sales', $user->id)->where('status_surat', 'Menunggu Persetujuan')->count(),
                'approved' => SuratPerjanjian::where('id_sales', $user->id)->where('status_surat', 'Disetujui')->count(),
                'active' => SuratPerjanjian::where('id_sales', $user->id)->where('status_surat', 'Aktif')->count(),
                'completed' => SuratPerjanjian::where('id_sales', $user->id)->where('status_surat', 'Selesai')->count(),
            ];

            // Invoice Statistics (milik Sales ini) - using correct column: status_pembayaran
            $invoiceStats = [
                'total' => Invoice::where('id_sales', $user->id)->count(),
                'draft' => Invoice::where('id_sales', $user->id)->where('status_pembayaran', 'Draft')->count(),
                'sent' => Invoice::where('id_sales', $user->id)->where('status_pembayaran', 'Terkirim')->count(),
                'partial' => Invoice::where('id_sales', $user->id)->where('status_pembayaran', 'Dibayar Sebagian')->count(),
                'paid' => Invoice::where('id_sales', $user->id)->where('status_pembayaran', 'Lunas')->count(),
                'overdue' => Invoice::where('id_sales', $user->id)->where('status_pembayaran', 'Jatuh Tempo')->count(),
            ];

            // Kuitansi Statistics - optimized with direct join
            $kuitansiTotal = DB::table('kuitansis')
                ->join('invoices', 'kuitansis.id_invoice', '=', 'invoices.id')
                ->where('invoices.id_sales', $user->id)
                ->count();
                
            $kuitansiThisMonth = DB::table('kuitansis')
                ->join('invoices', 'kuitansis.id_invoice', '=', 'invoices.id')
                ->where('invoices.id_sales', $user->id)
                ->whereMonth('kuitansis.tanggal_kuitansi', Carbon::now()->month)
                ->whereYear('kuitansis.tanggal_kuitansi', Carbon::now()->year)
                ->count();

            $kuitansiStats = [
                'total' => $kuitansiTotal,
                'this_month' => $kuitansiThisMonth,
            ];

            // Revenue calculations - using correct column: total_harga
            $totalRevenue = Invoice::where('id_sales', $user->id)
                ->where('status_pembayaran', 'Lunas')
                ->sum('total_harga');

            $thisMonthRevenue = Invoice::where('id_sales', $user->id)
                ->where('status_pembayaran', 'Lunas')
                ->whereMonth('updated_at', Carbon::now()->month)
                ->whereYear('updated_at', Carbon::now()->year)
                ->sum('total_harga');

            $lastMonthRevenue = Invoice::where('id_sales', $user->id)
                ->where('status_pembayaran', 'Lunas')
                ->whereMonth('updated_at', Carbon::now()->subMonth()->month)
                ->whereYear('updated_at', Carbon::now()->subMonth()->year)
                ->sum('total_harga');

            $revenueGrowth = $lastMonthRevenue > 0 
                ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
                : ($thisMonthRevenue > 0 ? 100 : 0);

            return compact(
                'pksStats',
                'invoiceStats',
                'kuitansiStats',
                'totalRevenue',
                'thisMonthRevenue',
                'revenueGrowth'
            );
        });

        // Non-cached data (real-time)
        $recentPks = SuratPerjanjian::where('id_sales', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $recentInvoices = Invoice::where('id_sales', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Pending Actions - real-time
        $pendingActions = collect();
        
        // PKS yang perlu disubmit
        $draftPks = SuratPerjanjian::where('id_sales', $user->id)
            ->where('status_surat', 'Draft')
            ->take(5)
            ->get();
        foreach ($draftPks as $pks) {
            $pendingActions->push([
                'type' => 'pks_draft',
                'title' => 'PKS Draft: ' . $pks->no_surat,
                'description' => 'Kirim untuk persetujuan',
                'url' => route('surat-perjanjians.show', $pks->id),
                'priority' => 'medium',
                'date' => $pks->created_at,
            ]);
        }

        // Invoice yang belum dikirim
        $draftInvoices = Invoice::where('id_sales', $user->id)
            ->where('status_pembayaran', 'Draft')
            ->take(5)
            ->get();
        foreach ($draftInvoices as $inv) {
            $pendingActions->push([
                'type' => 'invoice_draft',
                'title' => 'Invoice Draft: ' . $inv->invoice_number,
                'description' => 'Kirim ke client',
                'url' => route('invoices.show', $inv->id),
                'priority' => 'medium',
                'date' => $inv->created_at,
            ]);
        }

        // Invoice jatuh tempo
        $overdueInvoices = Invoice::where('id_sales', $user->id)
            ->where('status_pembayaran', 'Jatuh Tempo')
            ->take(5)
            ->get();
        foreach ($overdueInvoices as $inv) {
            $pendingActions->push([
                'type' => 'invoice_overdue',
                'title' => 'Invoice Jatuh Tempo: ' . $inv->invoice_number,
                'description' => 'Follow up pembayaran',
                'url' => route('invoices.show', $inv->id),
                'priority' => 'high',
                'date' => $inv->jatuh_tempo,
            ]);
        }

        $pendingActions = $pendingActions->sortByDesc('priority')->take(10);

        // Merge cached and non-cached data
        return view('dashboard.sales', array_merge($data, compact(
            'recentPks',
            'recentInvoices',
            'pendingActions'
        )));
    }

    /**
     * Dashboard untuk Marketing Manager
     */
    private function managerDashboard()
    {
        $cacheKey = "dashboard_manager";
        
        $data = Cache::remember($cacheKey, self::CACHE_TTL, function () {
            // Overall Statistics - using correct column: status_surat
            $pksStats = [
                'total' => SuratPerjanjian::count(),
                'pending_approval' => SuratPerjanjian::where('status_surat', 'Menunggu Persetujuan')->count(),
                'approved' => SuratPerjanjian::where('status_surat', 'Disetujui')->count(),
                'active' => SuratPerjanjian::where('status_surat', 'Aktif')->count(),
                'completed' => SuratPerjanjian::where('status_surat', 'Selesai')->count(),
                'cancelled' => SuratPerjanjian::where('status_surat', 'Dibatalkan')->count(),
            ];

            // Invoice Statistics - using correct column: status_pembayaran
            $invoiceStats = [
                'total' => Invoice::count(),
                'draft' => Invoice::where('status_pembayaran', 'Draft')->count(),
                'sent' => Invoice::where('status_pembayaran', 'Terkirim')->count(),
                'partial' => Invoice::where('status_pembayaran', 'Dibayar Sebagian')->count(),
                'paid' => Invoice::where('status_pembayaran', 'Lunas')->count(),
                'overdue' => Invoice::where('status_pembayaran', 'Jatuh Tempo')->count(),
            ];

            // Kuitansi Statistics - using correct column: total_bayar, tanggal_kuitansi
            $kuitansiStats = [
                'total' => Kuitansi::count(),
                'this_month' => Kuitansi::whereMonth('tanggal_kuitansi', Carbon::now()->month)
                    ->whereYear('tanggal_kuitansi', Carbon::now()->year)
                    ->count(),
                'total_amount' => Kuitansi::sum('total_bayar'),
            ];

            // Revenue calculations - using correct columns
            $totalRevenue = Invoice::where('status_pembayaran', 'Lunas')->sum('total_harga');
            $pendingRevenue = Invoice::whereIn('status_pembayaran', ['Terkirim', 'Dibayar Sebagian'])->sum('total_harga');

            $thisMonthRevenue = Kuitansi::whereMonth('tanggal_kuitansi', Carbon::now()->month)
                ->whereYear('tanggal_kuitansi', Carbon::now()->year)
                ->sum('total_bayar');

            $lastMonthRevenue = Kuitansi::whereMonth('tanggal_kuitansi', Carbon::now()->subMonth()->month)
                ->whereYear('tanggal_kuitansi', Carbon::now()->subMonth()->year)
                ->sum('total_bayar');

            $revenueGrowth = $lastMonthRevenue > 0 
                ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
                : ($thisMonthRevenue > 0 ? 100 : 0);

            // Monthly trend (last 6 months)
            $monthlyTrend = collect();
            for ($i = 5; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                $monthlyTrend->push([
                    'month' => $month->format('M Y'),
                    'pks' => SuratPerjanjian::whereMonth('created_at', $month->month)
                        ->whereYear('created_at', $month->year)
                        ->count(),
                    'invoices' => Invoice::whereMonth('created_at', $month->month)
                        ->whereYear('created_at', $month->year)
                        ->count(),
                    'revenue' => Kuitansi::whereMonth('tanggal_kuitansi', $month->month)
                        ->whereYear('tanggal_kuitansi', $month->year)
                        ->sum('total_bayar'),
                ]);
            }

            // Sales Performance - using correct columns
            $salesPerformance = User::role('Sales')
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

        // Non-cached data - real time
        $pendingPks = SuratPerjanjian::where('status_surat', 'Menunggu Persetujuan')
            ->latest()
            ->take(10)
            ->get();

        // Recent Activity - real time
        $recentActivity = collect();

        // Recent PKS
        $recentPksActivity = SuratPerjanjian::latest()
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

        // Recent Invoices
        $recentInvoiceActivity = Invoice::latest()
            ->take(5)
            ->get()
            ->map(fn($inv) => [
                'type' => 'invoice',
                'title' => 'Invoice: ' . $inv->invoice_number,
                'description' => 'Client: ' . ($inv->nama_pelanggan ?? 'Unknown'),
                'status' => $inv->status_pembayaran,
                'url' => route('invoices.show', $inv->id),
                'date' => $inv->created_at,
            ]);

        // Recent Kuitansi
        $recentKuitansiActivity = Kuitansi::with('invoice')
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
