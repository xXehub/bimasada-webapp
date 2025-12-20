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
        Schema::create('detail_surats', function (Blueprint $table) {
            $table->integer('id_detail_surat')->primary(); // PK
            $table->foreignId('id_surat')->constrained('surat_perjanjians')->onDelete('cascade');
            $table->string('id_txtKtl'); // referensi ke Google Drive
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 15, 2);
            $table->string('spesifikasi')->nullable();
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_surats');
    }
};
