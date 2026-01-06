<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Kuitansi;
use App\Models\SuratPerjanjian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    /**
     * Generate PDF for Invoice
     */
    public function invoice(Invoice $invoice)
    {
        $invoice->load(['sales', 'detailInvoices', 'pks', 'kuitansis']);
        
        $pdf = Pdf::loadView('pdf.invoice', compact('invoice'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
            ]);
        
        $filename = 'Invoice_' . ($invoice->no_invoice ?? 'INV-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT)) . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Stream PDF for Invoice (view in browser)
     */
    public function invoiceStream(Invoice $invoice)
    {
        $invoice->load(['sales', 'detailInvoices', 'pks', 'kuitansis']);
        
        $pdf = Pdf::loadView('pdf.invoice', compact('invoice'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
            ]);
        
        return $pdf->stream('Invoice.pdf');
    }

    /**
     * Generate PDF for Surat Perjanjian (PKS)
     */
    public function pks(SuratPerjanjian $suratPerjanjian)
    {
        $pks = $suratPerjanjian;
        $pks->load(['sales', 'detailSurats']);
        
        $pdf = Pdf::loadView('pdf.pks', compact('pks'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
            ]);
        
        $filename = 'PKS_' . $pks->no_surat . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Stream PDF for PKS (view in browser)
     */
    public function pksStream(SuratPerjanjian $suratPerjanjian)
    {
        $pks = $suratPerjanjian;
        $pks->load(['sales', 'detailSurats']);
        
        $pdf = Pdf::loadView('pdf.pks', compact('pks'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
            ]);
        
        return $pdf->stream('PKS.pdf');
    }

    /**
     * Generate PDF for Kuitansi
     */
    public function kuitansi(Kuitansi $kuitansi)
    {
        $kuitansi->load(['sales', 'invoice', 'detailKuitansis']);
        
        $pdf = Pdf::loadView('pdf.kuitansi', compact('kuitansi'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
            ]);
        
        $filename = 'Kuitansi_' . $kuitansi->no_kuitansi . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Stream PDF for Kuitansi (view in browser)
     */
    public function kuitansiStream(Kuitansi $kuitansi)
    {
        $kuitansi->load(['sales', 'invoice', 'detailKuitansis']);
        
        $pdf = Pdf::loadView('pdf.kuitansi', compact('kuitansi'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
            ]);
        
        return $pdf->stream('Kuitansi.pdf');
    }
}
