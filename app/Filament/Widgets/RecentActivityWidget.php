<?php

namespace App\Filament\Widgets;

use App\Models\Gelar;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\IconSize;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentActivityWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Aktivitas Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Gelar::query()
                    ->with(['mobil'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\IconColumn::make('is_confirmed')
                    ->label('')
                    ->icon(fn($state): Heroicon => $state
                        ? Heroicon::OutlinedCheckCircle
                        : Heroicon::OutlinedClock
                    )
                    ->color(fn($state): string => $state ? 'success' : 'warning')
                    ->size(IconSize::Large),

                Tables\Columns\TextColumn::make('mobil.nomor_plat')
                    ->label('Aktivitas')
                    ->formatStateUsing(
                        fn($record) =>
                        'Kegiatan Gelar Alat - ' . ($record->mobil->nomor_plat ?? 'Mobil tidak diketahui')
                    )
                    ->description(
                        fn($record) =>
                        "Status: " . ($record->status ?? '-') .
                            (
                                !empty($record->pelaksana)
                                ? ' | Tim: ' . (is_array($record->pelaksana)
                                    ? implode(', ', $record->pelaksana)
                                    : $record->pelaksana)
                                : ''
                            )
                    )
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->since()
                    ->sortable()
                    ->alignEnd(),
            ])
            ->paginated(false);
    }
}
