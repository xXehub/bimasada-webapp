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
        Schema::table('kuitansis', function (Blueprint $table) {
            $table->string('no_kuitansi', 50)->nullable()->unique()->after('id');
            $table->string('status_kuitansi', 50)->default('Draft')->after('keterangan');
            // Make some fields nullable for flexibility
            $table->string('no_telp')->nullable()->change();
            $table->string('alamat')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kuitansis', function (Blueprint $table) {
            $table->dropColumn(['no_kuitansi', 'status_kuitansi']);
        });
    }
};
