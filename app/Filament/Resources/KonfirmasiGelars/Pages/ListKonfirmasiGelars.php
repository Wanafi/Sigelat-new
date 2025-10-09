<?php

namespace App\Filament\Resources\KonfirmasiGelars\Pages;

use App\Filament\Resources\KonfirmasiGelars\KonfirmasiGelarResource;
use Filament\Resources\Pages\ListRecords;

class ListKonfirmasiGelars extends ListRecords
{
    protected static string $resource = KonfirmasiGelarResource::class;

    public function getTitle(): string
    {
        return 'Konfirmasi Laporan Gelar Alat';
    }
}