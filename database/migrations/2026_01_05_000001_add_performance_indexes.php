<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add indexes for frequently queried columns to improve performance.
     */
    public function up(): void
    {
        // Add index to surat_perjanjians for status and sales
        Schema::table('surat_perjanjians', function (Blueprint $table) {
            $table->index('status_surat', 'idx_surat_status');
            $table->index('id_sales', 'idx_surat_sales');
            $table->index('created_at', 'idx_surat_created');
            $table->index(['id_sales', 'status_surat'], 'idx_surat_sales_status');
        });

        // Add index to invoices for status, sales, and dates
        Schema::table('invoices', function (Blueprint $table) {
            $table->index('status_pembayaran', 'idx_invoice_status');
            $table->index('id_sales', 'idx_invoice_sales');
            $table->index('created_at', 'idx_invoice_created');
            $table->index('jatuh_tempo', 'idx_invoice_due_date');
            $table->index(['id_sales', 'status_pembayaran'], 'idx_invoice_sales_status');
        });

        // Add index to kuitansis for status, dates, and amounts
        Schema::table('kuitansis', function (Blueprint $table) {
            $table->index('status_kuitansi', 'idx_kuitansi_status');
            $table->index('tanggal_kuitansi', 'idx_kuitansi_date');
            $table->index('id_invoice', 'idx_kuitansi_invoice');
            $table->index('id_sales', 'idx_kuitansi_sales');
            $table->index('created_at', 'idx_kuitansi_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_perjanjians', function (Blueprint $table) {
            $table->dropIndex('idx_surat_status');
            $table->dropIndex('idx_surat_sales');
            $table->dropIndex('idx_surat_created');
            $table->dropIndex('idx_surat_sales_status');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropIndex('idx_invoice_status');
            $table->dropIndex('idx_invoice_sales');
            $table->dropIndex('idx_invoice_created');
            $table->dropIndex('idx_invoice_due_date');
            $table->dropIndex('idx_invoice_sales_status');
        });

        Schema::table('kuitansis', function (Blueprint $table) {
            $table->dropIndex('idx_kuitansi_status');
            $table->dropIndex('idx_kuitansi_date');
            $table->dropIndex('idx_kuitansi_invoice');
            $table->dropIndex('idx_kuitansi_sales');
            $table->dropIndex('idx_kuitansi_created');
        });
    }
};
