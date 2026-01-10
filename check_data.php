<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Invoice;
use App\Models\Kuitansi;
use Carbon\Carbon;

echo "Current Date: " . Carbon::now()->format('Y-m-d') . PHP_EOL;
echo "Current Month: " . Carbon::now()->format('Y-m') . PHP_EOL;
echo PHP_EOL;

echo "=== INVOICES ===" . PHP_EOL;
$invoices = Invoice::all();
echo "Total Invoices: " . $invoices->count() . PHP_EOL;
echo "Lunas Invoices: " . $invoices->where('status_pembayaran', 'Lunas')->count() . PHP_EOL;
echo PHP_EOL;

foreach ($invoices as $inv) {
    echo "{$inv->no_invoice} | {$inv->status_pembayaran} | Rp " . number_format($inv->total_harga) . " | {$inv->created_at->format('Y-m-d')}" . PHP_EOL;
}

echo PHP_EOL;
echo "=== KUITANSIS ===" . PHP_EOL;
$kuitansis = Kuitansi::all();
echo "Total Kuitansis: " . $kuitansis->count() . PHP_EOL;
$thisMonth = $kuitansis->filter(fn($k) => $k->tanggal_kuitansi->format('Y-m') == Carbon::now()->format('Y-m'));
echo "Kuitansis this month (" . Carbon::now()->format('Y-m') . "): " . $thisMonth->count() . PHP_EOL;
echo "Total Revenue this month: Rp " . number_format($thisMonth->sum('total_bayar')) . PHP_EOL;
echo PHP_EOL;

foreach ($kuitansis as $k) {
    echo "{$k->no_kuitansi} | Rp " . number_format($k->total_bayar) . " | {$k->tanggal_kuitansi->format('Y-m-d')}" . PHP_EOL;
}
