<?php

namespace App\Filament\Resources\GelarResource\Pages;

use App\Filament\Resources\GelarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGelars extends ListRecords
{
    protected static string $resource = GelarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
