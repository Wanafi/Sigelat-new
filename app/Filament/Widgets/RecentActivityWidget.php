<?php

namespace App\Filament\Widgets;

use App\Models\Gelar;
use App\Models\Alat;
use App\Models\Mobil;
use Filament\Tables;
use Filament\Tables\Table;
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
                Tables\Columns\IconColumn::make('icon')
                    ->label('')
                    ->icon(fn($record) => match(true) {
                        $record->created_at->diffInMinutes(now()) < 60 => 'heroicon-o-bell',
                        $record->created_at->diffInHours(now()) < 24 => 'heroicon-o-clock',
                        default => 'heroicon-o-calendar',
                    })
                    ->color(fn($record) => match(true) {
                        $record->created_at->diffInMinutes(now()) < 60 => 'danger',
                        $record->created_at->diffInHours(now()) < 24 => 'warning',
                        default => 'gray',
                    })
                    ->size('lg'),
                    
                Tables\Columns\TextColumn::make('activity')
                    ->label('Aktivitas')
                    ->formatStateUsing(fn($record) => 
                        "Kegiatan Gelar Alat - {$record->mobil->nomor_plat}"
                    )
                    ->description(fn($record) => 
                        "Status: {$record->status} | Tim: " . implode(', ', $record->pelaksana)
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