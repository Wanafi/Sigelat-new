<?php

namespace App\Filament\Resources\KonfirmasiGelars\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;
use App\Filament\Resources\KonfirmasiGelars\KonfirmasiGelarResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\Gelar; // Import the Gelar model
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

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
                ->visible(fn(Gelar $record): bool => !$record->is_confirmed) // Use type-hinted $record
                ->action(function (Gelar $record): void { // Use type-hinted $record
                    $record->update([
                        'is_confirmed' => true,
                        'confirmed_by' => optional(Auth::user())->id,
                        'confirmed_at' => now(),
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
                ->visible(fn(Gelar $record): bool => $record->is_confirmed) // Use type-hinted $record
                ->action(function (ViewKonfirmasiGelar $livewire, Gelar $record): StreamedResponse {
                    return $livewire->generatePdf($record);
                }),
        ];
    }

    protected function generatePdf(Gelar $record): StreamedResponse
    {
        // Pastikan semua relasi yang dibutuhkan sudah diload
        $record->load(['mobil', 'detailGelars.alat', 'confirmedBy']);

        $data = [
            'gelar' => $record,
        ];

        // Gunakan Blade view kamu sendiri: resources/views/laporan-gelar.blade.php
        $pdf = Pdf::loadView('laporan_gelar_alat.laporan_gelar_alat', $data)
            ->setPaper('a4', 'portrait')
            ->setOption('margin-top', 10)
            ->setOption('margin-bottom', 10)
            ->setOption('margin-left', 10)
            ->setOption('margin-right', 10);

        $filename = 'Laporan-Gelar-Alat-' . ($record->mobil->nomor_plat ?? 'TanpaPlat')
            . '-' . now()->format('Y-m-d') . '.pdf';

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename);
    }
}
