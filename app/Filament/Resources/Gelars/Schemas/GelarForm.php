<?php

namespace App\Filament\Resources\Gelars\Schemas;

use App\Models\Alat;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class GelarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kegiatan')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Select::make('mobil_id')
                            ->label('Nomor Plat Mobil')
                            ->relationship('mobil', 'nomor_plat')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->placeholder('Pilih nomor plat mobil')
                            ->afterStateUpdated(function (Set $set, $state) {
                                if (!$state) {
                                    $set('detail_alats', []);
                                    return;
                                }
                                
                                $alatList = Alat::where('mobil_id', $state)
                                    ->get()
                                    ->values()
                                    ->map(function($alat) {
                                        return [
                                            'alat_id' => (string) $alat->id, // Cast ke string
                                            'nama_alat' => $alat->nama_alat,
                                            'status_alat' => $alat->status_alat,
                                            'keterangan' => '',
                                            'foto_kondisi' => null,
                                        ];
                                    })
                                    ->toArray();
                                    
                                $set('detail_alats', $alatList);
                            }),

                        DatePicker::make('tanggal_cek')
                            ->label('Tanggal Pemeriksaan')
                            ->default(now())
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        TagsInput::make('pelaksana')
                            ->label('Nama Pelaksana')
                            ->placeholder('Ketik nama pelaksana')
                            ->helperText('Tekan Enter setelah setiap nama')
                            ->separator(',')
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnspanFull()
                    ->collapsible(),

                Section::make('Daftar Alat di Mobil')
                    ->description('Periksa dan update kondisi setiap alat. Status gelar akan otomatis "Tidak Lengkap" jika ada alat yang hilang.')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->schema([
                        Repeater::make('detail_alats')
                            ->schema([
                                // Gunakan Hidden untuk menyimpan alat_id
                                Hidden::make('alat_id'),

                                TextInput::make('nama_alat')
                                    ->label('Nama Alat')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->extraAttributes(['class' => 'font-semibold'])
                                    ->columnSpan(3),

                                ToggleButtons::make('status_alat')
                                    ->label('Kondisi Alat')
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
                                        'Hilang' => 'heroicon-o-x-circle',
                                    ])
                                    ->required()
                                    ->inline()
                                    ->columnSpan(2),

                                Textarea::make('keterangan')
                                    ->label('Keterangan')
                                    ->placeholder('Tambahkan catatan jika diperlukan (opsional)')
                                    ->rows(4)
                                    ->columnSpanFull(),

                                FileUpload::make('foto_kondisi')
                                    ->label('📷 Foto Kondisi Alat')
                                    ->directory('foto-kondisi')
                                    ->image()
                                    ->imageEditor()
                                    ->disk('public')
                                    ->imagePreviewHeight('200')
                                    ->maxSize(2048)
                                    ->helperText('Ambil foto untuk dokumentasi kondisi alat')
                                    ->extraAttributes([
                                        'accept' => 'image/*',
                                        'capture' => 'environment',
                                    ])
                                    ->columnSpanFull(),
                            ])
                            ->columns(3)
                            ->disableItemCreation()
                            ->disableItemDeletion()
                            ->disableItemMovement()
                            ->visible(fn(Get $get) => filled($get('detail_alats')))
                            ->itemLabel(fn(array $state): ?string => $state['nama_alat'] ?? null)
                            ->collapsed()
                            ->cloneable(false)
                            ->defaultItems(0),
                    ])
                    ->collapsible()
                    ->columnspanFull(),
            ]);
    }
}