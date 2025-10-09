<?php

namespace App\Filament\Resources\Gelars;

use UnitEnum;
use BackedEnum;
use App\Models\Gelar;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Resources\Gelars\Pages\EditGelar;
use Filament\Infolists\Components\RepeatableEntry;
use App\Filament\Resources\Gelars\Pages\ListGelars;
use App\Filament\Resources\Gelars\Schemas\GelarForm;
use App\Filament\Resources\Gelars\Tables\GelarsTable;
use App\Filament\Resources\GelarResource\Pages\CreateGelar;
use Filament\Forms\Components\Repeater\TableColumn;

class GelarResource extends Resource
{
    protected static ?string $model = Gelar::class;

    protected static string | UnitEnum | null $navigationGroup = 'Manajemen';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboard;

    protected static ?string $recordTitleAttribute = 'Gelar';

    public static function form(Schema $schema): Schema
    {
        return GelarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GelarsTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Kegiatan')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        TextEntry::make('mobil.nomor_plat')
                            ->label('Nomor Plat Mobil')
                            ->icon('heroicon-o-truck')
                            ->weight('bold')
                            ->size('lg')
                            ->copyable()
                            ->copyMessage('Nomor plat disalin!')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('tanggal_cek')
                            ->label('Tanggal Pemeriksaan')
                            ->icon('heroicon-o-calendar')
                            ->date('d F Y')
                            ->weight('medium'),

                        TextEntry::make('status')
                            ->label('Status Kelengkapan')
                            ->badge()
                            ->size('lg')
                            ->icon(fn(string $state): string => match ($state) {
                                'Lengkap' => 'heroicon-o-check-circle',
                                'Tidak Lengkap' => 'heroicon-o-exclamation-triangle',
                                default => 'heroicon-o-question-mark-circle',
                            })
                            ->color(fn(string $state): string => match ($state) {
                                'Lengkap' => 'success',
                                'Tidak Lengkap' => 'warning',
                                default => 'gray',
                            }),

                        TextEntry::make('pelaksana')
                            ->label('Tim Pelaksana')
                            ->icon('heroicon-o-user-group')
                            ->badge()
                            ->separator(',')
                            ->weight('medium'),
                    ])
                    ->columns(2)
                    ->columnspanFull(),

                Section::make('Detail Pemeriksaan Alat')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->schema([
                        RepeatableEntry::make('detailAlats')
                            ->schema([
                                TextEntry::make('alat.nama_alat')
                                    ->label('Nama Alat')
                                    ->icon('heroicon-o-wrench-screwdriver')
                                    ->weight('bold')
                                    ->size('md'),

                                TextEntry::make('status_alat')
                                    ->label('Kondisi')
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
                                    ->label('Catatan')
                                    ->icon('heroicon-o-chat-bubble-left-right')
                                    ->placeholder('Tidak ada catatan')
                                    ->default('-'),

                                // ImageEntry::make('foto_kondisi')
                                //     ->label('Foto Dokumentasi')
                                //     ->height(200)
                                //     ->width(200)
                                //     ->disk('public')
                                //     ->visible(fn($state) => filled($state)),
                            ])
                            ->columns(3)
                            ->visible(fn($record) => $record->detailAlats()->exists())
                            ->contained(false)
                            ->columnSpanFull()

                    ])
                    ->columnspanFull()
                    ->visible(fn($record) => $record->detailAlats()->exists()),
            ]);
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
            'index' => ListGelars::route('/'),
            'create' => CreateGelar::route('/create'),
            'edit' => EditGelar::route('/{record}/edit'),
        ];
    }
}
