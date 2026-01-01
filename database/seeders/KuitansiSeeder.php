<?php

namespace Database\Seeders;

use App\Models\Kuitansi;
use App\Models\Invoice;
use App\Models\Sales;
use Illuminate\Database\Seeder;

class KuitansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = Sales::all();
        $invoices = Invoice::all();
        
        if ($sales->isEmpty()) {
            $this->command->warn('No sales found. Please run SalesSeeder first.');
            return;
        }

        $kuitansiData = [
            [
                'no_kuitansi' => 'KTN-2025-01-0001',
                'tanggal_kuitansi' => '2025-01-16',
                'nama_pelanggan' => 'PT. Mitra Abadi',
                'alamat' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'no_telp' => '021-5551234',
                'total_bayar' => 45000000,
                'invoice_pembayaran' => 'Transfer',
                'keterangan' => 'Pembayaran tahap 1 (30%)',
                'status_kuitansi' => 'Lunas',
                'id_sales' => $sales->first()->id,
                'id_invoice' => $invoices->first()?->id,
            ],
            [
                'no_kuitansi' => 'KTN-2025-01-0002',
                'tanggal_kuitansi' => '2025-01-20',
                'nama_pelanggan' => 'CV. Sukses Mandiri',
                'alamat' => 'Jl. Gatot Subroto No. 45, Bandung',
                'no_telp' => '022-7771234',
                'total_bayar' => 75000000,
                'invoice_pembayaran' => 'Cash',
                'keterangan' => 'Pembayaran lunas',
                'status_kuitansi' => 'Lunas',
                'id_sales' => $sales->last()->id ?? $sales->first()->id,
                'id_invoice' => null,
            ],
            [
                'no_kuitansi' => 'KTN-2025-01-0003',
                'tanggal_kuitansi' => '2025-01-25',
                'nama_pelanggan' => 'PT. Global Tech Indonesia',
                'alamat' => 'Jl. Thamrin No. 88, Jakarta Selatan',
                'no_telp' => '021-3331234',
                'total_bayar' => 100000000,
                'invoice_pembayaran' => 'Transfer',
                'keterangan' => 'DP Kontrak',
                'status_kuitansi' => 'Terkirim',
                'id_sales' => $sales->first()->id,
                'id_invoice' => null,
            ],
            [
                'no_kuitansi' => 'KTN-2025-01-0004',
                'tanggal_kuitansi' => '2025-01-28',
                'nama_pelanggan' => 'Toko Jaya Elektronik',
                'alamat' => 'Jl. Pasar Baru No. 15, Surabaya',
                'no_telp' => '031-5551234',
                'total_bayar' => 25000000,
                'invoice_pembayaran' => 'Ciro',
                'keterangan' => null,
                'status_kuitansi' => 'Draft',
                'id_sales' => $sales->last()->id ?? $sales->first()->id,
                'id_invoice' => null,
            ],
        ];

        foreach ($kuitansiData as $kuitansi) {
            Kuitansi::create($kuitansi);
        }

        $this->command->info('Kuitansi seeded successfully!');
    }
}
