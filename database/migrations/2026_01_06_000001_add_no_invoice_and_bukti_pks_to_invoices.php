<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Add invoice number column
            if (!Schema::hasColumn('invoices', 'no_invoice')) {
                $table->string('no_invoice', 50)->nullable()->unique()->after('id');
            }
            
            // Add bukti_pks for document upload (PDF/image of PKS proof)
            if (!Schema::hasColumn('invoices', 'bukti_pks')) {
                $table->string('bukti_pks')->nullable()->after('id_pks');
            }
            
            // Add no_kontrak if not exists (for manual contract number entry)
            if (!Schema::hasColumn('invoices', 'no_kontrak')) {
                $table->string('no_kontrak', 100)->nullable()->after('no_invoice');
            }
        });
        
        // Generate no_invoice for existing invoices
        $invoices = DB::table('invoices')->whereNull('no_invoice')->get();
        foreach ($invoices as $invoice) {
            $date = date('Ym', strtotime($invoice->tanggal_invoice ?? $invoice->created_at));
            $no = 'INV-' . $date . '-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT);
            DB::table('invoices')->where('id', $invoice->id)->update(['no_invoice' => $no]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['no_invoice', 'bukti_pks', 'no_kontrak']);
        });
    }
};
