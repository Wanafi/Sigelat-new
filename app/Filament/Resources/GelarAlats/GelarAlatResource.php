<?php

namespace App\Filament\Resources\GelarAlats;

use App\Filament\Resources\GelarAlats\Pages\CreateGelarAlat;
use App\Filament\Resources\GelarAlats\Pages\EditGelarAlat;
use App\Filament\Resources\GelarAlats\Pages\ListGelarAlats;
use App\Filament\Resources\GelarAlats\Pages\ViewGelarAlat;
use App\Filament\Resources\GelarAlats\Schemas\GelarAlatForm;
use App\Filament\Resources\GelarAlats\Schemas\GelarAlatInfolist;
use App\Filament\Resources\GelarAlats\Tables\GelarAlatsTable;
use App\Models\DetailGelar;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GelarAlatResource extends Resource
{
    protected static ?string $model = DetailGelar::class;
    protected static string | UnitEnum | null $navigationGroup = 'Laporan';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;
    protected static ?string $recordTitleAttribute = 'Gelar Alat';
    public static function form(Schema $schema): Schema
    {
        return GelarAlatForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GelarAlatInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GelarAlatsTable::configure($table);
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
            'index' => ListGelarAlats::route('/'),
            'create' => CreateGelarAlat::route('/create'),
            'view' => ViewGelarAlat::route('/{record}'),
            'edit' => EditGelarAlat::route('/{record}/edit'),
        ];
    }
}
