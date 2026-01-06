<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->no_invoice ?? 'INV-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</title>
    <style>
        @page {
            size: A4;
            margin: 1.5cm;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
            background: #fff;
        }
        .container {
            max-width: 100%;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 3px double #000;
        }
        .company-name {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .company-address {
            font-size: 10pt;
            margin-top: 3px;
        }
        .document-title {
            text-align: center;
            margin: 15px 0;
        }
        .document-title h1 {
            font-size: 14pt;
            text-transform: uppercase;
            font-weight: bold;
            text-decoration: underline;
            letter-spacing: 2px;
        }
        .document-number {
            font-size: 11pt;
            margin-top: 5px;
        }
        .info-section {
            margin-bottom: 15px;
        }
        .info-table {
            width: 100%;
        }
        .info-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .info-left {
            width: 50%;
        }
        .info-right {
            width: 50%;
            text-align: right;
        }
        .info-label {
            display: inline-block;
            width: 100px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .items-table th {
            background: #f0f0f0;
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            font-weight: bold;
            font-size: 10pt;
        }
        .items-table td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 10pt;
        }
        .items-table .text-center {
            text-align: center;
        }
        .items-table .text-right {
            text-align: right;
        }
        .total-section {
            margin: 15px 0;
        }
        .total-table {
            width: 300px;
            margin-left: auto;
        }
        .total-table td {
            padding: 5px;
        }
        .total-table td:last-child {
            text-align: right;
            font-weight: bold;
        }
        .total-table .grand-total {
            border-top: 2px solid #000;
            font-size: 12pt;
        }
        .terbilang {
            background: #f5f5f5;
            border: 1px solid #000;
            padding: 10px;
            margin: 15px 0;
            font-style: italic;
        }
        .notes {
            margin: 15px 0;
        }
        .notes-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .signature-section {
            margin-top: 25px;
        }
        .signature-table {
            width: 100%;
        }
        .signature-box {
            width: 33%;
            text-align: center;
            vertical-align: top;
            padding: 10px;
        }
        .signature-space {
            height: 50px;
        }
        .signature-name {
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 5px;
            display: inline-block;
            min-width: 120px;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border: 1px solid #000;
            font-size: 9pt;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-name">PT. BIMASADA GELORA MEDIA</div>
            <div class="company-address">
                Jl. Contoh Alamat No. 123, Jakarta, Indonesia<br>
                Telp: (021) 123-4567 | Email: info@bimasada.com
            </div>
        </div>

        <!-- Document Title -->
        <div class="document-title">
            <h1>Invoice</h1>
            <div class="document-number">No: {{ $invoice->no_invoice ?? 'INV-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</div>
        </div>

        <!-- Info Section -->
        <div class="info-section">
            <table class="info-table">
                <tr>
                    <td class="info-left">
                        <strong>Kepada Yth:</strong><br>
                        <strong>{{ $invoice->nama_pelanggan }}</strong><br>
                        {{ $invoice->alamat ?? '-' }}<br>
                        Telp: {{ $invoice->no_telp ?? '-' }}<br>
                        Email: {{ $invoice->email ?? '-' }}
                    </td>
                    <td class="info-right">
                        <table style="margin-left: auto;">
                            <tr>
                                <td>Tanggal</td>
                                <td>:</td>
                                <td><strong>{{ $invoice->tanggal_invoice->translatedFormat('d F Y') }}</strong></td>
                            </tr>
                            <tr>
                                <td>Jatuh Tempo</td>
                                <td>:</td>
                                <td><strong>{{ $invoice->jatuh_tempo->translatedFormat('d F Y') }}</strong></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td><span class="status-badge">{{ $invoice->status_pembayaran }}</span></td>
                            </tr>
                            @if($invoice->pks)
                            <tr>
                                <td>No. PKS</td>
                                <td>:</td>
                                <td>{{ $invoice->pks->no_surat ?? '-' }}</td>
                            </tr>
                            @endif
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 40px;">No</th>
                    <th>Uraian</th>
                    <th style="width: 60px;">Qty</th>
                    <th style="width: 120px;">Harga Satuan</th>
                    <th style="width: 120px;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoice->detailInvoices as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->id_kuitansi ?? 'Item #' . ($index + 1) }}</td>
                    <td class="text-center">{{ number_format($item->jumlah, 0) }}</td>
                    <td class="text-right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td class="text-center">1</td>
                    <td>Jasa/Layanan sesuai kontrak</td>
                    <td class="text-center">1</td>
                    <td class="text-right">Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Total Section -->
        <div class="total-section">
            <table class="total-table">
                @php
                    $subtotal = $invoice->detailInvoices->sum('subtotal') ?: $invoice->total_harga;
                    $ppn = $subtotal * 0.11;
                    $grandTotal = $subtotal + $ppn;
                @endphp
                <tr>
                    <td>Subtotal</td>
                    <td>:</td>
                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>PPN (11%)</td>
                    <td>:</td>
                    <td>Rp {{ number_format($ppn, 0, ',', '.') }}</td>
                </tr>
                <tr class="grand-total">
                    <td><strong>Total</strong></td>
                    <td>:</td>
                    <td><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
                </tr>
            </table>
        </div>

        <!-- Terbilang -->
        <div class="terbilang">
            <strong>Terbilang:</strong> {{ ucwords(App\Helpers\Terbilang::convert($grandTotal)) }} Rupiah
        </div>

        <!-- Notes -->
        @if($invoice->keterangan)
        <div class="notes">
            <div class="notes-title">Keterangan:</div>
            <p>{{ $invoice->keterangan }}</p>
        </div>
        @endif

        <!-- Signature Section -->
        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <td class="signature-box">
                        Pelanggan,
                        <div class="signature-space"></div>
                        <div class="signature-name">{{ $invoice->nama_pelanggan }}</div>
                    </td>
                    <td class="signature-box">
                        Mengetahui,
                        <div class="signature-space"></div>
                        <div class="signature-name">Manager</div>
                    </td>
                    <td class="signature-box">
                        Hormat Kami,
                        <div class="signature-space"></div>
                        <div class="signature-name">{{ $invoice->sales->nama_sales ?? 'Sales' }}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
