<?php

namespace App\Filament\Resources\GelarAlats\Tables;

use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\SelectFilter;

class GelarAlatsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                \App\Models\DetailGelar::query()
                    ->whereNotNull('foto_kondisi')
            )
            ->columns([
                Stack::make([
                    ImageColumn::make('foto_kondisi')
                        ->label('Foto')
                        ->square()
                        ->size(100)
                        ->extraImgAttributes(['loading' => 'lazy'])
                        ->grow(false)
                        ->getStateUsing(
                            fn($record) => Str::startsWith($record->foto_kondisi, 'foto-')
                                ? asset('storage/' . $record->foto_kondisi)
                                : asset('storage/foto-kondisi/' . $record->foto_kondisi)
                        )
                        ->url(fn($record) => $record->foto ? asset('storage/foto-kondisi/' . $record->foto) : null),


                    TextColumn::make('alat.nama_alat')
                        ->label('Nama Alat')
                        ->weight('bold')
                        ->size('lg')
                        ->searchable()
                        ->sortable()
                        ->alignCenter(),

                    TextColumn::make('gelar.mobil.nomor_plat')
                        ->label('Nomor Plat')
                        ->badge()
                        ->color('info')
                        ->icon('heroicon-o-truck')
                        ->searchable()
                        ->sortable()
                        ->alignCenter(),
                ])
                    ->alignCenter(),
            ])
            ->contentGrid([
                'md' => 1,
                'xl' => 4,
            ])

            ->filters([
                SelectFilter::make('status_alat')
                    ->label('Status Alat')
                    ->options([
                        'Baik' => 'Baik',
                        'Rusak' => 'Rusak',
                        'Hilang' => 'Hilang',
                    ])
                    ->indicator('Status'),

                SelectFilter::make('gelar.mobil_id')
                    ->label('Nomor Plat')
                    ->relationship('gelar.mobil', 'nomor_plat')
                    ->searchable()
                    ->preload()
                    ->indicator('Mobil'),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s')
            ->emptyStateHeading('Belum ada dokumentasi alat')
            ->emptyStateDescription('Dokumentasi akan muncul setelah kegiatan gelar alat dilakukan')
            ->emptyStateIcon('heroicon-o-photo');
    }
}
