<?php

namespace App\Filament\Resources\GelarAlats\Pages;

use App\Filament\Resources\GelarAlats\GelarAlatResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGelarAlat extends ViewRecord
{
    protected static string $resource = GelarAlatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
