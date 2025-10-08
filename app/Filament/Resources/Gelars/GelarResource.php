<?php

namespace App\Filament\Resources\Gelars;

use UnitEnum;
use BackedEnum;
use App\Models\Alat;
use App\Models\Gelar;
use Filament\Tables\Table;
use App\Models\DetailGelar;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Gelars\Pages\EditGelar;
use App\Filament\Resources\Gelars\Pages\ListGelars;
use App\Filament\Resources\Gelars\Schemas\GelarForm;
use App\Filament\Resources\Gelars\Tables\GelarsTable;
use App\Filament\Resources\GelarResource\Pages\CreateGelar;

class GelarResource extends Resource
{
    protected static ?string $model = Gelar::class;

    protected static string | UnitEnum | null $navigationGroup = 'Manajemen';

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

    public static function afterCreate(Gelar $record): void
    {
        $detailAlats = $record->form->getState()['detail_alats'] ?? [];
        $statusGelar = 'Lengkap';

        foreach ($detailAlats as $alat) {
            if (!isset($alat['alat_id'], $alat['status_alat'])) {
                continue;
            }

            DB::table('detail_gelars')->insert([
                'gelar_id' => $record->id,
                'alat_id' => $alat['alat_id'],
                'status_alat' => $alat['status_alat'],
                'keterangan' => $alat['keterangan'] ?? null,
                'foto_kondisi' => $alat['foto_kondisi'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($alat['status_alat'] === 'Hilang') {
                $statusGelar = 'Tidak Lengkap';
            }

            $alatModel = Alat::find($alat['alat_id']);
            if ($alatModel && $alatModel->status_alat !== $alat['status_alat']) {
                $alatModel->status_alat = $alat['status_alat'];
                $alatModel->save();
            }
        }

        $record->update(['status' => $statusGelar]);
    }

    public static function afterSave(Gelar $record): void
    {
        DB::table('detail_gelars')->where('gelar_id', $record->id)->delete();

        self::afterCreate($record);
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
