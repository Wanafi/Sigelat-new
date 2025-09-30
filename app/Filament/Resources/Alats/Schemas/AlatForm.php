<?php

namespace App\Filament\Resources\Alats\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AlatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('mobil_id')
                    ->required()
                    ->numeric(),
                TextInput::make('kode_barcode')
                    ->required(),
                TextInput::make('nama_alat')
                    ->required(),
                TextInput::make('kategori_alat')
                    ->required(),
                TextInput::make('merek_alat')
                    ->required(),
                Textarea::make('spesifikasi')
                    ->required()
                    ->columnSpanFull(),
                DatePicker::make('tanggal_masuk')
                    ->required(),
                Select::make('status_alat')
                    ->options(['Baik' => 'Baik', 'Rusak' => 'Rusak', 'Hilang' => 'Hilang'])
                    ->required(),
                TextInput::make('foto'),
            ]);
    }
}
