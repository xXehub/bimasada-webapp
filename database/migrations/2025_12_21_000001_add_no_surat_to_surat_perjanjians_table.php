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
        Schema::table('surat_perjanjians', function (Blueprint $table) {
            // Add no_surat column for PKS number
            $table->string('no_surat', 50)->nullable()->unique()->after('id');
            
            // Make some fields nullable for flexibility
            $table->string('no_telp_pelanggan', 50)->nullable()->change();
            $table->string('email_pelanggan')->nullable()->change();
            $table->text('syarat_ketentuan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_perjanjians', function (Blueprint $table) {
            $table->dropColumn('no_surat');
            $table->string('no_telp_pelanggan')->nullable(false)->change();
            $table->string('email_pelanggan')->nullable(false)->change();
            $table->text('syarat_ketentuan')->nullable(false)->change();
        });
    }
};
