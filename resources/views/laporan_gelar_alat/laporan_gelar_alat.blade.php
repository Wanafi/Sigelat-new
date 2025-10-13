<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Gelar Alat - {{ $gelar->mobil->nomor_plat }}</title>
    <style>
        @page {
            margin: 20mm 15mm 15mm 15mm;
            size: A4 portrait;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
            line-height: 1.3;
            color: #000;
        }
        
        /* Header */
        .header-container {
            width: 100%;
            margin-bottom: 10mm;
            overflow: hidden;
            padding-bottom: 5mm;
            border-bottom: 2px solid #00AFF0;
        }
        
        .header-logo {
            float: left;
            width: 100px;
        }
        
        .header-logo img {
            height: 60px;
            display: block;
        }
        
        .header-text {
            float: right;
            text-align: right;
            padding-top: 10px;
        }
        
        .header-text div {
            font-style: italic;
            font-size: 10pt;
            margin-bottom: 2px;
            line-height: 1.4;
        }
        
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
        
        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8mm;
            font-size: 8.5pt;
            border: 1.5px solid #000;
        }
        
        th, td {
            border: 1px solid #000;
            padding: 4mm 3mm;
            text-align: center;
            vertical-align: middle;
            line-height: 1.3;
        }
        
        thead th {
            background-color: #FFEB3B;
            font-weight: bold;
            font-size: 9pt;
            padding: 3mm;
        }
        
        .left-align {
            text-align: left;
            padding-left: 4mm;
        }
        
        .vertical-text {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            font-weight: bold;
            font-size: 8pt;
            padding: 3mm 2mm;
            min-width: 15px;
        }
        
        tbody td {
            font-size: 8.5pt;
            padding: 3mm;
        }
        
        /* Signature */
        .signature-wrapper {
            margin-top: 15mm;
            font-size: 9pt;
            page-break-inside: avoid;
        }
        
        .location-header {
            width: 100%;
            margin-bottom: 8mm;
            overflow: hidden;
        }
        
        .location-left {
            float: left;
            width: 48%;
            text-align: left;
            line-height: 1.5;
        }
        
        .location-right {
            float: right;
            width: 48%;
            text-align: right;
            line-height: 1.5;
        }
        
        .signatures-container {
            width: 100%;
            margin-top: 10mm;
            overflow: hidden;
        }
        
        .signature-column-left {
            float: left;
            width: 48%;
            padding-right: 5mm;
        }
        
        .signature-column-right {
            float: right;
            width: 48%;
            padding-left: 5mm;
        }
        
        .signature-box {
            text-align: center;
            margin-bottom: 20mm;
            min-height: 25mm;
        }
        
        .signature-name {
            display: inline-block;
            margin-top: 18mm;
            padding-top: 2mm;
            border-top: 1.5px solid #000;
            min-width: 60%;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9pt;
        }
        
        .signature-title {
            font-size: 8pt;
            margin-top: 2mm;
            font-weight: normal;
            line-height: 1.3;
        }
    </style>
</head>
<body>
    {{-- HEADER --}}
    <div class="header-container clearfix">
        <div class="header-logo">
            <img src="{{ public_path('images/plnt.png') }}" alt="Logo PLN">
        </div>
        <div class="header-text">
            <div>PT PLN (Persero)</div>
            <div>ULP Ahmad Yani Banjarmasin</div>
            <div>Laporan Kegiatan Gelar Alat Operasional</div>
        </div>
    </div>

    {{-- TABLE --}}
    <table>
        <thead>
            <tr>
                <th rowspan="2" style="width: 3%;"></th>
                <th rowspan="2" style="width: 4%;">No</th>
                <th rowspan="2" style="width: 40%;">
                    Yantek Unit {{ $gelar->mobil->nama_tim ?? '' }} 
                    {{ $gelar->mobil->no_unit ?? '' }} 
                    {{ $gelar->mobil->nomor_plat ?? '' }}
                </th>
                <th rowspan="2" style="width: 7%;">Satuan</th>
                <th colspan="3" style="width: 18%;">KONDISI</th>
                <th rowspan="2" style="width: 28%;">Ket</th>
            </tr>
            <tr>
                <th style="width: 6%;">B</th>
                <th style="width: 6%;">R</th>
                <th style="width: 6%;">H</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grouped = $gelar->detailGelars->groupBy(fn($item) => $item->alat->kategori_alat ?? 'Lain-lain');
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
                    <td>{{ $detail->alat->satuan ?? 'bh' }}</td>
                    <td style="font-size: 11pt;">{{ $detail->status_alat == 'Baik' ? '✔' : '' }}</td>
                    <td style="font-size: 11pt;">{{ $detail->status_alat == 'Rusak' ? '✔' : '' }}</td>
                    <td style="font-size: 11pt;">{{ $detail->status_alat == 'Hilang' ? '✔' : '' }}</td>
                    <td class="left-align">{{ $detail->keterangan ?? '-' }}</td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    {{-- SIGNATURE SECTION --}}
    <div class="signature-wrapper">
        @php
            $tanggalCetak = $gelar->confirmed_at 
                ? \Carbon\Carbon::parse($gelar->confirmed_at)->translatedFormat('d F Y')
                : \Carbon\Carbon::parse($gelar->tanggal_cek)->translatedFormat('d F Y');
            
            // Ambil pelaksana dari array
            $pelaksanaList = is_array($gelar->pelaksana) ? $gelar->pelaksana : [];
            $pelaksana1 = $pelaksanaList[0] ?? 'NAMA PELAKSANA 1';
            $pelaksana2 = $pelaksanaList[1] ?? 'NAMA PELAKSANA 2';
        @endphp

        <div class="location-header clearfix">
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

        <div class="signatures-container clearfix">
            {{-- Kolom Kiri: 2 Pelaksana --}}
            <div class="signature-column-left">
                <div class="signature-box">
                    <span class="signature-name">{{ strtoupper($pelaksana1) }}</span>
                    <div class="signature-title">Team Leader K3LK</div>
                </div>
                
                <div class="signature-box">
                    <span class="signature-name">{{ strtoupper($pelaksana2) }}</span>
                    <div class="signature-title">Team Leader K3LK</div>
                </div>
            </div>

            {{-- Kolom Kanan: 2 Pelaksana --}}
            <div class="signature-column-right">
                <div class="signature-box">
                    <span class="signature-name">{{ strtoupper($pelaksana1) }}</span>
                    <div class="signature-title">Team Leader K3LK</div>
                </div>
                
                <div class="signature-box">
                    <span class="signature-name">{{ strtoupper($pelaksana2) }}</span>
                    <div class="signature-title">Team Leader K3LK</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>