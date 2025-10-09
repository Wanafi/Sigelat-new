<?php

namespace App\Filament\Resources\KonfirmasiGelars;

use App\Models\Gelar;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use BackedEnum;
use UnitEnum;
use App\Filament\Resources\KonfirmasiGelars\Pages\ListKonfirmasiGelars;
use App\Filament\Resources\KonfirmasiGelars\Pages\ViewKonfirmasiGelar;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Blade;

class KonfirmasiGelarResource extends Resource
{
    protected static ?string $model = Gelar::class;
    protected static string | UnitEnum | null $navigationGroup = 'Laporan';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;
    protected static ?string $navigationLabel = 'Konfirmasi Laporan';
    protected static ?string $modelLabel = 'Konfirmasi Laporan';
    protected static ?string $pluralModelLabel = 'Konfirmasi Laporan';
    protected static ?int $navigationSort = 1;

    public static function table(Table $table): Table
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
                
                TextColumn::make('tanggal_cek')
                    ->label('Tanggal Kegiatan')
                    ->date('d M Y')
                    ->sortable()
                    ->icon('heroicon-o-calendar')
                    ->description(fn ($record) => \Carbon\Carbon::parse($record->tanggal_cek)->diffForHumans()),
                
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
                    ->sortable(),
                
                IconColumn::make('is_confirmed')
                    ->label('Konfirmasi')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->sortable(),
                
                TextColumn::make('confirmed_at')
                    ->label('Dikonfirmasi Pada')
                    ->dateTime('d M Y H:i')
                    ->placeholder('Belum dikonfirmasi')
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('confirmedBy.name')
                    ->label('Dikonfirmasi Oleh')
                    ->placeholder('Belum dikonfirmasi')
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                \Filament\Tables\Filters\TernaryFilter::make('is_confirmed')
                    ->label('Status Konfirmasi')
                    ->placeholder('Semua')
                    ->trueLabel('Sudah Dikonfirmasi')
                    ->falseLabel('Belum Dikonfirmasi')
                    ->indicator('Konfirmasi'),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make()
                    ->label('Lihat Detail'),
            ])
            ->emptyStateHeading('Belum ada data kegiatan')
            ->emptyStateDescription('Data kegiatan gelar alat akan muncul di sini')
            ->emptyStateIcon('heroicon-o-clipboard-document-list');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make('Informasi Kegiatan')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('mobil.nomor_plat')
                            ->label('Nomor Plat Mobil')
                            ->icon('heroicon-o-truck')
                            ->weight('bold')
                            ->size('lg')
                            ->copyable()
                            ->badge()
                            ->color('info'),

                        \Filament\Infolists\Components\TextEntry::make('mobil.nama_tim')
                            ->label('Nama Tim')
                            ->icon('heroicon-o-user-group')
                            ->badge()
                            ->color('primary'),

                        \Filament\Infolists\Components\TextEntry::make('tanggal_cek')
                            ->label('Tanggal Pemeriksaan')
                            ->icon('heroicon-o-calendar')
                            ->date('l, d F Y')
                            ->weight('medium'),

                        \Filament\Infolists\Components\TextEntry::make('status')
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

                        \Filament\Infolists\Components\TextEntry::make('pelaksana')
                            ->label('Tim Pelaksana')
                            ->icon('heroicon-o-user-group')
                            ->badge()
                            ->separator(',')
                            ->weight('medium'),
                        
                        \Filament\Infolists\Components\TextEntry::make('is_confirmed')
                            ->label('Status Konfirmasi')
                            ->badge()
                            ->formatStateUsing(fn($state) => $state ? 'Sudah Dikonfirmasi' : 'Belum Dikonfirmasi')
                            ->color(fn($state) => $state ? 'success' : 'warning')
                            ->icon(fn($state) => $state ? 'heroicon-o-check-badge' : 'heroicon-o-clock'),
                        
                        \Filament\Infolists\Components\TextEntry::make('confirmed_at')
                            ->label('Dikonfirmasi Pada')
                            ->dateTime('d F Y, H:i')
                            ->placeholder('Belum dikonfirmasi')
                            ->visible(fn($record) => $record->is_confirmed),
                        
                        \Filament\Infolists\Components\TextEntry::make('confirmedBy.name')
                            ->label('Dikonfirmasi Oleh')
                            ->icon('heroicon-o-user')
                            ->badge()
                            ->color('success')
                            ->visible(fn($record) => $record->is_confirmed),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                \Filament\Schemas\Components\Section::make('Detail Pemeriksaan Alat')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->schema([
                        \Filament\Infolists\Components\RepeatableEntry::make('detailAlats')
                            ->schema([
                                \Filament\Infolists\Components\ImageEntry::make('foto_kondisi')
                                    ->label('Foto')
                                    ->disk('public')
                                    ->height(150)
                                    ->width(150)
                                    ->visible(fn($state) => filled($state)),

                                \Filament\Infolists\Components\TextEntry::make('alat.nama_alat')
                                    ->label('Nama Alat')
                                    ->icon('heroicon-o-wrench-screwdriver')
                                    ->weight('bold')
                                    ->size('md'),

                                \Filament\Infolists\Components\TextEntry::make('status_alat')
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

                                \Filament\Infolists\Components\TextEntry::make('keterangan')
                                    ->label('Catatan')
                                    ->icon('heroicon-o-chat-bubble-left-right')
                                    ->placeholder('Tidak ada catatan')
                                    ->columnSpanFull(),
                            ])
                            ->columns(3)
                            ->visible(fn($record) => $record->detailAlats()->exists())
                            ->contained(false)
                            ->columnSpanFull()
                    ])
                    ->columnSpanFull()
                    ->visible(fn($record) => $record->detailAlats()->exists()),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKonfirmasiGelars::route('/'),
            'view' => ViewKonfirmasiGelar::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }
}