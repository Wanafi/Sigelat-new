<?php

namespace App\Filament\Resources\Gelars;

use App\Filament\Resources\Gelars\Pages\CreateGelar;
use App\Filament\Resources\Gelars\Pages\EditGelar;
use App\Filament\Resources\Gelars\Pages\ListGelars;
use App\Filament\Resources\Gelars\Schemas\GelarForm;
use App\Filament\Resources\Gelars\Tables\GelarsTable;
use App\Models\Gelar;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GelarResource extends Resource
{
    protected static ?string $model = Gelar::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Gelar';

    public static function form(Schema $schema): Schema
    {
        return GelarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GelarsTable::configure($table);
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
