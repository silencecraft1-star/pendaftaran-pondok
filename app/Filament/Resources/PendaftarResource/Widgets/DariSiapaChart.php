<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Pendaftar;

use Filament\Widgets\Concerns\InteractsWithPageFilters;

class DariSiapaChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Presentase Sumber Informasi';

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $query = Pendaftar::query();

        if ($this->filters['from'] ?? null) {
            $query->whereDate('created_at', '>=', $this->filters['from']);
        }

        if ($this->filters['until'] ?? null) {
             $query->whereDate('created_at', '<=', $this->filters['until']);
        }

        $data = $query->selectRaw('dari_siapa, COUNT(*) as total')
            ->whereNotNull('dari_siapa')
            ->groupBy('dari_siapa')
            ->pluck('total', 'dari_siapa');

        $values = $data->values()->toArray();


        return [
            'labels' => $data->keys()->toArray(),
            'datasets' => [
                [
                    'data' => $data->values()->toArray(),
                    'backgroundColor' => $this->generateColors(count($values)),
                ],
            ],
        ];
    }

    protected function generateColors(int $count): array
    {
        if ($count <= 0) {
            return [];
        }

        $colors = [
            'hsl(117, 99%, 29%)',
        ];

        // sisa warna
        for ($i = 1; $i < $count; $i++) {
            $colors[] = sprintf(
                'hsl(%d, 99%%, 29%%)',
                (($i - 1) * 360 / max($count - 1, 1))
            );
        }

        return $colors;
    }
}

