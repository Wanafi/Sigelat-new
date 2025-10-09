<?php

namespace App\Filament\Resources\KonfirmasiGelars\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;
use App\Filament\Resources\KonfirmasiGelars\KonfirmasiGelarResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

class ViewKonfirmasiGelar extends ViewRecord
{
    protected static string $resource = KonfirmasiGelarResource::class;

    public function getTitle(): string
    {
        return 'Detail Laporan Gelar Alat';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('konfirmasi')
                ->label('Konfirmasi Laporan')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Konfirmasi Laporan')
                ->modalDescription('Apakah Anda yakin ingin mengkonfirmasi laporan ini? Setelah dikonfirmasi, Anda dapat mencetak dokumen PDF.')
                ->modalSubmitActionLabel('Ya, Konfirmasi')
                ->visible(fn($record) => !$record->is_confirmed)
                ->action(function ($record) {
                    $record->update([
                        'is_confirmed' => true,
                        'confirmed_by' => optional(Auth::user())->id,
                    ]);

                    Notification::make()
                        ->title('Laporan Berhasil Dikonfirmasi')
                        ->success()
                        ->body('Laporan telah dikonfirmasi. Anda dapat mencetak dokumen PDF sekarang.')
                        ->send();
                }),

            Action::make('cetak_pdf')
                ->label('Cetak PDF')
                ->icon('heroicon-o-printer')
                ->color('primary')
                ->visible(fn($record) => $record->is_confirmed)
                ->action(function ($record) {
                    return $this->generatePdf($record);
                }),
        ];
    }

    protected function generatePdf($record)
    {
        // Load relasi yang dibutuhkan
        $record->load(['mobil', 'detailAlats.alat', 'confirmedBy']);
        
        $data = [
            'gelar' => $record,
            'tanggal_cetak' => now()->format('d F Y'),
        ];

        // Generate PDF
        $pdf = Pdf::loadView('laporan_gelar_alat.laporan_gelar_alat', $data)
            ->setPaper('a4', 'portrait')
            ->setOption('margin-top', 10)
            ->setOption('margin-bottom', 10)
            ->setOption('margin-left', 15)
            ->setOption('margin-right', 15);

        $filename = 'Laporan-Gelar-Alat-' . $record->mobil->nomor_plat . '-' . $record->tanggal_cek->format('Y-m-d') . '.pdf';

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename);
    }
}