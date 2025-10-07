<?php

namespace App\Filament\Resources\Alats\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\MarkdownEditor;

class AlatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // =============================
                // GROUP KIRI — Deskripsi Alat
                // =============================
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('nama_alat')
                                    ->required()
                                    ->maxLength(255),

                                Select::make('kategori_alat')
                                    ->label('Kategori Alat')
                                    ->required()
                                    ->options([
                                        'Peralatan Kerja' => 'Peralatan Kerja',
                                        'Peralatan K3' => 'Peralatan K3',
                                    ])
                                    ->searchable()
                                    ->native(false)
                                    ->placeholder('Pilih Kategori'),

                                TextInput::make('merek_alat')
                                    ->required(),

                                MarkdownEditor::make('spesifikasi')
                                    ->placeholder('Tulis spesifikasi alat di sini...')
                                    ->columnSpan('full'),

                                DatePicker::make('tanggal_masuk')
                                    ->required()
                                    ->columnSpan('full')
                                    ->displayFormat('d/m/Y'),
                            ])
                            ->columns(3),
                    ])
                    ->columnSpan(['lg' => 2]), // kiri lebar

                // =============================
                // GROUP KANAN — Barcode & Status
                // =============================
                Group::make()
                    ->schema([
                        Section::make('Barcode')
                            ->description('Kode unik alat')
                            ->schema([
                                FileUpload::make('foto')
                                    ->label('Foto Alat')
                                    ->image()
                                    ->disk('public')
                                    ->directory('foto-alat')
                                    ->imagePreviewHeight('200')
                                    ->maxSize(2048)
                                    ->columnSpanFull(),

                                TextInput::make('kode_barcode')
                                    ->label('Kode Barcode')
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->default('QR-' . random_int(100000, 999999))
                                    ->prefixIcon('heroicon-o-qr-code'),
                            ])
                            ->columns(1),

                        Section::make()
                            ->description('Status kondisi alat saat ini')
                            ->schema([
                                ToggleButtons::make('status_alat')
                                    ->inline()
                                    ->grouped()
                                    ->options([
                                        'Baik' => 'Baik',
                                        'Rusak' => 'Rusak',
                                        'Hilang' => 'Hilang',
                                    ])
                                    ->colors([
                                        'Baik' => 'success',
                                        'Rusak' => 'warning',
                                        'Hilang' => 'danger',
                                    ])
                                    ->icons([
                                        'Baik' => 'heroicon-o-check-circle',
                                        'Rusak' => 'heroicon-o-exclamation-triangle',
                                        'Hilang' => 'heroicon-o-wrench-screwdriver',
                                    ])
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]), // kanan sempit

                // =============================
                // SECTION BAWAH FULL — Mobil
                // =============================
                Group::make()
                    ->schema([
                        Section::make('Mobil')
                            ->description('Mobil yang menggunakan alat ini')
                            ->schema([
                                Select::make('mobil_id')
                                    ->label('Nomor Plat Mobil')
                                    ->relationship('mobil', 'nomor_plat')
                                    ->searchable()
                                    ->preload()
                                    ->placeholder('Belum ditempatkan'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 3]), // full width
            ])
            ->columns(3); // total layout: 2 kiri + 1 kanan + bawah full
    }
}
