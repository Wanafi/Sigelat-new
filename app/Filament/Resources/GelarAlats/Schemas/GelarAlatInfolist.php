<?php

namespace App\Filament\Resources\GelarAlats\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class GelarAlatInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Alat')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        TextEntry::make('alat.nama_alat')
                            ->label('Nama Alat')
                            ->icon('heroicon-o-wrench-screwdriver')
                            ->weight('bold')
                            ->size('lg')
                            ->copyable(),
                        
                        TextEntry::make('alat.kode_barcode')
                            ->label('Kode Barcode')
                            ->icon('heroicon-o-qr-code')
                            ->copyable()
                            ->placeholder('Tidak ada barcode'),
                        
                        TextEntry::make('gelar.mobil.nomor_plat')
                            ->label('Nomor Plat Mobil')
                            ->icon('heroicon-o-truck')
                            ->badge()
                            ->color('info')
                            ->copyable(),
                        
                        TextEntry::make('gelar.mobil.nama_tim')
                            ->label('Nama Tim')
                            ->icon('heroicon-o-user-group')
                            ->badge()
                            ->color('primary'),
                        
                        TextEntry::make('gelar.tanggal_cek')
                            ->label('Tanggal Pengecekan')
                            ->icon('heroicon-o-calendar')
                            ->date('l, d F Y')
                            ->weight('medium'),
                        
                        TextEntry::make('gelar.pelaksana')
                            ->label('Tim Pelaksana')
                            ->icon('heroicon-o-users')
                            ->badge()
                            ->separator(','),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                
                Section::make('Status & Kondisi')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->schema([
                        TextEntry::make('status_alat')
                            ->label('Status Kondisi')
                            ->badge()
                            ->size('lg')
                            ->icon(fn(string $state): string => match ($state) {
                                'Baik' => 'heroicon-o-check-circle',
                                'Rusak' => 'heroicon-o-exclamation-triangle',
                                'Hilang' => 'heroicon-o-x-circle',
                                default => 'heroicon-o-question-mark-circle',
                            })
                            ->color(fn(string $state): string => match ($state) {
                                'Baik' => 'success',
                                'Rusak' => 'warning',
                                'Hilang' => 'danger',
                                default => 'gray',
                            }),
                        
                        TextEntry::make('keterangan')
                            ->label('Keterangan')
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->placeholder('Tidak ada keterangan tambahan')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                
                Section::make('Dokumentasi Foto')
                    ->icon('heroicon-o-camera')
                    ->schema([
                        ImageEntry::make('foto_kondisi')
                            ->label('Foto Kondisi Alat')
                            ->disk('public')
                            ->height(400)
                            ->visible(fn($state) => filled($state))
                            ->columnSpanFull(),
                        
                        TextEntry::make('foto_kondisi')
                            ->label('')
                            ->default('Tidak ada foto dokumentasi')
                            ->icon('heroicon-o-photo')
                            ->color('gray')
                            ->visible(fn($state) => empty($state))
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->collapsed(fn($record) => empty($record->foto_kondisi)),
            ]);
    }
}