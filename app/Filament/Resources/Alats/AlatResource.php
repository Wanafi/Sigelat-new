<?php

namespace App\Filament\Resources\Alats;

use UnitEnum;
use BackedEnum;
use App\Models\Alat;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Grid;
use Filament\Support\Enums\Alignment;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Resources\Alats\Pages\EditAlat;
use App\Filament\Resources\Alats\Pages\ListAlats;
use App\Filament\Resources\Alats\Pages\CreateAlat;
use App\Filament\Resources\Alats\Schemas\AlatForm;
use App\Filament\Resources\Alats\Tables\AlatsTable;

class AlatResource extends Resource
{
    protected static ?string $model = Alat::class;

    protected static string | UnitEnum | null $navigationGroup = 'Manajemen';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static ?string $recordTitleAttribute = 'Alat';

    public static function form(Schema $schema): Schema
    {
        return AlatForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AlatsTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Spesidikasi Alat')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                // Kolom 1: Foto
                                ImageEntry::make('foto')
                                    ->label('Foto Alat')
                                    ->height(120)
                                    ->width(120)
                                    ->defaultImageUrl(asset('images/no-image.png'))
                                    ->extraAttributes(['class' => 'flex justify-center'])
                                    ->columnSpan(1),

                                // Kolom 2-4: Informasi Detail (3 kolom)
                                Grid::make(3)
                                    ->schema([
                                        TextEntry::make('kode_barcode')
                                            ->label('Kode Barcode')
                                            ->icon('heroicon-m-qr-code')
                                            ->copyable()
                                            ->columnSpan(1),

                                        TextEntry::make('nama_alat')
                                            ->label('Nama Alat')
                                            ->columnSpan(1),

                                        TextEntry::make('status_alat')
                                            ->label('Status')
                                            ->badge()
                                            ->color(fn(string $state): string => match ($state) {
                                                'Baik' => 'success',
                                                'Rusak' => 'warning',
                                                'Hilang' => 'danger',
                                                default => 'gray',
                                            })
                                            ->columnSpan(1),

                                        TextEntry::make('merek_alat')
                                            ->label('Merek')
                                            ->columnSpan(1),

                                        TextEntry::make('kategori_alat')
                                            ->label('Kategori')
                                            ->badge()
                                            ->color('warning')
                                            ->columnSpan(1),

                                        TextEntry::make('mobil.nomor_plat')
                                            ->label('Digunakan di Mobil')
                                            ->icon('heroicon-m-truck')
                                            ->columnSpan(1)
                                            ->hidden(fn($record) => $record->mobil === null),
                                    ])
                                    ->columnSpan(3),
                            ]),
                    ])
                    ->extraAttributes(['class' => 'backdrop-blur-xl bg-white/5 border border-white/10 rounded-2xl p-6 shadow-lg'])
                    ->columnSpanFull(),


                Section::make('Deskripsi')
                    ->description('Informasi teknis atau deskripsi tambahan alat.')
                    ->schema([
                        TextEntry::make('spesifikasi')
                            ->markdown()
                            ->hiddenLabel()
                            ->placeholder('Tidak ada spesifikasi'),
                    ])
                    ->collapsible()
                    ->columnSpan(2)
                    ->collapsed(false)
                    ->extraAttributes(['class' => 'backdrop-blur-xl bg-white/5 border border-white/10 rounded-2xl p-6 shadow-lg']),

                Section::make()
                    ->schema([
                        TextEntry::make('qrcode')
                            ->label('')
                            ->html()
                            ->state(function ($record) {
                                $url = 'https://sigelat.web.id/scan/' . $record->kode_barcode;
                                $renderer = new \BaconQrCode\Renderer\ImageRenderer(
                                    new \BaconQrCode\Renderer\RendererStyle\RendererStyle(180),
                                    new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
                                );
                                $writer = new \BaconQrCode\Writer($renderer);
                                $qrSvg = $writer->writeString($url);
                                $base64 = base64_encode($qrSvg);
                                return '<div style="text-align: center; margin-bottom: 1rem;"><img src="data:image/svg+xml;base64,' . $base64 . '" style="width: 180px; height: 180px; margin: 0 auto;" /></div>';
                            }),

                        Actions::make([
                            Action::make('printQr')
                                ->label('Print QR')
                                ->button()
                                ->color('success')
                                ->icon('heroicon-o-printer')
                                ->openUrlInNewTab()
                            // ->url(fn($record) => route('alat.print-qr', $record))
                        ])
                            ->alignment(Alignment::Center)
                            ->fullWidth(),
                    ])
                    ->extraAttributes(['class' => 'backdrop-blur-xl bg-white/5 border border-white/10 rounded-2xl p-6 shadow-lg']),
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
            'index' => ListAlats::route('/'),
            'create' => CreateAlat::route('/create'),
            'edit' => EditAlat::route('/{record}/edit'),
        ];
    }
}
