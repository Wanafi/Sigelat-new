<?php

namespace App\Filament\Resources\GelarAlats\Tables;

use Filament\Tables\Table;
use App\Models\DetailGelar;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;

class GelarAlatsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    ImageColumn::make('foto_kondisi')
                        ->label('Foto Kondisi')
                        ->rounded()
                        ->size(50)
                        ->disk('public')
                        ->getStateUsing(fn($record) => asset('storage/' . $record->foto))
                        ->url(fn($record) => $record->foto ? asset('storage/' . $record->foto) : null),

                    TextColumn::make('alat.nama_alat')
                        ->label('Nama Alat')
                        ->searchable()
                        ->sortable(),
                ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ]);
    }
}
