<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi {{ $kuitansi->no_kuitansi }}</title>
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
        .receipt-content {
            margin: 20px 0;
        }
        .info-row {
            margin-bottom: 10px;
        }
        .info-row table {
            width: 100%;
        }
        .info-row td {
            padding: 5px 0;
            vertical-align: top;
        }
        .info-row td:first-child {
            width: 180px;
        }
        .info-row td:nth-child(2) {
            width: 15px;
            text-align: center;
        }
        .amount-box {
            background: #f5f5f5;
            border: 2px solid #000;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        .amount-label {
            font-size: 10pt;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .amount-value {
            font-size: 18pt;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .amount-words {
            font-size: 11pt;
            font-style: italic;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #000;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .details-table th {
            background: #f0f0f0;
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            font-weight: bold;
            font-size: 10pt;
        }
        .details-table td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 10pt;
        }
        .details-table .text-center {
            text-align: center;
        }
        .details-table .text-right {
            text-align: right;
        }
        .payment-info {
            margin: 15px 0;
            padding: 10px;
            border: 1px solid #000;
        }
        .payment-info table {
            width: 100%;
        }
        .payment-info td {
            padding: 5px;
        }
        .payment-info td:first-child {
            width: 150px;
        }
        .notes {
            margin: 15px 0;
            padding: 10px;
            background: #fffacd;
            border: 1px solid #000;
        }
        .notes-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .signature-section {
            margin-top: 30px;
        }
        .signature-table {
            width: 100%;
        }
        .signature-box {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 10px;
        }
        .signature-space {
            height: 60px;
        }
        .signature-name {
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 5px;
            display: inline-block;
            min-width: 150px;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border: 1px solid #000;
            font-size: 9pt;
            font-weight: bold;
        }
        .invoice-ref {
            background: #f0f8ff;
            border: 1px solid #000;
            padding: 10px;
            margin: 15px 0;
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
                        <td><strong>{{ $kuitansi->nama_penyetor ?? $kuitansi->invoice->nama_pelanggan ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{ $kuitansi->alamat_penyetor ?? $kuitansi->invoice->alamat ?? '-' }}</td>
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
            <div class="amount-value">Rp {{ number_format($kuitansi->jumlah_bayar ?? 0, 0, ',', '.') }}</div>
            <div class="amount-words">
                <strong>Terbilang:</strong> {{ ucwords(App\Helpers\Terbilang::convert($kuitansi->jumlah_bayar ?? 0)) }} Rupiah
            </div>
        </div>

        <!-- Details Table -->
        @if($kuitansi->detailKuitansis && $kuitansi->detailKuitansis->count() > 0)
        <table class="details-table">
            <thead>
                <tr>
                    <th style="width: 40px;">No</th>
                    <th>Keterangan</th>
                    <th style="width: 120px;">Jumlah</th>
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
                    <td><strong>{{ $kuitansi->tanggal_bayar ? \Carbon\Carbon::parse($kuitansi->tanggal_bayar)->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}</strong></td>
                </tr>
                <tr>
                    <td>Metode Pembayaran</td>
                    <td>:</td>
                    <td><strong>{{ $kuitansi->metode_pembayaran ?? 'Tunai' }}</strong></td>
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
            <br>
            <small>Tanggal Invoice: {{ $kuitansi->invoice->tanggal_invoice->translatedFormat('d F Y') }}</small>
        </div>
        @endif

        <!-- Notes -->
        @if($kuitansi->catatan)
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
                        <div class="signature-name">{{ $kuitansi->nama_penyetor ?? $kuitansi->invoice->nama_pelanggan ?? '...................' }}</div>
                    </td>
                    <td class="signature-box">
                        Jakarta, {{ $kuitansi->tanggal_bayar ? \Carbon\Carbon::parse($kuitansi->tanggal_bayar)->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}<br>
                        Penerima,
                        <div class="signature-space"></div>
                        <div class="signature-name">{{ $kuitansi->nama_penerima ?? 'PT. BIMASADA GELORA MEDIA' }}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
