<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Gelar Alat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 20px;
            line-height: 1.3;
        }

        .page {
            page-break-after: always;
            margin-bottom: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header h3 {
            margin: 0;
            font-size: 11px;
            font-weight: bold;
        }

        .header p {
            margin: 2px 0;
            font-size: 9px;
        }

        .info-section {
            margin: 10px 0;
            font-size: 9px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 9px;
        }

        table thead {
            background-color: #ffeb3b;
        }

        table th {
            border: 1px solid #000;
            padding: 4px 2px;
            text-align: center;
            font-weight: bold;
            font-size: 8px;
        }

        table td {
            border: 1px solid #000;
            padding: 3px 2px;
            text-align: center;
            font-size: 8px;
        }

        table td.left {
            text-align: left;
            padding-left: 5px;
        }

        .kategori {
            font-weight: bold;
            background-color: #f0f0f0;
        }

        .signature-section {
            margin-top: 30px;
            display: table;
            width: 100%;
        }

        .sig-info {
            margin-bottom: 20px;
            font-size: 9px;
        }

        .sig-left {
            float: left;
            width: 45%;
        }

        .sig-right {
            float: right;
            width: 45%;
            text-align: right;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .sig-boxes {
            display: table;
            width: 100%;
            margin-top: 20px;
        }

        .sig-box {
            display: table-cell;
            width: 23%;
            text-align: center;
            font-size: 8px;
            padding: 0 5px;
        }

        .sig-name {
            margin-top: 50px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .sig-line {
            border-top: 1px solid #000;
            width: 100%;
            margin: 2px 0 2px 0;
            height: 1px;
        }

        .sig-position {
            font-size: 7px;
            margin-top: 2px;
        }

        .page-break {
            page-break-after: always;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="page">
        <!-- HEADER -->
        <div class="header">
            <h3>PT PLN (PERSERO)</h3>
            <p>ULP Ahmad Yani Banjarmasin</p>
            <p><strong>LAPORAN KEGIATAN GELAR ALAT OPERASIONAL</strong></p>
        </div>

        <!-- INFO MOBIL -->
        <div class="info-section">
            <strong>Mobil:</strong> {{ $gelar->mobil->nama_tim ?? '-' }} 
            {{ $gelar->mobil->no_unit ?? '-' }} 
            {{ $gelar->mobil->nomor_plat ?? '-' }}
        </div>

        <!-- TABEL -->
        <table>
            <thead>
                <tr>
                    <th style="width: 3%;">No</th>
                    <th style="width: 35%;">Nama Alat</th>
                    <th style="width: 6%;">Satuan</th>
                    <th style="width: 4%;">Baik</th>
                    <th style="width: 4%;">Rusak</th>
                    <th style="width: 4%;">Hilang</th>
                    <th style="width: 44%;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grouped = $gelar->detailGelars->groupBy(fn($item) => $item->alat->kategori_alat ?? 'Lain-lain');
                    $rowNumber = 1;
                @endphp

                @forelse ($grouped as $kategori => $items)
                    <tr class="kategori">
                        <td colspan="7" style="text-align: left; background-color: #e8e8e8;">
                            {{ strtoupper($kategori) }}
                        </td>
                    </tr>
                    @foreach ($items as $detail)
                        <tr>
                            <td>{{ $rowNumber++ }}</td>
                            <td class="left">{{ $detail->alat->nama_alat ?? '-' }}</td>
                            <td>{{ $detail->alat->satuan ?? 'bh' }}</td>
                            <td>{{ $detail->status_alat == 'Baik' ? '✓' : '' }}</td>
                            <td>{{ $detail->status_alat == 'Rusak' ? '✓' : '' }}</td>
                            <td>{{ $detail->status_alat == 'Hilang' ? '✓' : '' }}</td>
                            <td class="left">{{ $detail->keterangan ?? '-' }}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">Tidak ada data alat</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- TANDA TANGAN -->
        <div class="signature-section clearfix">
            @php
                $tanggalCetak = $gelar->confirmed_at 
                    ? \Carbon\Carbon::parse($gelar->confirmed_at)->translatedFormat('d F Y')
                    : now()->translatedFormat('d F Y');
            @endphp

            <div class="sig-info">
                <div class="sig-left">
                    <strong>PT PLN (Persero) UP3 Banjarmasin</strong><br>
                    ULP AHMAD YANI
                </div>
                <div class="sig-right">
                    <strong>Banjarmasin, {{ $tanggalCetak }}</strong><br>
                    PT PLN Nusa Daya UL Banjarmasin<br>
                    ULP AHMAD YANI
                </div>
            </div>

            <div style="clear: both;"></div>

            <div class="sig-boxes">
                <div class="sig-box">
                    <div class="sig-name">NAUFAL NAJWAN</div>
                    <div class="sig-line"></div>
                    <div class="sig-position">Team Leader K3LK</div>
                </div>
                <div class="sig-box">
                    <div class="sig-name">FAHRUL</div>
                    <div class="sig-line"></div>
                    <div class="sig-position">Team Leader K3LK</div>
                </div>
                <div class="sig-box">
                    <div class="sig-name">NARI</div>
                    <div class="sig-line"></div>
                    <div class="sig-position">Supervisor</div>
                </div>
                <div class="sig-box">
                    <div class="sig-name">WIDIANTO</div>
                    <div class="sig-line"></div>
                    <div class="sig-position">Manager ULP</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 