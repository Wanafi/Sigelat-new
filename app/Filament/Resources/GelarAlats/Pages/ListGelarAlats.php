<?php

namespace App\Filament\Resources\GelarAlats\Pages;

use App\Filament\Resources\GelarAlats\GelarAlatResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGelarAlats extends ListRecords
{
    protected static string $resource = GelarAlatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
