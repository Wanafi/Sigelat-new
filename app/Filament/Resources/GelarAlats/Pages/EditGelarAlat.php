<?php

namespace App\Filament\Resources\GelarAlats\Pages;

use App\Filament\Resources\GelarAlats\GelarAlatResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditGelarAlat extends EditRecord
{
    protected static string $resource = GelarAlatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
