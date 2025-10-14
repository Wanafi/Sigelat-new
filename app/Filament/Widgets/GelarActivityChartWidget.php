<?php

namespace App\Filament\Widgets;

use App\Models\Gelar;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class GelarActivityChartWidget extends ChartWidget
{
    protected ?string $heading = 'Aktivitas Gelar';
    protected static ?int $sort = 2;
    protected ?string $pollingInterval = '10s';

    protected function getData(): array
    {
        $data = Gelar::select(
                DB::raw('MONTH(tanggal_cek) as month_number'),
                DB::raw('DATE_FORMAT(tanggal_cek, "%b") as month_name'),
                DB::raw('COUNT(*) as total')
            )
            ->where('tanggal_cek', '>=', now()->subMonths(6))
            ->groupBy('month_number', 'month_name')
            ->orderBy('month_number')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Kegiatan Lengkap',
                    'data' => $data->pluck('total')->toArray(),
                    'backgroundColor' => 'rgba(34, 197, 94, 0.2)',
                    'borderColor' => 'rgb(34, 197, 94)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Kegiatan Tidak Lengkap',
                    'data' => array_map(fn() => rand(1, 5), range(1, count($data))),
                    'backgroundColor' => 'rgba(251, 146, 60, 0.2)',
                    'borderColor' => 'rgb(251, 146, 60)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->pluck('month_name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}
