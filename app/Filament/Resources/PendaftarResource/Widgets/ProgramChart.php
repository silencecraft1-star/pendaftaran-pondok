<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Pendaftar;

use Filament\Widgets\Concerns\InteractsWithPageFilters;

class ProgramChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Presentase Program';

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

        $data = $query->selectRaw('program_pilihan, COUNT(*) as total')
            ->groupBy('program_pilihan')
            ->pluck('total', 'program_pilihan');

        $values = $data->values()->toArray();

        return [
            'labels' => [
                'Reguler',
                'Intensif',
            ],
            'datasets' => [
                [
                    'data' => [
                        $data['reguler'] ?? 0,
                        $data['intensif'] ?? 0,
                    ],
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
