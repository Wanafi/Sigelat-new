<?php

namespace App\Filament\Resources\GelarAlats\Schemas;

use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class GelarAlatInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            // 🧩 Grid utama: bagi dua kolom untuk Status & Informasi
            Grid::make(2)
                ->schema([

                    Section::make('Informasi Alat')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            TextEntry::make('alat.nama_alat')
                                ->label('Nama Alat')
                                ->icon('heroicon-o-wrench-screwdriver')
                                ->weight('bold')
                                ->size('lg'),

                            TextEntry::make('alat.kode_barcode')
                                ->label('Kode Barcode')
                                ->icon('heroicon-o-qr-code')
                                ->placeholder('Tidak ada barcode'),

                            TextEntry::make('gelar.mobil.nomor_plat')
                                ->label('Nomor Plat Mobil')
                                ->icon('heroicon-o-truck')
                                ->badge()
                                ->color('info'),

                            TextEntry::make('gelar.mobil.nama_tim')
                                ->label('Nama Tim')
                                ->icon('heroicon-o-user-group')
                                ->badge()
                                ->color('primary'),

                            TextEntry::make('gelar.tanggal_cek')
                                ->label('Tanggal Pengecekan')
                                ->icon('heroicon-o-calendar')
                                ->date('l, d F Y'),

                            TextEntry::make('gelar.pelaksana')
                                ->label('Tim Pelaksana')
                                ->icon('heroicon-o-users')
                                ->badge()
                                ->separator(','),
                        ])
                        ->columns(2),
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
                                ->placeholder('Tidak ada keterangan tambahan')
                                ->columnSpanFull(),
                        ])
                        ->columns(1),
                ])
                ->columnSpanFull(),

            // 📸 Dokumentasi Foto (full width)
            Section::make('Dokumentasi Foto')
                ->icon('heroicon-o-camera')
                ->schema([
                    ImageEntry::make('foto_kondisi')
                        ->label('Foto Kondisi Alat')
                        ->height(400)
                        ->extraAttributes(['class' => 'mx-auto rounded-xl shadow-md'])
                        ->visible(fn($state) => filled($state))
                        ->getStateUsing(fn($record) =>
                            Str::startsWith($record->foto_kondisi, 'foto-')
                                ? asset('storage/' . $record->foto_kondisi)
                                : asset('storage/foto-kondisi/' . $record->foto_kondisi)
                        ),

                    TextEntry::make('foto_kondisi')
                        ->label('')
                        ->default('Tidak ada foto dokumentasi')
                        ->icon('heroicon-o-photo')
                        ->color('gray')
                        ->visible(fn($state) => empty($state))
                        ->columnSpanFull(),
                ])
                ->collapsed(fn($record) => empty($record->foto_kondisi))
                ->columnSpanFull(),
        ]);
    }
}
