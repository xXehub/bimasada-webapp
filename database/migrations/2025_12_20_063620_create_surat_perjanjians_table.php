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
        Schema::create('surat_perjanjians', function (Blueprint $table) {
            $table->id(); // auto-generated PK (id_surat di ERD)
            $table->date('tanggal_surat');
            $table->string('nama_pelanggan');
            $table->string('alamat_pelanggan');
            $table->string('no_telp_pelanggan');
            $table->string('email_pelanggan');
            $table->date('tanggal_selesai');
            $table->decimal('nilai_kontrak', 15, 2);
            $table->text('syarat_ketentuan');
            $table->string('status_surat'); // Draft/Aktif/Selesai
            $table->string('nama_pihak_pertama');
            $table->string('nama_pihak_kedua');
            $table->foreignId('id_sales')->constrained('sales')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_perjanjians');
    }
};
