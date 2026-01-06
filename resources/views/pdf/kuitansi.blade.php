<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi {{ $kuitansi->no_kuitansi }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            background: #fff;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
        }
        .header {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #10b981;
        }
        .company-info {
            display: table-cell;
            width: 60%;
            vertical-align: middle;
        }
        .company-info h1 {
            font-size: 22px;
            color: #10b981;
            margin-bottom: 5px;
        }
        .company-info p {
            font-size: 10px;
            color: #666;
        }
        .receipt-title {
            display: table-cell;
            width: 40%;
            text-align: right;
            vertical-align: middle;
        }
        .receipt-title h2 {
            font-size: 28px;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .receipt-title .receipt-number {
            font-size: 14px;
            color: #10b981;
            font-weight: bold;
            margin-top: 5px;
        }
        .receipt-info {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
        }
        .info-left, .info-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .info-block {
            margin-bottom: 12px;
        }
        .info-block label {
            font-size: 10px;
            text-transform: uppercase;
            color: #999;
            display: block;
            margin-bottom: 3px;
        }
        .info-block span {
            font-size: 12px;
            color: #333;
            font-weight: bold;
        }
        .amount-section {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .amount-section label {
            font-size: 12px;
            text-transform: uppercase;
            opacity: 0.9;
            display: block;
            margin-bottom: 10px;
        }
        .amount-section .amount {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .amount-section .amount-words {
            font-size: 11px;
            font-style: italic;
            opacity: 0.9;
            margin-top: 10px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .details-table th {
            background: #10b981;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
        }
        .details-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        .payment-method {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            background: #dbeafe;
            color: #1e40af;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-lunas { background: #dcfce7; color: #166534; }
        .status-draft { background: #f3f4f6; color: #374151; }
        .notes {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin-bottom: 30px;
        }
        .notes h4 {
            font-size: 11px;
            text-transform: uppercase;
            color: #b45309;
            margin-bottom: 8px;
        }
        .signature-section {
            display: table;
            width: 100%;
            margin-top: 50px;
        }
        .signature-box {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 20px;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 70px;
            padding-top: 10px;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #999;
            font-size: 10px;
        }
        .invoice-ref {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .invoice-ref h4 {
            font-size: 11px;
            color: #0369a1;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <h1>PT BIMASADA</h1>
                <p>Jl. Contoh Alamat No. 123</p>
                <p>Jakarta, Indonesia 12345</p>
                <p>Telp: (021) 123-4567 | Email: info@bimasada.com</p>
            </div>
            <div class="receipt-title">
                <h2>Kuitansi</h2>
                <div class="receipt-number">{{ $kuitansi->no_kuitansi }}</div>
                <div style="margin-top: 10px;">
                    <span class="status-badge status-{{ strtolower($kuitansi->status_kuitansi) }}">
                        {{ $kuitansi->status_kuitansi }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Receipt Info -->
        <div class="receipt-info">
            <div class="info-left">
                <div class="info-block">
                    <label>Diterima Dari</label>
                    <span>{{ $kuitansi->nama_pelanggan }}</span>
                </div>
                <div class="info-block">
                    <label>Alamat</label>
                    <span>{{ $kuitansi->alamat ?? '-' }}</span>
                </div>
                <div class="info-block">
                    <label>Telepon</label>
                    <span>{{ $kuitansi->no_telp ?? '-' }}</span>
                </div>
            </div>
            <div class="info-right">
                <div class="info-block">
                    <label>Tanggal</label>
                    <span>{{ $kuitansi->tanggal_kuitansi->format('d F Y') }}</span>
                </div>
                <div class="info-block">
                    <label>Metode Pembayaran</label>
                    <span class="payment-method">{{ $kuitansi->invoice_pembayaran }}</span>
                </div>
                <div class="info-block">
                    <label>Sales</label>
                    <span>{{ $kuitansi->sales->nama_sales ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Invoice Reference -->
        @if($kuitansi->invoice)
        <div class="invoice-ref">
            <h4>Referensi Invoice</h4>
            <p>
                <strong>{{ $kuitansi->invoice->no_invoice ?? 'INV-' . str_pad($kuitansi->invoice->id, 4, '0', STR_PAD_LEFT) }}</strong>
                - {{ $kuitansi->invoice->nama_pelanggan }}
            </p>
        </div>
        @endif

        <!-- Amount Section -->
        <div class="amount-section">
            <label>Jumlah Pembayaran</label>
            <div class="amount">Rp {{ number_format($kuitansi->total_bayar, 0, ',', '.') }}</div>
            <div class="amount-words">
                {{ ucwords(\App\Helpers\Terbilang::convert($kuitansi->total_bayar)) }} Rupiah
            </div>
        </div>

        <!-- Payment Details -->
        @if($kuitansi->detailKuitansis && $kuitansi->detailKuitansis->count() > 0)
        <table class="details-table">
            <thead>
                <tr>
                    <th style="width: 40px;">No</th>
                    <th>Keterangan</th>
                    <th style="width: 120px; text-align: right;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kuitansi->detailKuitansis as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td style="text-align: right;">Rp {{ number_format($item->jumlah ?? 0, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- Notes -->
        @if($kuitansi->keterangan)
        <div class="notes">
            <h4>Keterangan</h4>
            <p>{{ $kuitansi->keterangan }}</p>
        </div>
        @endif

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <p>Penerima,</p>
                <div class="signature-line">
                    <p>{{ $kuitansi->nama_pelanggan }}</p>
                </div>
            </div>
            <div class="signature-box">
                <p>Kasir/Petugas,</p>
                <div class="signature-line">
                    <p>{{ $kuitansi->sales->nama_sales ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Kuitansi ini sebagai bukti pembayaran yang sah</p>
            <p>Dokumen ini dicetak pada {{ now()->format('d F Y, H:i') }}</p>
            <p>PT BIMASADA - Receipt Management System</p>
        </div>
    </div>
</body>
</html>
