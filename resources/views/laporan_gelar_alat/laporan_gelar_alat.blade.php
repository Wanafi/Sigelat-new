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
            padding: 15px;
            line-height: 1.3;
        }

        .page {
            page-break-after: always;
            margin-bottom: 20px;
        }

        .manual-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #00AFF0;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        .header-logo {
            width: 15%;
        }

        .header-logo img {
            height: 50px;
            width: auto;
        }

        .header-text {
            width: 95%;
            text-align: right;
            padding-left: 10px;
        }

        .header-text h3 {
            margin: 0;
            font-size: 11px;
            font-weight: bold;
        }

        .header-text p {
            margin: 2px 0;
            font-size: 9px;
        }

        .info-section {
            margin: 10px 0;
            font-size: 9px;
            padding: 5px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 8px;
        }

        table thead {
            background-color: #ffeb3b;
        }

        table th {
            border: 1px solid #000;
            padding: 4px 2px;
            text-align: center;
            font-weight: bold;
            font-size: 7px;
        }

        table td {
            border: 1px solid #000;
            padding: 3px 2px;
            text-align: center;
            font-size: 7px;
        }

        table td.left {
            text-align: left;
            padding-left: 5px;
        }

        .kategori-row {
            background-color: #e8e8e8;
            font-weight: bold;
        }

        .signature-section {
            margin-top: 30px;
        }

        .sig-info {
            margin-bottom: 15px;
            font-size: 8px;
            display: flex;
            justify-content: space-between;
        }

        .sig-left {
            width: 45%;
        }

        .sig-right {
            width: 45%;
            text-align: right;
        }

        .sig-boxes {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .sig-box {
            width: 22%;
            text-align: center;
            font-size: 7px;
        }

        .sig-name {
            margin-top: 40px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .sig-line {
            border-top: 1px solid #000;
            width: 100%;
            margin: 2px 0;
            height: 1px;
        }

        .sig-position {
            font-size: 6px;
            margin-top: 2px;
        }
    </style>
</head>

<body>
    <div class="page">
        <!-- HEADER -->
        <div class="manual-header">
            <img src="{{ public_path('images/Logo_PLN-1.svg') }}" alt="Logo PLN" style="height: 55px;">
            <div>
                <div style="font-size: 9pt; font-style: italic;">PT PLN (Persero)</div>
                <div style="font-size: 9pt; font-style: italic;">ULP Ahmad Yani Banjarmasin</div>
                <div style="font-size: 9pt; font-style: italic;">Laporan Kegiatan Gelar Alat Operasional</div>
            </div>
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
                    <th style="width: 4%;">No</th>
                    <th style="width: 40%;">Nama Alat</th>
                    <th style="width: 7%;">Satuan</th>
                    <th style="width: 5%;">Baik</th>
                    <th style="width: 5%;">Rusak</th>
                    <th style="width: 5%;">Hilang</th>
                    <th style="width: 34%;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php
                $grouped = $gelar->detailGelars->groupBy(fn($item) => $item->alat->kategori_alat ?? 'Lain-lain');
                $rowNumber = 1;
                @endphp

                @forelse ($grouped as $kategori => $items)
                <tr class="kategori-row">
                    <td colspan="7" style="text-align: left;">
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
        <div class="signature-section">
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