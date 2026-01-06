<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi {{ $kuitansi->no_kuitansi }}</title>
    @php
        $logoPath = public_path('assets/bimasadalogo.png');
        $logoData = '';
        if (file_exists($logoPath)) {
            $logoData = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }
    @endphp
    <style>
        @page {
            size: A4;
            margin: 25mm 25mm 25mm 25mm;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt;
            line-height: 1.3;
            color: #000;
            background: #fff;
        }
        .container {
            max-width: 100%;
            padding: 0 5mm;
        }
        .header {
            display: table;
            width: 100%;
            margin-top: 5mm;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 3px double #000;
        }
        .logo-cell {
            display: table-cell;
            width: 110px;
            vertical-align: middle;
        }
        .logo-cell img {
            width: 100px;
            height: auto;
        }
        .company-cell {
            display: table-cell;
            vertical-align: middle;
            padding-left: 15px;
        }
        .company-name {
            font-size: 16pt;
            font-weight: bold;
            color: #1e3a8a;
            letter-spacing: 1px;
        }
        .company-address {
            font-size: 9pt;
            color: #333;
            margin-top: 2px;
        }
        .document-title {
            text-align: center;
            margin: 15px 0 12px 0;
        }
        .document-title h1 {
            font-size: 14pt;
            text-transform: uppercase;
            font-weight: bold;
            text-decoration: underline;
            letter-spacing: 2px;
        }
        .document-number {
            font-size: 10pt;
            margin-top: 3px;
        }
        .receipt-content {
            margin: 15px 0;
        }
        .info-row table {
            width: 100%;
        }
        .info-row td {
            padding: 4px 0;
            vertical-align: top;
            font-size: 10pt;
        }
        .info-row td:first-child {
            width: 150px;
        }
        .info-row td:nth-child(2) {
            width: 12px;
            text-align: center;
        }
        .amount-box {
            background: #f5f5f5;
            border: 2px solid #000;
            padding: 12px;
            margin: 15px 0;
            text-align: center;
        }
        .amount-label {
            font-size: 9pt;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .amount-value {
            font-size: 16pt;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .amount-words {
            font-size: 10pt;
            font-style: italic;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px dashed #000;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0;
        }
        .details-table th {
            background: #e5e7eb;
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            font-weight: bold;
            font-size: 9pt;
        }
        .details-table td {
            border: 1px solid #000;
            padding: 5px 6px;
            font-size: 9pt;
        }
        .details-table .text-center {
            text-align: center;
        }
        .details-table .text-right {
            text-align: right;
        }
        .payment-info {
            margin: 12px 0;
            padding: 10px;
            border: 1px solid #000;
        }
        .payment-info table {
            width: 100%;
        }
        .payment-info td {
            padding: 3px;
            font-size: 10pt;
        }
        .payment-info td:first-child {
            width: 140px;
        }
        .notes {
            margin: 10px 0;
            padding: 8px;
            background: #fffacd;
            border: 1px solid #000;
            font-size: 9pt;
        }
        .notes-title {
            font-weight: bold;
            margin-bottom: 3px;
        }
        .signature-section {
            margin-top: 25px;
        }
        .signature-table {
            width: 100%;
        }
        .signature-box {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 8px;
            font-size: 10pt;
        }
        .signature-space {
            height: 50px;
        }
        .signature-name {
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 4px;
            display: inline-block;
            min-width: 130px;
            font-size: 9pt;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border: 1px solid #000;
            font-size: 8pt;
            font-weight: bold;
        }
        .invoice-ref {
            background: #f0f8ff;
            border: 1px solid #000;
            padding: 8px;
            margin: 10px 0;
            font-size: 9pt;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with Logo -->
        <div class="header">
            <div class="logo-cell">
                @if($logoData)
                    <img src="{{ $logoData }}" alt="Bimasada Logo">
                @else
                    <span style="font-weight:bold;color:#1e3a8a;">BIMASADA</span>
                @endif
            </div>
            <div class="company-cell">
                <div class="company-name">PT. BIMASADA JAYA PERSADA</div>
                <div class="company-address">
                    Pergudangan Mutiara Citra Sejati Blok D10, Jl. Raya Manukan Kulon 60, Tandes, Surabaya - Jawa Timur<br>
                    Telp: (031) 7421 500 | WA: 081 1310 0081 | Email: heli@bimasada.com
                </div>
            </div>
        </div>

        <!-- Document Title -->
        <div class="document-title">
            <h1>Kuitansi</h1>
            <div class="document-number">No: {{ $kuitansi->no_kuitansi }}</div>
        </div>

        <!-- Receipt Content -->
        <div class="receipt-content">
            <div class="info-row">
                <table>
                    <tr>
                        <td>Sudah Terima Dari</td>
                        <td>:</td>
                        <td><strong>{{ $kuitansi->nama_pelanggan ?? $kuitansi->invoice->nama_pelanggan ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{ $kuitansi->alamat ?? $kuitansi->invoice->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Untuk Pembayaran</td>
                        <td>:</td>
                        <td>{{ $kuitansi->keterangan ?? 'Pembayaran Invoice ' . ($kuitansi->invoice->no_invoice ?? '-') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Amount Box -->
        <div class="amount-box">
            <div class="amount-label">Jumlah Uang</div>
            <div class="amount-value">Rp {{ number_format($kuitansi->total_bayar ?? 0, 0, ',', '.') }}</div>
            <div class="amount-words">
                <strong>Terbilang:</strong> {{ ucwords(App\Helpers\Terbilang::convert($kuitansi->total_bayar ?? 0)) }} Rupiah
            </div>
        </div>

        <!-- Details Table -->
        @if($kuitansi->detailKuitansis && $kuitansi->detailKuitansis->count() > 0)
        <table class="details-table">
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th>Keterangan</th>
                    <th style="width: 110px;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kuitansi->detailKuitansis as $index => $detail)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $detail->keterangan ?? 'Pembayaran' }}</td>
                    <td class="text-right">Rp {{ number_format($detail->jumlah ?? 0, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- Payment Info -->
        <div class="payment-info">
            <table>
                <tr>
                    <td>Tanggal Pembayaran</td>
                    <td>:</td>
                    <td><strong>{{ $kuitansi->tanggal_kuitansi ? \Carbon\Carbon::parse($kuitansi->tanggal_kuitansi)->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}</strong></td>
                </tr>
                <tr>
                    <td>Metode Pembayaran</td>
                    <td>:</td>
                    <td><strong>{{ $kuitansi->invoice_pembayaran ?? 'Tunai' }}</strong></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>:</td>
                    <td><span class="status-badge">{{ $kuitansi->status_kuitansi ?? 'Lunas' }}</span></td>
                </tr>
            </table>
        </div>

        <!-- Invoice Reference -->
        @if($kuitansi->invoice)
        <div class="invoice-ref">
            <strong>Referensi Invoice:</strong> {{ $kuitansi->invoice->no_invoice ?? 'INV-' . str_pad($kuitansi->invoice->id, 4, '0', STR_PAD_LEFT) }}
            &nbsp;|&nbsp;
            <small>Tanggal Invoice: {{ $kuitansi->invoice->tanggal_invoice->translatedFormat('d F Y') }}</small>
        </div>
        @endif

        <!-- Notes -->
        @if($kuitansi->catatan ?? false)
        <div class="notes">
            <div class="notes-title">Catatan:</div>
            <p>{{ $kuitansi->catatan }}</p>
        </div>
        @endif

        <!-- Signature Section -->
        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <td class="signature-box">
                        Penyetor,
                        <div class="signature-space"></div>
                        <div class="signature-name">{{ $kuitansi->nama_pelanggan ?? $kuitansi->invoice->nama_pelanggan ?? '...................' }}</div>
                    </td>
                    <td class="signature-box">
                        Surabaya, {{ $kuitansi->tanggal_kuitansi ? \Carbon\Carbon::parse($kuitansi->tanggal_kuitansi)->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}<br>
                        Penerima,
                        <div class="signature-space"></div>
                        <div class="signature-name">PT. BIMASADA JAYA PERSADA</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
