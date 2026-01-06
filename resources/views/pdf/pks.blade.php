<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Perjanjian {{ $pks->no_surat }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            background: #fff;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px double #333;
        }
        .header h1 {
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 5px;
        }
        .header h2 {
            font-size: 16px;
            font-weight: normal;
        }
        .document-number {
            text-align: center;
            margin-bottom: 30px;
        }
        .document-number p {
            font-size: 11px;
            color: #666;
        }
        .document-number strong {
            font-size: 14px;
            color: #333;
        }
        .parties {
            margin-bottom: 30px;
        }
        .party {
            margin-bottom: 20px;
        }
        .party-title {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .party-details {
            padding-left: 20px;
        }
        .party-details p {
            margin-bottom: 5px;
        }
        .content {
            margin-bottom: 30px;
        }
        .content h3 {
            font-size: 13px;
            text-transform: uppercase;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 8px 0;
            vertical-align: top;
        }
        .info-table td:first-child {
            width: 180px;
            color: #666;
        }
        .info-table td:last-child {
            font-weight: bold;
        }
        .terms {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .terms h3 {
            margin-bottom: 15px;
            font-size: 13px;
        }
        .terms-content {
            white-space: pre-wrap;
            font-size: 11px;
            line-height: 1.8;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background: #333;
            color: white;
            padding: 12px;
            text-align: left;
            font-size: 11px;
        }
        .items-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
        }
        .items-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        .total-section {
            text-align: right;
            margin-bottom: 30px;
        }
        .total-section .label {
            font-size: 12px;
            color: #666;
        }
        .total-section .value {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .signature-section {
            display: table;
            width: 100%;
            margin-top: 60px;
        }
        .signature-box {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 20px;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 80px;
            padding-top: 10px;
        }
        .signature-name {
            font-weight: bold;
            margin-top: 5px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-aktif { background: #dbeafe; color: #1e40af; }
        .status-disetujui { background: #dcfce7; color: #166534; }
        .status-ditolak { background: #fee2e2; color: #991b1b; }
        .status-draft { background: #f3f4f6; color: #374151; }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #999;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Surat Perjanjian Kerjasama</h1>
            <h2>Perjanjian Kontrak Sewa (PKS)</h2>
        </div>

        <!-- Document Number -->
        <div class="document-number">
            <p>Nomor Surat</p>
            <strong>{{ $pks->no_surat }}</strong>
            <div style="margin-top: 10px;">
                <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $pks->status_surat)) }}">
                    {{ $pks->status_surat }}
                </span>
            </div>
        </div>

        <!-- Parties -->
        <div class="parties">
            <div class="party">
                <div class="party-title">PIHAK PERTAMA:</div>
                <div class="party-details">
                    <p><strong>{{ $pks->nama_pihak_pertama ?? 'PT BIMASADA' }}</strong></p>
                    <p>Yang selanjutnya disebut sebagai "Pihak Pertama"</p>
                </div>
            </div>
            <div class="party">
                <div class="party-title">PIHAK KEDUA:</div>
                <div class="party-details">
                    <p><strong>{{ $pks->nama_pihak_kedua ?? $pks->nama_pelanggan }}</strong></p>
                    <p>Alamat: {{ $pks->alamat_pelanggan ?? '-' }}</p>
                    <p>Telepon: {{ $pks->no_telp_pelanggan ?? '-' }}</p>
                    <p>Email: {{ $pks->email_pelanggan ?? '-' }}</p>
                    <p>Yang selanjutnya disebut sebagai "Pihak Kedua"</p>
                </div>
            </div>
        </div>

        <!-- Contract Details -->
        <div class="content">
            <h3>Detail Perjanjian</h3>
            <table class="info-table">
                <tr>
                    <td>Tanggal Perjanjian</td>
                    <td>{{ $pks->tanggal_surat->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td>Tanggal Selesai</td>
                    <td>{{ $pks->tanggal_selesai->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td>Nilai Kontrak</td>
                    <td>Rp {{ number_format($pks->nilai_kontrak, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Sales</td>
                    <td>{{ $pks->sales->nama_sales ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Items/Detail -->
        @if($pks->detailSurats && $pks->detailSurats->count() > 0)
        <div class="content">
            <h3>Detail Item/Layanan</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">No</th>
                        <th>Deskripsi</th>
                        <th style="width: 80px;">Qty</th>
                        <th style="width: 120px;">Harga</th>
                        <th style="width: 120px;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pks->detailSurats as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->deskripsi ?? $item->nama_item ?? '-' }}</td>
                        <td>{{ $item->jumlah ?? 1 }}</td>
                        <td>Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format(($item->jumlah ?? 1) * ($item->harga ?? 0), 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Total -->
        <div class="total-section">
            <div class="label">Total Nilai Kontrak</div>
            <div class="value">Rp {{ number_format($pks->nilai_kontrak, 0, ',', '.') }}</div>
        </div>

        <!-- Terms & Conditions -->
        @if($pks->syarat_ketentuan)
        <div class="terms">
            <h3>Syarat dan Ketentuan</h3>
            <div class="terms-content">{{ $pks->syarat_ketentuan }}</div>
        </div>
        @endif

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <p>Pihak Pertama,</p>
                <div class="signature-line">
                    <div class="signature-name">{{ $pks->nama_pihak_pertama ?? 'PT BIMASADA' }}</div>
                </div>
            </div>
            <div class="signature-box">
                <p>Pihak Kedua,</p>
                <div class="signature-line">
                    <div class="signature-name">{{ $pks->nama_pihak_kedua ?? $pks->nama_pelanggan }}</div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Dokumen ini dicetak pada {{ now()->format('d F Y, H:i') }}</p>
            <p>PT BIMASADA - Document Management System</p>
        </div>
    </div>
</body>
</html>
