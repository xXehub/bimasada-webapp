<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->no_invoice ?? 'INV-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</title>
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
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #3b82f6;
        }
        .company-info h1 {
            font-size: 24px;
            color: #3b82f6;
            margin-bottom: 5px;
        }
        .company-info p {
            font-size: 11px;
            color: #666;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-title h2 {
            font-size: 28px;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .invoice-title .invoice-number {
            font-size: 14px;
            color: #3b82f6;
            font-weight: bold;
            margin-top: 5px;
        }
        .invoice-info {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .info-left, .info-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .info-right {
            text-align: right;
        }
        .info-block {
            margin-bottom: 15px;
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
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.items th {
            background: #3b82f6;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
        }
        table.items th:last-child,
        table.items td:last-child {
            text-align: right;
        }
        table.items td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        table.items tr:nth-child(even) {
            background: #f8fafc;
        }
        .totals {
            width: 300px;
            margin-left: auto;
        }
        .totals table {
            width: 100%;
        }
        .totals td {
            padding: 8px 0;
        }
        .totals td:last-child {
            text-align: right;
            font-weight: bold;
        }
        .totals .grand-total {
            font-size: 16px;
            color: #3b82f6;
            border-top: 2px solid #3b82f6;
            padding-top: 10px;
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
        .status-belum { background: #fef9c3; color: #854d0e; }
        .status-cicilan { background: #dbeafe; color: #1e40af; }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #999;
            font-size: 10px;
        }
        .notes {
            background: #f8fafc;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .notes h4 {
            font-size: 11px;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 10px;
        }
        .signature-section {
            margin-top: 50px;
            display: table;
            width: 100%;
        }
        .signature-box {
            display: table-cell;
            width: 33%;
            text-align: center;
            padding: 20px;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 10px;
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
            <div class="invoice-title">
                <h2>Invoice</h2>
                <div class="invoice-number">{{ $invoice->no_invoice ?? 'INV-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</div>
                <div style="margin-top: 10px;">
                    <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $invoice->status_pembayaran)) == 'belum-lunas' ? 'belum' : strtolower($invoice->status_pembayaran) }}">
                        {{ $invoice->status_pembayaran }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Invoice Info -->
        <div class="invoice-info">
            <div class="info-left">
                <div class="info-block">
                    <label>Tagihan Kepada</label>
                    <span style="font-size: 14px; font-weight: bold;">{{ $invoice->nama_pelanggan }}</span>
                </div>
                <div class="info-block">
                    <label>Alamat</label>
                    <span>{{ $invoice->alamat ?? '-' }}</span>
                </div>
                <div class="info-block">
                    <label>Telepon / Email</label>
                    <span>{{ $invoice->no_telp ?? '-' }} / {{ $invoice->email ?? '-' }}</span>
                </div>
            </div>
            <div class="info-right">
                <div class="info-block">
                    <label>Tanggal Invoice</label>
                    <span>{{ $invoice->tanggal_invoice->format('d F Y') }}</span>
                </div>
                <div class="info-block">
                    <label>Jatuh Tempo</label>
                    <span>{{ $invoice->jatuh_tempo->format('d F Y') }}</span>
                </div>
                <div class="info-block">
                    <label>Sales</label>
                    <span>{{ $invoice->sales->nama_sales ?? '-' }}</span>
                </div>
                @if($invoice->pks)
                <div class="info-block">
                    <label>No. Kontrak (PKS)</label>
                    <span>{{ $invoice->pks->no_surat }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <table class="items">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Deskripsi</th>
                    <th style="width: 80px;">Qty</th>
                    <th style="width: 120px;">Harga Satuan</th>
                    <th style="width: 120px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoice->detailInvoices as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->id_kuitansi ?? $item->deskripsi ?? 'Item ' . ($index + 1) }}</td>
                    <td>{{ number_format($item->jumlah, 0) }}</td>
                    <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td>1</td>
                    <td>{{ $invoice->keterangan ?? 'Layanan/Produk' }}</td>
                    <td>1</td>
                    <td>Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td>Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}</td>
                </tr>
                @if($invoice->kuitansis->count() > 0)
                <tr>
                    <td>Telah Dibayar</td>
                    <td>Rp {{ number_format($invoice->total_paid, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr class="grand-total">
                    <td>TOTAL</td>
                    <td>Rp {{ number_format($invoice->remaining_amount ?? $invoice->total_harga, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <!-- Notes -->
        @if($invoice->keterangan)
        <div class="notes">
            <h4>Catatan</h4>
            <p>{{ $invoice->keterangan }}</p>
        </div>
        @endif

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line">
                    <p>Penerima</p>
                </div>
            </div>
            <div class="signature-box">
                <div class="signature-line">
                    <p>Sales</p>
                    <p style="font-weight: bold;">{{ $invoice->sales->nama_sales ?? '-' }}</p>
                </div>
            </div>
            <div class="signature-box">
                <div class="signature-line">
                    <p>Disetujui</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Dokumen ini dicetak pada {{ now()->format('d F Y, H:i') }}</p>
            <p>PT BIMASADA - Invoice Management System</p>
        </div>
    </div>
</body>
</html>
