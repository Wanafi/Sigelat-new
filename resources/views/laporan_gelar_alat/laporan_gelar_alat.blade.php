<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Gelar Alat - {{ $gelar->mobil->nomor_plat }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: white;
            font-family: Arial, sans-serif;
            font-size: 8.5pt;
            color: #000;
            line-height: 1.2;
        }

        .page-a4 {
            width: 210mm;
            min-height: 297mm;
            margin: auto;
            padding: 12mm;
        }

        /* Header Section */
        .manual-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #00AFF0;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        .header-text {
            text-align: right;
        }

        .header-text div {
            font-size: 9pt;
            font-style: italic;
            line-height: 1.3;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7.5pt;
            margin-top: 6px;
            line-height: 1.1;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 2px 3px;
            text-align: center;
            vertical-align: middle;
        }

        thead th {
            background-color: rgb(255, 230, 0);
            font-weight: bold;
        }

        .left-align {
            text-align: left;
        }

        .vertical-text {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            text-align: center;
            font-weight: bold;
            line-height: 1.1;
            background-color: #f0f0f0;
        }

        /* Signature Section */
        .signature-wrapper {
            margin-top: 15px;
            font-size: 8pt;
            page-break-inside: avoid;
        }

        .location-date {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .location-left {
            text-align: left;
            line-height: 1.4;
        }

        .location-right {
            text-align: right;
            line-height: 1.4;
        }

        .signature-container {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .signature-column {
            width: 48%;
        }

        .signature-box {
            text-align: center;
            margin-bottom: 50px;
        }

        .signature-box:last-child {
            margin-bottom: 0;
        }

        .signature-name {
            font-weight: bold;
            display: block;
            margin-top: 2px;
            margin-bottom: 2px;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin: 2px auto;
            width: 100%;
            max-width: 200px;
        }

        .signature-title {
            margin-top: 2px;
            font-size: 7.5pt;
        }

        /* Foto Grid */
        .foto-section {
            margin-top: 15px;
            page-break-before: always;
        }

        .foto-section-title {
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #00AFF0;
            text-align: center;
        }

        .foto-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 10px;
        }

        .foto-item {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            page-break-inside: avoid;
        }

        .foto-item img {
            max-width: 100%;
            height: auto;
            max-height: 180px;
            object-fit: contain;
            margin-bottom: 5px;
            border: 1px solid #ccc;
        }

        .foto-placeholder {
            width: 100%;
            height: 180px;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 10pt;
            border: 1px dashed #ccc;
            margin-bottom: 5px;
        }

        .foto-caption {
            font-size: 7pt;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .foto-status {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 6.5pt;
            font-weight: bold;
            margin-top: 3px;
        }

        .status-baik {
            background: #d1fae5;
            color: #065f46;
        }

        .status-rusak {
            background: #fef3c7;
            color: #92400e;
        }

        .status-hilang {
            background: #fee2e2;
            color: #991b1b;
        }

        .foto-keterangan {
            font-size: 6.5pt;
            color: #666;
            margin-top: 3px;
            text-align: left;
            padding: 3px;
            background: #f9f9f9;
            border-radius: 2px;
        }

        @media print {
            @page {
                size: A4;
                margin: 12mm;
            }

            body {
                margin: 0;
                padding: 0;
            }

            .page-a4 {
                width: 100%;
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="page-a4">
        {{-- HEADER --}}
        <div class="manual-header">
            <img src="{{ public_path('images/plnt.png') }}" alt="Logo PLN" style="height: 55px;">
            <div class="header-text">
                <div>PT PLN (Persero)</div>
                <div>ULP Ahmad Yani Banjarmasin</div>
                <div>Laporan Kegiatan Gelar Alat Operasional</div>
            </div>
        </div>

        {{-- TABEL UTAMA --}}
        <table>
            <thead>
                <tr>
                    <th style="width: 4%;" rowspan="2"></th>
                    <th style="width: 4%;" rowspan="2">No</th>
                    <th style="width: 38%;" rowspan="2">
                        {{ $gelar->mobil->nama_tim ?? '-' }} - 
                        {{ $gelar->mobil->no_unit ?? '-' }} - 
                        {{ $gelar->mobil->nomor_plat ?? '-' }}
                    </th>
                    <th style="width: 6%;" rowspan="2">Satuan</th>
                    <th style="width: 18%;" colspan="3">KONDISI</th>
                    <th style="width: 30%;" rowspan="2">Ket</th>
                </tr>
                <tr>
                    <th style="width: 6%;">B</th>
                    <th style="width: 6%;">R</th>
                    <th style="width: 6%;">H</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grouped = $gelar->detailAlats->groupBy(fn($item) => $item->alat->kategori_alat ?? 'Lain-lain');
                    $rowNumber = 1;
                @endphp

                @foreach ($grouped as $kategori => $items)
                    @foreach ($items as $index => $detail)
                        <tr>
                            @if ($index === 0)
                                <td class="vertical-text" rowspan="{{ $items->count() }}">
                                    {{ strtoupper(str_replace('_', ' ', $kategori)) }}
                                </td>
                            @endif
                            <td>{{ $rowNumber++ }}</td>
                            <td class="left-align">{{ $detail->alat->nama_alat ?? '-' }}</td>
                            <td>bh</td>
                            <td>{{ $detail->status_alat == 'Baik' ? '✔' : '' }}</td>
                            <td>{{ $detail->status_alat == 'Rusak' ? '✔' : '' }}</td>
                            <td>{{ $detail->status_alat == 'Hilang' ? '✔' : '' }}</td>
                            <td class="left-align">{{ $detail->keterangan ?? '-' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

        {{-- TANDA TANGAN --}}
        <div class="signature-wrapper">
            @php
                $tanggalCetak = \Carbon\Carbon::parse($gelar->tanggal_cek)->translatedFormat('d F Y');
                $pelaksanaList = is_array($gelar->pelaksana) ? $gelar->pelaksana : [];
            @endphp

            {{-- Header lokasi & tanggal --}}
            <div class="location-date">
                <div class="location-left">
                    PT PLN (Persero) UP3 Banjarmasin<br>
                    ULP AHMAD YANI
                </div>
                <div class="location-right">
                    Banjarmasin, {{ $tanggalCetak }}<br>
                    PT PLN Nusa Daya UL Banjarmasin<br>
                    ULP AHMAD YANI
                </div>
            </div>

            {{-- Tanda tangan --}}
            <div class="signature-container">
                {{-- Kolom Kiri --}}
                <div class="signature-column">
                    <div class="signature-box">
                        <div class="signature-name">{{ $pelaksanaList[0] ?? 'NAMA PELAKSANA 1' }}</div>
                        <div class="signature-line"></div>
                        <div class="signature-title">Pelaksana</div>
                    </div>
                    <div class="signature-box">
                        <div class="signature-name">{{ $pelaksanaList[1] ?? 'NAMA PELAKSANA 2' }}</div>
                        <div class="signature-line"></div>
                        <div class="signature-title">Pelaksana</div>
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div class="signature-column">
                    <div class="signature-box">
                        <div class="signature-name">{{ $gelar->confirmedBy->name ?? 'NAMA SUPERVISOR' }}</div>
                        <div class="signature-line"></div>
                        <div class="signature-title">Supervisor K3LK</div>
                    </div>
                    <div class="signature-box">
                        <div class="signature-name">MANAGER ULP</div>
                        <div class="signature-line"></div>
                        <div class="signature-title">Manager ULP Ahmad Yani</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- HALAMAN FOTO (jika ada) --}}
    @php
        $itemsWithPhoto = $gelar->detailAlats->filter(fn($item) => !empty($item->foto_kondisi));
    @endphp

    @if($itemsWithPhoto->count() > 0)
        <div class="page-a4 foto-section">
            {{-- Header untuk halaman foto --}}
            <div class="manual-header">
                <img src="{{ public_path('images/plnt.png') }}" alt="Logo PLN" style="height: 55px;">
                <div class="header-text">
                    <div>PT PLN (Persero)</div>
                    <div>ULP Ahmad Yani Banjarmasin</div>
                    <div>Dokumentasi Foto Kondisi Alat</div>
                </div>
            </div>

            <div class="foto-section-title">
                📸 DOKUMENTASI FOTO KONDISI ALAT<br>
                <span style="font-size: 8pt; font-weight: normal;">
                    {{ $gelar->mobil->nomor_plat }} - {{ $tanggalCetak }}
                </span>
            </div>

            <div class="foto-grid">
                @foreach($itemsWithPhoto as $detail)
                    <div class="foto-item">
                        @if($detail->foto_kondisi)
                            <img src="{{ public_path('storage/' . $detail->foto_kondisi) }}" 
                                 alt="{{ $detail->alat->nama_alat }}">
                        @else
                            <div class="foto-placeholder">
                                📷 Tidak ada foto
                            </div>
                        @endif
                        
                        <div class="foto-caption">{{ $detail->alat->nama_alat }}</div>
                        
                        <span class="foto-status 
                            @if($detail->status_alat == 'Baik') status-baik 
                            @elseif($detail->status_alat == 'Rusak') status-rusak 
                            @else status-hilang 
                            @endif">
                            {{ $detail->status_alat }}
                        </span>

                        @if($detail->keterangan)
                            <div class="foto-keterangan">
                                💬 {{ $detail->keterangan }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</body>
</html>