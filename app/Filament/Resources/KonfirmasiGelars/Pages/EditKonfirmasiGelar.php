<?php

namespace App\Filament\Resources\KonfirmasiGelars\Pages;

use App\Filament\Resources\KonfirmasiGelars\KonfirmasiGelarResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKonfirmasiGelar extends EditRecord
{
    protected static string $resource = KonfirmasiGelarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
