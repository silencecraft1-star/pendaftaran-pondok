<?php

namespace App\Filament\Widgets;

use App\Models\Pendaftar;
use Filament\Widgets\ChartWidget;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\DatePicker;

use Filament\Widgets\Concerns\InteractsWithPageFilters;

class PendaftarChart extends ChartWidget implements HasForms
{
    use InteractsWithForms;
    use InteractsWithPageFilters;


    protected static ?string $heading = 'Tren Pendaftaran';

    protected function getData(): array
    {
        $query = Pendaftar::query();

        if ($this->filters['from'] ?? null) {
            $query->whereDate('created_at', '>=', $this->filters['from']);
        }

        if ($this->filters['until'] ?? null) {
            $query->whereDate('created_at', '<=', $this->filters['until']);
        }

        $data = $query
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Pendaftar',
                    'data' => $data->pluck('total'),
                ],
            ],
            'labels' => $data->pluck('date'),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }


}
