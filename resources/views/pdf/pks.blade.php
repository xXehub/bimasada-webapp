<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Perjanjian {{ $pks->no_surat }}</title>
    <style>
        @page {
            size: A4;
            margin: 3cm 3cm 3cm 3cm;
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
            display: table;
            width: 100%;
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
            margin: 20px 0 15px 0;
        }
        .document-title h1 {
            font-size: 13pt;
            text-transform: uppercase;
            font-weight: bold;
            text-decoration: underline;
            letter-spacing: 2px;
        }
        .intro {
            margin-bottom: 12px;
            text-align: justify;
        }
        .party {
            margin-bottom: 12px;
        }
        .party-details {
            margin-left: 15px;
        }
        .party-details table {
            width: 100%;
        }
        .party-details td {
            padding: 1px 0;
            vertical-align: top;
            font-size: 10pt;
        }
        .party-details td:first-child {
            width: 120px;
        }
        .party-details td:nth-child(2) {
            width: 12px;
            text-align: center;
        }
        .party-role {
            margin-top: 3px;
            font-size: 10pt;
        }
        .agreement-text {
            text-align: justify;
            margin: 12px 0;
            font-size: 10pt;
        }
        .pasal {
            margin-bottom: 8px;
        }
        .pasal-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 3px;
            font-size: 10pt;
        }
        .pasal-content {
            text-align: justify;
            font-size: 10pt;
        }
        .closing {
            text-align: justify;
            margin: 12px 0;
            font-size: 10pt;
        }
        .signature-section {
            margin-top: 20px;
        }
        .signature-date {
            text-align: right;
            margin-bottom: 15px;
            font-size: 10pt;
        }
        .signature-table {
            width: 100%;
        }
        .signature-box {
            width: 42%;
            text-align: center;
            vertical-align: top;
            font-size: 10pt;
        }
        .signature-middle {
            width: 16%;
            text-align: center;
            vertical-align: top;
            font-size: 9pt;
        }
        .signature-space {
            height: 50px;
        }
        .signature-name {
            font-weight: bold;
            font-size: 10pt;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with Logo -->
        <div class="header">
            <div class="logo-cell">
                <img src="{{ public_path('assets/bimasadalogo.png') }}" alt="Bimasada Logo">
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
            <h1>Surat Perjanjian Kerjasama</h1>
        </div>

        <!-- Introduction -->
        <div class="intro">
            <p>Saya yang bertanda tangan di bawah ini :</p>
        </div>

        <!-- Pihak Pertama -->
        <div class="party">
            <div class="party-details">
                <table>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td><strong>{{ $pks->nama_pihak_pertama ?? 'PT. BIMASADA JAYA PERSADA' }}</strong></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{ $pks->alamat_pihak_pertama ?? $pks->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>No. Telepon</td>
                        <td>:</td>
                        <td>{{ $pks->telepon_pihak_pertama ?? $pks->no_telp ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="party-role">Yang mana selanjutnya akan disebut sebagai <strong>Pihak Pertama</strong>.</div>
        </div>

        <!-- Pihak Kedua -->
        <div class="party">
            <div class="party-details">
                <table>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td><strong>{{ $pks->nama_pihak_kedua ?? $pks->nama_pelanggan ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{ $pks->alamat_pihak_kedua ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>No. Telepon</td>
                        <td>:</td>
                        <td>{{ $pks->telepon_pihak_kedua ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="party-role">Selanjutnya akan disebut dengan <strong>Pihak Kedua</strong>.</div>
        </div>

        <!-- Agreement Text -->
        <div class="agreement-text">
            <p>Kedua belah telah sepakat untuk mengadakan kerjasama usaha dengan ketentuan-ketentuan yang diatur sebagai berikut ini :</p>
        </div>

        <!-- Pasal 1 -->
        <div class="pasal">
            <div class="pasal-title">PASAL 1</div>
            <div class="pasal-content">
                Dalam kerjasama ini Pihak Pertama akan menyediakan jasa/layanan kepada Pihak Kedua dengan nilai kontrak sebesar <strong>Rp {{ number_format($pks->nilai_kontrak ?? 0, 0, ',', '.') }}</strong> ({{ App\Helpers\Terbilang::convert($pks->nilai_kontrak ?? 0) }} rupiah) sesuai dengan kesepakatan yang telah disetujui kedua belah pihak.
            </div>
        </div>

        <!-- Pasal 2 -->
        <div class="pasal">
            <div class="pasal-title">PASAL 2</div>
            <div class="pasal-content">
                Jangka waktu perjanjian ini berlaku sejak tanggal <strong>{{ $pks->tanggal_mulai ? \Carbon\Carbon::parse($pks->tanggal_mulai)->translatedFormat('d F Y') : '-' }}</strong> sampai dengan tanggal <strong>{{ $pks->tanggal_selesai ? \Carbon\Carbon::parse($pks->tanggal_selesai)->translatedFormat('d F Y') : '-' }}</strong>.
            </div>
        </div>

        <!-- Pasal 3 -->
        <div class="pasal">
            <div class="pasal-title">PASAL 3</div>
            <div class="pasal-content">
                Kedua belah pihak akan saling bekerjasama untuk melaksanakan hak dan kewajiban sesuai dengan ketentuan yang telah disepakati dalam perjanjian ini.
            </div>
        </div>

        <!-- Pasal 4 -->
        <div class="pasal">
            <div class="pasal-title">PASAL 4</div>
            <div class="pasal-content">
                Bila terjadi kerugian maka akan menjadi tanggung jawab dari kedua belah pihak.
            </div>
        </div>

        <!-- Pasal 5 -->
        <div class="pasal">
            <div class="pasal-title">PASAL 5</div>
            <div class="pasal-content">
                Apabila terjadi perselisihan antar kedua belah pihak akan diselesaikan secara kekeluargaan terlebih dahulu. Dan apabila tidak ditemui jalan keluar baru akan diselesaikan secara hukum.
            </div>
        </div>

        <!-- Closing -->
        <div class="closing">
            <p>Demikian surat perjanjian ini kami buat sebenar-benarnya dalam rangkap dua yang mana masing-masing rangkap mempunyai kekuatan hukum yang sama. Dan dalam pembuatan perjanjian kerjasama ini tidak ada paksaan dari pihak manapun.</p>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-date">
                {{ $pks->tempat_ttd ?? 'Jakarta' }}, {{ $pks->tanggal_surat ? \Carbon\Carbon::parse($pks->tanggal_surat)->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}
            </div>
            
            <table class="signature-table">
                <tr>
                    <td class="signature-box">Pihak Pertama,</td>
                    <td class="signature-middle">(Materai 10000)</td>
                    <td class="signature-box">Pihak Kedua,</td>
                </tr>
                <tr>
                    <td class="signature-box"><div class="signature-space"></div></td>
                    <td class="signature-middle"></td>
                    <td class="signature-box"><div class="signature-space"></div></td>
                </tr>
                <tr>
                    <td class="signature-box"><span class="signature-name">{{ $pks->nama_pihak_pertama ?? 'PT. BIMASADA JAYA PERSADA' }}</span></td>
                    <td class="signature-middle"></td>
                    <td class="signature-box"><span class="signature-name">{{ $pks->nama_pihak_kedua ?? $pks->nama_pelanggan ?? '-' }}</span></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
