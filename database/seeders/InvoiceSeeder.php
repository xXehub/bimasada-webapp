<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sales;
use App\Models\Invoice;
use App\Models\DetailInvoice;
use Carbon\Carbon;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Sales (jika belum ada)
        $sales1 = Sales::create([
            'id_sales' => 'SLS001',
            'nama_sales' => 'John Doe',
            'username' => 'john.doe',
            'password' => bcrypt('password123'),
        ]);

        $sales2 = Sales::create([
            'id_sales' => 'SLS002',
            'nama_sales' => 'Jane Smith',
            'username' => 'jane.smith',
            'password' => bcrypt('password123'),
        ]);

        // Create Sample Invoices
        $invoices = [
            [
                'tanggal_invoice' => Carbon::now()->subDays(30),
                'nama_pelanggan' => 'PT. Maju Jaya Abadi',
                'alamat' => 'Jl. Sudirman No. 123, Jakarta',
                'no_telp' => '021-1234567',
                'email' => 'contact@majujaya.com',
                'total_harga' => 15000000,
                'status_pembayaran' => 'Lunas',
                'jatuh_tempo' => Carbon::now()->subDays(15),
                'keterangan' => 'Invoice untuk project website corporate',
                'id_sales' => $sales1->id,
            ],
            [
                'tanggal_invoice' => Carbon::now()->subDays(20),
                'nama_pelanggan' => 'CV. Berkah Sentosa',
                'alamat' => 'Jl. Gatot Subroto No. 45, Bandung',
                'no_telp' => '022-7654321',
                'email' => 'info@berkahsentosa.co.id',
                'total_harga' => 27500000,
                'status_pembayaran' => 'Belum Lunas',
                'jatuh_tempo' => Carbon::now()->addDays(10),
                'keterangan' => 'Invoice untuk sistem inventory',
                'id_sales' => $sales1->id,
            ],
            [
                'tanggal_invoice' => Carbon::now()->subDays(15),
                'nama_pelanggan' => 'UD. Sumber Rezeki',
                'alamat' => 'Jl. Ahmad Yani No. 78, Surabaya',
                'no_telp' => '031-9876543',
                'email' => 'contact@sumberrezeki.com',
                'total_harga' => 9500000,
                'status_pembayaran' => 'Cicilan',
                'jatuh_tempo' => Carbon::now()->addDays(20),
                'keterangan' => 'Invoice untuk aplikasi mobile',
                'id_sales' => $sales2->id,
            ],
            [
                'tanggal_invoice' => Carbon::now()->subDays(10),
                'nama_pelanggan' => 'PT. Teknologi Nusantara',
                'alamat' => 'Jl. HR Rasuna Said No. 12, Jakarta',
                'no_telp' => '021-5556789',
                'email' => 'admin@teknusantara.id',
                'total_harga' => 45000000,
                'status_pembayaran' => 'Lunas',
                'jatuh_tempo' => Carbon::now()->subDays(5),
                'keterangan' => 'Invoice untuk ERP system implementation',
                'id_sales' => $sales2->id,
            ],
            [
                'tanggal_invoice' => Carbon::now()->subDays(5),
                'nama_pelanggan' => 'CV. Mandiri Sejahtera',
                'alamat' => 'Jl. Diponegoro No. 234, Semarang',
                'no_telp' => '024-3334455',
                'email' => 'info@mandirisejahtera.com',
                'total_harga' => 18750000,
                'status_pembayaran' => 'Belum Lunas',
                'jatuh_tempo' => Carbon::now()->addDays(25),
                'keterangan' => 'Invoice untuk website e-commerce',
                'id_sales' => $sales1->id,
            ],
        ];

        foreach ($invoices as $invoiceData) {
            $invoice = Invoice::create($invoiceData);

            // Create detail invoice items
            for ($i = 1; $i <= 3; $i++) {
                DetailInvoice::create([
                    'id_invoice' => $invoice->id,
                    'id_kuitansi' => 'GDRIVE-' . uniqid(),
                    'jumlah' => rand(1, 5),
                    'harga_satuan' => rand(1000000, 5000000),
                    'subtotal' => rand(2000000, 10000000),
                ]);
            }
        }

        $this->command->info('Invoice seeder completed successfully!');
        $this->command->info('Created: 2 Sales, 5 Invoices with details');
    }
}
