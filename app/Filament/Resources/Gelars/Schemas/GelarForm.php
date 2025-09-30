<?php

namespace App\Filament\Resources\Gelars\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class GelarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('mobil_id')
                    ->required()
                    ->numeric(),
                Textarea::make('pelaksana')
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(['Lengkap' => 'Lengkap', 'Tidak Lengkap' => 'Tidak lengkap'])
                    ->required(),
                DatePicker::make('tanggal_cek')
                    ->required(),
            ]);
    }
}
