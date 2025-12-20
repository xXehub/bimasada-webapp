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
        Schema::create('detail_kuitansis', function (Blueprint $table) {
            $table->integer('id_detail_kuitansi')->primary(); // PK
            $table->foreignId('id_kuitansi')->constrained('kuitansis')->onDelete('cascade');
            $table->string('id_txtKtl'); // referensi ke Google Drive
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_kuitansis');
    }
};
