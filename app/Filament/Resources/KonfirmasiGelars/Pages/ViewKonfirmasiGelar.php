<?php

namespace App\Filament\Resources\KonfirmasiGelars\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;
use App\Filament\Resources\KonfirmasiGelars\KonfirmasiGelarResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Gelar;

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
                ->visible(fn(Gelar $record): bool => !$record->is_confirmed)
                ->action(function (Gelar $record): void {
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
                ->visible(fn(Gelar $record): bool => $record->is_confirmed)
                ->url(fn(Gelar $record) => route('laporan-gelar.show', $record->id))
                ->openUrlInNewTab(),
        ];
    }
}