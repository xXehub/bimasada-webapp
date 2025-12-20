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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id(); // auto-generated PK
            $table->date('tanggal_invoice');
            $table->string('nama_pelanggan');
            $table->string('alamat');
            $table->string('no_telp');
            $table->string('email');
            $table->decimal('total_harga', 15, 2);
            $table->string('status_pembayaran'); // Lunas/Belum Lunas/Cicilan
            $table->date('jatuh_tempo');
            $table->text('keterangan')->nullable();
            $table->foreignId('id_sales')->constrained('sales')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
