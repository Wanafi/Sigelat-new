<?php

namespace App\Http\Controllers;

use App\Models\Gelar;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanGelarController extends Controller
{
    public function show($id)
    {
        // Cari data Gelar
        $gelar = Gelar::findOrFail($id);
        
        // Load relasi yang dibutuhkan
        $gelar->load(['mobil', 'detailGelars.alat', 'confirmedBy']);

        // Generate PDF
        $pdf = Pdf::loadView('laporan_gelar_alat.laporan_gelar_alat', ['gelar' => $gelar])
            ->setPaper('a4', 'portrait')
            ->setOption('margin-top', 10)
            ->setOption('margin-bottom', 10)
            ->setOption('margin-left', 10)
            ->setOption('margin-right', 10);

        // Nama file
        $filename = 'Laporan-Gelar-Alat-' . ($gelar->mobil->nomor_plat ?? 'TanpaPlat')
            . '-' . now()->format('Y-m-d-His') . '.pdf';

        // Download
        return $pdf->download($filename);
    }
}