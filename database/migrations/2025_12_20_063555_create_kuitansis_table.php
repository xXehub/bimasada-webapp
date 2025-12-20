<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kuitansis', function (Blueprint $table) {
            $table->id(); // auto-generated PK
            $table->date('tanggal_kuitansi');
            $table->string('nama_pelanggan');
            $table->string('alamat');
            $table->string('no_telp');
            $table->decimal('total_bayar', 15, 2);
            $table->string('invoice_pembayaran'); // Cash/Transfer/Ciro
            $table->text('keterangan')->nullable();
            $table->integer('id_sales');
            $table->foreignId('id_invoice')->nullable()->constrained('invoices')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuitansis');
    }
};
