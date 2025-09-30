<?php

namespace App\Filament\Resources\Alats\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AlatsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('mobil_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('kode_barcode')
                    ->searchable(),
                TextColumn::make('nama_alat')
                    ->searchable(),
                TextColumn::make('kategori_alat')
                    ->searchable(),
                TextColumn::make('merek_alat')
                    ->searchable(),
                TextColumn::make('tanggal_masuk')
                    ->date()
                    ->sortable(),
                TextColumn::make('status_alat'),
                TextColumn::make('foto')
                    ->searchable(),
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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
