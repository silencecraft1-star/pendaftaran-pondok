<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Pendaftar;

use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;

class JenisKelaminChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Presentase Jenis Kelamin';

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

        $data = $query->selectRaw('jenis_kelamin, COUNT(*) as total')
            ->groupBy('jenis_kelamin')
            ->pluck('total', 'jenis_kelamin');

        $values = $data->values()->toArray();

        return [
            'labels' => [
                'Laki-laki',
                'Perempuan',
            ],
            'datasets' => [
                [
                    'data' => [
                        $data['laki'] ?? 0,
                        $data['perempuan'] ?? 0,
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
