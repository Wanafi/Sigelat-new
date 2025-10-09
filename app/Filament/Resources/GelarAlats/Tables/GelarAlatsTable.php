<?php

namespace App\Filament\Resources\GelarAlats\Tables;

use Filament\Tables\Table;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\Layout\Split;

class GelarAlatsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    ImageColumn::make('foto_kondisi')
                        ->label('Foto')
                        ->square()
                        ->size(120)
                        ->disk('public')
                        ->defaultImageUrl(url('/images/no-image.png'))
                        ->extraImgAttributes(['loading' => 'lazy'])
                        ->grow(false),
                    
                    Stack::make([
                        TextColumn::make('alat.nama_alat')
                            ->label('Nama Alat')
                            ->weight('bold')
                            ->size('lg')
                            ->icon('heroicon-o-wrench-screwdriver')
                            ->searchable()
                            ->sortable(),
                        
                        TextColumn::make('gelar.mobil.nomor_plat')
                            ->label('Nomor Plat')
                            ->badge()
                            ->color('info')
                            ->icon('heroicon-o-truck')
                            ->searchable()
                            ->sortable(),
                        
                        TextColumn::make('status_alat')
                            ->badge()
                            ->colors([
                                'success' => 'Baik',
                                'warning' => 'Rusak',
                                'danger' => 'Hilang',
                            ])
                            ->icons([
                                'heroicon-o-check-circle' => 'Baik',
                                'heroicon-o-exclamation-triangle' => 'Rusak',
                                'heroicon-o-x-circle' => 'Hilang',
                            ])
                            ->searchable(),
                        
                        TextColumn::make('gelar.tanggal_cek')
                            ->label('Tanggal Pengecekan')
                            ->date('d M Y')
                            ->icon('heroicon-o-calendar')
                            ->color('gray')
                            ->sortable(),
                        
                        TextColumn::make('keterangan')
                            ->label('Keterangan')
                            ->limit(50)
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->color('gray')
                            ->placeholder('Tidak ada keterangan')
                            ->wrap(),
                    ])->space(2),
                ])->from('md'),
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
            ->recordActions([
                ViewAction::make()
                    ->label('Lihat Detail')
                    ->icon('heroicon-o-eye'),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s')
            ->emptyStateHeading('Belum ada dokumentasi alat')
            ->emptyStateDescription('Dokumentasi akan muncul setelah kegiatan gelar alat dilakukan')
            ->emptyStateIcon('heroicon-o-photo');
    }
}