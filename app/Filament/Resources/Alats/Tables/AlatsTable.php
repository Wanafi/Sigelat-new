<?php

namespace App\Filament\Resources\Alats\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;

class AlatsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto')
                    ->circular()
                    ->getStateUsing(fn($record) => asset('storage/' . $record->foto))
                    ->height(50)
                    ->width(50)
                    ->getStateUsing(fn($record) => asset('storage/' . $record->foto))
                    ->url(fn($record) => $record->foto ? asset('storage/' . $record->foto) : null),
                TextColumn::make('kode_barcode')
                    ->searchable(),
                TextColumn::make('nama_alat')
                    ->searchable(),
                TextColumn::make('kategori_alat')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('merek_alat')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tanggal_masuk')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                BadgeColumn::make('status_alat')
                    ->sortable()
                    ->toggleable()
                    ->colors([
                        'success' => 'Baik',
                        'danger' => 'Rusak',
                        'warning' => 'Hilang',
                    ])
                    ->icons([
                        'heroicon-o-check-circle' => 'Baik',
                        'heroicon-o-exclamation-triangle' => 'Rusak',
                        'heroicon-o-wrench-screwdriver' => 'Hilang',
                    ]),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
