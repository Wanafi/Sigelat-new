<?php

namespace App\Filament\Widgets;

use App\Models\Alat;
use App\Models\Gelar;
use App\Models\Mobil;
use App\Models\DetailGelar;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        return [
            Stat::make('Total Alat', Alat::count())
                ->description('Jumlah seluruh alat terdaftar')
                ->descriptionIcon('heroicon-o-wrench')
                ->color('success'),

            Stat::make('Total Mobil', Mobil::count())
                ->description('Jumlah armada terdaftar')
                ->descriptionIcon('heroicon-o-truck')
                ->color('info'),

            Stat::make('Kegiatan Gelar Alat', Gelar::count())
                ->description('Total kegiatan pemeriksaan')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('primary'),

            Stat::make('Dokumentasi Foto', DetailGelar::whereNotNull('foto_kondisi')->count())
                ->description('Foto dokumentasi tersimpan')
                ->descriptionIcon('heroicon-m-camera')
                ->color('danger'),
        ];
    }
}