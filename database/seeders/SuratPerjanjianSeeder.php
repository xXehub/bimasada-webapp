<?php

namespace Database\Seeders;

use App\Models\Sales;
use App\Models\SuratPerjanjian;
use Illuminate\Database\Seeder;

class SuratPerjanjianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = Sales::all();
        
        if ($sales->isEmpty()) {
            $this->command->warn('No sales found. Please run SalesSeeder first.');
            return;
        }

        $pksData = [
            [
                'no_surat' => 'PKS-2025-01-0001',
                'tanggal_surat' => '2025-01-15',
                'nama_pelanggan' => 'PT. Mitra Abadi',
                'alamat_pelanggan' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'no_telp_pelanggan' => '021-5551234',
                'email_pelanggan' => 'contact@mitraabadi.com',
                'tanggal_selesai' => '2026-01-15',
                'nilai_kontrak' => 150000000,
                'syarat_ketentuan' => 'Pembayaran dilakukan dalam 3 tahap: 30% di awal, 40% di tengah, 30% di akhir.',
                'status_surat' => 'Disetujui',
                'nama_pihak_pertama' => 'PT. Bimasada',
                'nama_pihak_kedua' => 'PT. Mitra Abadi',
                'id_sales' => $sales->first()->id,
            ],
            [
                'no_surat' => 'PKS-2025-01-0002',
                'tanggal_surat' => '2025-01-20',
                'nama_pelanggan' => 'CV. Sukses Mandiri',
                'alamat_pelanggan' => 'Jl. Gatot Subroto No. 45, Bandung',
                'no_telp_pelanggan' => '022-7771234',
                'email_pelanggan' => 'info@suksesmandiri.co.id',
                'tanggal_selesai' => '2025-07-20',
                'nilai_kontrak' => 75000000,
                'syarat_ketentuan' => 'Pembayaran dilakukan setelah pengiriman barang.',
                'status_surat' => 'Aktif',
                'nama_pihak_pertama' => 'PT. Bimasada',
                'nama_pihak_kedua' => 'CV. Sukses Mandiri',
                'id_sales' => $sales->last()->id ?? $sales->first()->id,
            ],
            [
                'no_surat' => 'PKS-2025-01-0003',
                'tanggal_surat' => '2025-01-25',
                'nama_pelanggan' => 'PT. Global Tech Indonesia',
                'alamat_pelanggan' => 'Jl. Thamrin No. 88, Jakarta Selatan',
                'no_telp_pelanggan' => '021-3331234',
                'email_pelanggan' => 'procurement@globaltech.id',
                'tanggal_selesai' => '2025-12-31',
                'nilai_kontrak' => 250000000,
                'syarat_ketentuan' => 'Kontrak dapat diperpanjang dengan kesepakatan kedua belah pihak.',
                'status_surat' => 'Draft',
                'nama_pihak_pertama' => 'PT. Bimasada',
                'nama_pihak_kedua' => 'PT. Global Tech Indonesia',
                'id_sales' => $sales->first()->id,
            ],
            [
                'no_surat' => 'PKS-2024-12-0001',
                'tanggal_surat' => '2024-12-01',
                'nama_pelanggan' => 'Toko Jaya Elektronik',
                'alamat_pelanggan' => 'Jl. Pasar Baru No. 15, Surabaya',
                'no_telp_pelanggan' => '031-5551234',
                'email_pelanggan' => 'jayaelektronik@gmail.com',
                'tanggal_selesai' => '2024-12-31',
                'nilai_kontrak' => 50000000,
                'syarat_ketentuan' => null,
                'status_surat' => 'Kadaluarsa',
                'nama_pihak_pertama' => 'PT. Bimasada',
                'nama_pihak_kedua' => 'Toko Jaya Elektronik',
                'id_sales' => $sales->last()->id ?? $sales->first()->id,
            ],
        ];

        foreach ($pksData as $pks) {
            SuratPerjanjian::create($pks);
        }

        $this->command->info('Surat Perjanjian seeded successfully!');
    }
}
