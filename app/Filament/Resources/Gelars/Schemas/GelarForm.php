<?php

namespace App\Filament\Resources\Gelars\Schemas;

use App\Models\Alat;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ToggleButtons;
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
                                $alatList = Alat::where('mobil_id', $state)
                                    ->get()
                                    ->map(fn($alat) => [
                                        'alat_id' => $alat->id,
                                        'nama_alat' => $alat->nama_alat,
                                        'status_alat' => $alat->status_alat, // Use status_alat here
                                        'keterangan' => null,
                                    ])
                                    ->toArray();
                                $set('detail_alats', $alatList);
                            }),

                        DatePicker::make('tanggal_cek')
                            ->label('Tanggal Pemeriksaan')
                            ->default(now())
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        Select::make('status')
                            ->label('Status Kelengkapan')
                            ->options([
                                'Lengkap' => 'Lengkap',
                                'Tidak Lengkap' => 'Tidak Lengkap',
                            ])
                            ->default('Tidak Lengkap')
                            ->required(),

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
                    ->description('Periksa dan update kondisi setiap alat')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->schema([
                        Repeater::make('detail_alats')
                            ->statePath('detail_alats')
                            ->grid(2)
                            ->schema([
                                TextInput::make('alat_id')
                                    ->label('ID Alat')
                                    ->hidden(),

                                TextInput::make('nama_alat')
                                    ->label('Nama Alat')
                                    ->disabled()
                                    ->columns(3)
                                    ->dehydrated(false)
                                    ->extraAttributes(['class' => 'font-semibold']),

                                ToggleButtons::make('status_alat')
                                    ->label('Kondisi Alat')
                                    ->grouped()
                                    ->columns(2)
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
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $get) {
                                        $alatId = $get('alat_id');
                                        if ($alatId && in_array($state, ['Baik', 'Rusak', 'Hilang'])) {
                                            $alat = Alat::find($alatId);
                                            if ($alat && $alat->status_alat !== $state) {
                                                $alat->update(['status_alat' => $state]);
                                            }
                                        }
                                    }),

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
                            ->visible(fn($get) => filled($get('detail_alats')))
                            ->itemLabel(fn(array $state): ?string => $state['nama_alat'] ?? null)
                            ->collapsed()
                            ->cloneable(false),
                    ])
                    ->collapsible()
                    ->columnspanFull(),
            ]);
    }
}
