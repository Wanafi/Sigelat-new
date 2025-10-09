<?php

namespace App\Filament\Resources\Gelars\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class GelarsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('mobil.nomor_plat')
                    ->label('Nomor Plat')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-o-truck')
                    ->copyable(),
                    
                TextColumn::make('status')
                    ->label('Status Kelengkapan')
                    ->badge()
                    ->colors([
                        'success' => 'Lengkap',
                        'warning' => 'Tidak Lengkap',
                    ])
                    ->icons([
                        'heroicon-o-check-circle' => 'Lengkap',
                        'heroicon-o-exclamation-triangle' => 'Tidak Lengkap',
                    ])
                    ->sortable()
                    ->searchable(),
                
                IconColumn::make('is_confirmed')
                    ->label('Konfirmasi')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->tooltip(fn ($record) => $record->is_confirmed ? 'Sudah dikonfirmasi' : 'Belum dikonfirmasi')
                    ->sortable(),
                    
                TextColumn::make('tanggal_cek')
                    ->label('Tanggal Kegiatan')
                    ->date('d M Y')
                    ->sortable()
                    ->icon('heroicon-o-calendar')
                    ->description(fn ($record) => \Carbon\Carbon::parse($record->tanggal_cek)->diffForHumans())
                    ->sortable(),
                    
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Lengkap' => 'Lengkap',
                        'Tidak Lengkap' => 'Tidak Lengkap',
                    ])
                    ->indicator('Status'),
                
                \Filament\Tables\Filters\TernaryFilter::make('is_confirmed')
                    ->label('Status Konfirmasi')
                    ->placeholder('Semua')
                    ->trueLabel('Sudah Dikonfirmasi')
                    ->falseLabel('Belum Dikonfirmasi')
                    ->indicator('Konfirmasi'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->visible(fn($record) => !$record->is_confirmed),
                DeleteAction::make()
                    ->visible(fn($record) => !$record->is_confirmed),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}