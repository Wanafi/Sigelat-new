<?php

namespace App\Filament\Resources\Mobils;

use BackedEnum;
use App\Models\Mobil;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\Mobils\Pages\EditMobil;
use Filament\Infolists\Components\RepeatableEntry;
use App\Filament\Resources\Mobils\Pages\ListMobils;
use App\Filament\Resources\Mobils\Pages\CreateMobil;
use App\Filament\Resources\Mobils\Schemas\MobilForm;
use App\Filament\Resources\Mobils\Tables\MobilsTable;

class MobilResource extends Resource
{
    protected static ?string $model = Mobil::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Mobil';

    public static function form(Schema $schema): Schema
    {
        return MobilForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MobilsTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Mobil')
                    ->schema([
                        TextEntry::make('nomor_plat')
                            ->label('Nomor Plat'),
                        TextEntry::make('merk_mobil')
                            ->label('Informasi Detail Mobil'),
                        // 🔽 Contoh tambahan baru
                        TextEntry::make('created_at')
                            ->label('Dibuat pada')
                            ->dateTime('d M Y H:i')
                            ->icon('heroicon-o-calendar'),
                    ])
                    ->columns(1),

                Section::make('Catatan')
                    ->schema([
                        TextEntry::make('no_unit')
                            ->label('Nomor Unit Mobil'),
                        TextEntry::make('nama_tim')
                            ->label('Tim Armada'),
                        TextEntry::make('status_mobil')
                            ->label('Status Mobil')
                            ->badge()
                            ->icons([
                                'heroicon-o-check-circle' => 'Aktif',
                                'heroicon-o-exclamation-triangle' => 'Tidak Aktif',
                                'heroicon-o-wrench-screwdriver' => 'Dalam Perbaikan',
                            ])
                            ->colors([
                                'success' => 'Aktif',
                                'danger' => 'Tidak Aktif',
                                'warning' => 'Dalam Perbaikan',
                            ]),
                    ])
                    ->columns(1),

                Section::make('Daftar Alat di Kendaraan')
                    ->description('Data seluruh alat yang terdaftar di mobil ini.')
                    ->schema([
                        RepeatableEntry::make('alats')
                            ->label('Alat Terdaftar')
                            ->schema([
                                TextEntry::make('nama_alat')
                                    ->label('Nama Alat')
                                    ->icon('heroicon-m-wrench-screwdriver')
                                    ->extraAttributes([
                                        'class' => 'px-3 py-2 rounded-xl bg-white/30 backdrop-blur-md border border-white/20 shadow-lg text-gray-900',
                                        'style' => 'transform: perspective(800px) translateZ(10px);',
                                    ]),

                                TextEntry::make('kode_barcode')
                                    ->label('Kode Barcode')
                                    ->icon('heroicon-m-qr-code')
                                    ->extraAttributes([
                                        'class' => 'px-3 py-2 rounded-xl bg-white/30 backdrop-blur-md border border-white/20 shadow-lg text-gray-900',
                                        'style' => 'transform: perspective(800px) translateZ(10px);',
                                    ]),

                                TextEntry::make('status_alat')
                                    ->label('Status')
                                    ->badge()
                                    ->colors([
                                        'primary' => 'Baik',
                                        'warning' => 'Hilang',
                                        'danger' => 'Rusak',
                                    ])
                                    ->icons([
                                        'Baik' => 'heroicon-o-check-circle',
                                        'Hilang' => 'heroicon-o-no-symbol',
                                        'Rusak' => 'heroicon-o-exclamation-circle',
                                    ])
                                    ->extraAttributes([
                                        'class' => 'px-3 py-2 rounded-xl bg-white/30 backdrop-blur-md border border-white/20 shadow-lg text-gray-900',
                                        'style' => 'transform: perspective(800px) translateZ(10px);',
                                    ]),
                            ])
                            ->columns([
                                'md' => 3,
                                'lg' => 3,
                            ]),
                    ])
                    ->columnSpanFull(), // <— 🔥 tambahkan ini di level Section!
            ])
            ->columns(2);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMobils::route('/'),
            'create' => CreateMobil::route('/create'),
            'edit' => EditMobil::route('/{record}/edit'),
        ];
    }
}
