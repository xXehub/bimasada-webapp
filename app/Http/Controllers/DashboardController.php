<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Kuitansi;
use App\Models\SuratPerjanjian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
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
        $currentMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        // PKS Statistics (milik Sales ini)
        $pksStats = [
            'total' => SuratPerjanjian::where('id_sales', $user->id)->count(),
            'draft' => SuratPerjanjian::where('id_sales', $user->id)->where('status_pks', 'Draft')->count(),
            'pending' => SuratPerjanjian::where('id_sales', $user->id)->where('status_pks', 'Menunggu Persetujuan')->count(),
            'approved' => SuratPerjanjian::where('id_sales', $user->id)->where('status_pks', 'Disetujui')->count(),
            'active' => SuratPerjanjian::where('id_sales', $user->id)->where('status_pks', 'Aktif')->count(),
            'completed' => SuratPerjanjian::where('id_sales', $user->id)->where('status_pks', 'Selesai')->count(),
        ];

        // Invoice Statistics (milik Sales ini)
        $invoiceStats = [
            'total' => Invoice::where('id_sales', $user->id)->count(),
            'draft' => Invoice::where('id_sales', $user->id)->where('status_invoice', 'Draft')->count(),
            'sent' => Invoice::where('id_sales', $user->id)->where('status_invoice', 'Terkirim')->count(),
            'partial' => Invoice::where('id_sales', $user->id)->where('status_invoice', 'Dibayar Sebagian')->count(),
            'paid' => Invoice::where('id_sales', $user->id)->where('status_invoice', 'Lunas')->count(),
            'overdue' => Invoice::where('id_sales', $user->id)->where('status_invoice', 'Jatuh Tempo')->count(),
        ];

        // Kuitansi Statistics
        $kuitansiStats = [
            'total' => Kuitansi::whereHas('invoice', fn($q) => $q->where('id_sales', $user->id))->count(),
            'this_month' => Kuitansi::whereHas('invoice', fn($q) => $q->where('id_sales', $user->id))
                ->whereMonth('tanggal_bayar', Carbon::now()->month)
                ->whereYear('tanggal_bayar', Carbon::now()->year)
                ->count(),
        ];

        // Revenue calculations
        $totalRevenue = Invoice::where('id_sales', $user->id)
            ->where('status_invoice', 'Lunas')
            ->sum('grand_total');

        $thisMonthRevenue = Invoice::where('id_sales', $user->id)
            ->where('status_invoice', 'Lunas')
            ->whereMonth('updated_at', Carbon::now()->month)
            ->whereYear('updated_at', Carbon::now()->year)
            ->sum('grand_total');

        $lastMonthRevenue = Invoice::where('id_sales', $user->id)
            ->where('status_invoice', 'Lunas')
            ->whereMonth('updated_at', Carbon::now()->subMonth()->month)
            ->whereYear('updated_at', Carbon::now()->subMonth()->year)
            ->sum('grand_total');

        $revenueGrowth = $lastMonthRevenue > 0 
            ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : ($thisMonthRevenue > 0 ? 100 : 0);

        // Recent PKS
        $recentPks = SuratPerjanjian::where('id_sales', $user->id)
            ->with('sales')
            ->latest()
            ->take(5)
            ->get();

        // Recent Invoices
        $recentInvoices = Invoice::where('id_sales', $user->id)
            ->with('sales')
            ->latest()
            ->take(5)
            ->get();

        // Pending Actions
        $pendingActions = collect();
        
        // PKS yang perlu disubmit
        $draftPks = SuratPerjanjian::where('id_sales', $user->id)
            ->where('status_pks', 'Draft')
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
            ->where('status_invoice', 'Draft')
            ->get();
        foreach ($draftInvoices as $inv) {
            $pendingActions->push([
                'type' => 'invoice_draft',
                'title' => 'Invoice Draft: ' . $inv->no_invoice,
                'description' => 'Kirim ke client',
                'url' => route('invoices.show', $inv->id),
                'priority' => 'medium',
                'date' => $inv->created_at,
            ]);
        }

        // Invoice jatuh tempo
        $overdueInvoices = Invoice::where('id_sales', $user->id)
            ->where('status_invoice', 'Jatuh Tempo')
            ->get();
        foreach ($overdueInvoices as $inv) {
            $pendingActions->push([
                'type' => 'invoice_overdue',
                'title' => 'Invoice Jatuh Tempo: ' . $inv->no_invoice,
                'description' => 'Follow up pembayaran',
                'url' => route('invoices.show', $inv->id),
                'priority' => 'high',
                'date' => $inv->jatuh_tempo,
            ]);
        }

        $pendingActions = $pendingActions->sortByDesc('priority')->take(10);

        return view('dashboard.sales', compact(
            'pksStats',
            'invoiceStats',
            'kuitansiStats',
            'totalRevenue',
            'thisMonthRevenue',
            'revenueGrowth',
            'recentPks',
            'recentInvoices',
            'pendingActions'
        ));
    }

    /**
     * Dashboard untuk Marketing Manager
     */
    private function managerDashboard()
    {
        // Overall Statistics
        $pksStats = [
            'total' => SuratPerjanjian::count(),
            'pending_approval' => SuratPerjanjian::where('status_pks', 'Menunggu Persetujuan')->count(),
            'approved' => SuratPerjanjian::where('status_pks', 'Disetujui')->count(),
            'active' => SuratPerjanjian::where('status_pks', 'Aktif')->count(),
            'completed' => SuratPerjanjian::where('status_pks', 'Selesai')->count(),
            'cancelled' => SuratPerjanjian::where('status_pks', 'Dibatalkan')->count(),
        ];

        $invoiceStats = [
            'total' => Invoice::count(),
            'draft' => Invoice::where('status_invoice', 'Draft')->count(),
            'sent' => Invoice::where('status_invoice', 'Terkirim')->count(),
            'partial' => Invoice::where('status_invoice', 'Dibayar Sebagian')->count(),
            'paid' => Invoice::where('status_invoice', 'Lunas')->count(),
            'overdue' => Invoice::where('status_invoice', 'Jatuh Tempo')->count(),
        ];

        $kuitansiStats = [
            'total' => Kuitansi::count(),
            'this_month' => Kuitansi::whereMonth('tanggal_bayar', Carbon::now()->month)
                ->whereYear('tanggal_bayar', Carbon::now()->year)
                ->count(),
            'total_amount' => Kuitansi::sum('jumlah_bayar'),
        ];

        // Revenue calculations
        $totalRevenue = Invoice::where('status_invoice', 'Lunas')->sum('grand_total');
        $pendingRevenue = Invoice::whereIn('status_invoice', ['Terkirim', 'Dibayar Sebagian'])->sum('grand_total');

        $thisMonthRevenue = Kuitansi::whereMonth('tanggal_bayar', Carbon::now()->month)
            ->whereYear('tanggal_bayar', Carbon::now()->year)
            ->sum('jumlah_bayar');

        $lastMonthRevenue = Kuitansi::whereMonth('tanggal_bayar', Carbon::now()->subMonth()->month)
            ->whereYear('tanggal_bayar', Carbon::now()->subMonth()->year)
            ->sum('jumlah_bayar');

        $revenueGrowth = $lastMonthRevenue > 0 
            ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : ($thisMonthRevenue > 0 ? 100 : 0);

        // PKS awaiting approval
        $pendingPks = SuratPerjanjian::where('status_pks', 'Menunggu Persetujuan')
            ->with('sales')
            ->latest()
            ->take(10)
            ->get();

        // Sales Performance
        $salesPerformance = User::role('Sales')
            ->withCount([
                'suratPerjanjians as pks_count',
                'suratPerjanjians as pks_approved_count' => fn($q) => $q->where('status_pks', 'Disetujui'),
                'invoices as invoice_count',
                'invoices as invoice_paid_count' => fn($q) => $q->where('status_invoice', 'Lunas'),
            ])
            ->withSum(['invoices as total_revenue' => fn($q) => $q->where('status_invoice', 'Lunas')], 'grand_total')
            ->get();

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
                'revenue' => Kuitansi::whereMonth('tanggal_bayar', $month->month)
                    ->whereYear('tanggal_bayar', $month->year)
                    ->sum('jumlah_bayar'),
            ]);
        }

        // Recent Activity
        $recentActivity = collect();

        // Recent PKS
        $recentPksActivity = SuratPerjanjian::with('sales')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($pks) => [
                'type' => 'pks',
                'title' => 'PKS: ' . $pks->no_surat,
                'description' => 'oleh ' . ($pks->sales->name ?? 'Unknown'),
                'status' => $pks->status_pks,
                'url' => route('surat-perjanjians.show', $pks->id),
                'date' => $pks->created_at,
            ]);

        // Recent Invoices
        $recentInvoiceActivity = Invoice::with('sales')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($inv) => [
                'type' => 'invoice',
                'title' => 'Invoice: ' . $inv->no_invoice,
                'description' => 'oleh ' . ($inv->sales->name ?? 'Unknown'),
                'status' => $inv->status_invoice,
                'url' => route('invoices.show', $inv->id),
                'date' => $inv->created_at,
            ]);

        // Recent Kuitansi
        $recentKuitansiActivity = Kuitansi::with('invoice.sales')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($k) => [
                'type' => 'kuitansi',
                'title' => 'Kuitansi: ' . $k->no_kuitansi,
                'description' => 'Rp ' . number_format($k->jumlah_bayar, 0, ',', '.'),
                'status' => $k->status_kuitansi,
                'url' => route('kuitansis.show', $k->id),
                'date' => $k->created_at,
            ]);

        $recentActivity = $recentPksActivity
            ->concat($recentInvoiceActivity)
            ->concat($recentKuitansiActivity)
            ->sortByDesc('date')
            ->take(10);

        return view('dashboard.manager', compact(
            'pksStats',
            'invoiceStats',
            'kuitansiStats',
            'totalRevenue',
            'pendingRevenue',
            'thisMonthRevenue',
            'revenueGrowth',
            'pendingPks',
            'salesPerformance',
            'monthlyTrend',
            'recentActivity'
        ));
    }

    /**
     * Dashboard untuk Admin
     */
    private function adminDashboard()
    {
        // Same as manager but with additional admin features
        return $this->managerDashboard();
    }

    /**
     * API untuk chart data
     */
    public function getChartData(Request $request)
    {
        $type = $request->get('type', 'revenue');
        $period = $request->get('period', 6); // months

        $data = collect();

        for ($i = $period - 1; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            
            switch ($type) {
                case 'revenue':
                    $value = Kuitansi::whereMonth('tanggal_bayar', $month->month)
                        ->whereYear('tanggal_bayar', $month->year)
                        ->sum('jumlah_bayar');
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

            $data->push([
                'label' => $month->format('M'),
                'value' => $value,
            ]);
        }

        return response()->json($data);
    }
}
