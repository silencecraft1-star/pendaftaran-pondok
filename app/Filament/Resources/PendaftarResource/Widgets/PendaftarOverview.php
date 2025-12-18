<?php

namespace App\Filament\Widgets;

use App\Models\Pendaftar;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;

use Filament\Widgets\Concerns\InteractsWithPageFilters;

class PendaftarOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Pendaftar', $this->query()->count())
                ->icon('heroicon-o-users')
                ->color('primary'),

            Stat::make('Terverifikasi', $this->query()->where('is_verified', true)->count())
                ->icon('heroicon-o-check-circle')
                ->color('success'),


            Stat::make(
                'Laki-laki',
                $this->query()->where('jenis_kelamin', 'laki')->count()
            )
                ->icon('heroicon-o-user')
                ->color('info'),

            Stat::make(
                'Perempuan',
                $this->query()->where('jenis_kelamin', 'perempuan')->count()
            )
                ->icon('heroicon-o-user')
                ->color('pink'),
        ];
    }

    protected function query(): Builder
    {
        return Pendaftar::query()
            ->when(
                $this->filters['from'] ?? null,
                fn($q, $date) =>
                $q->whereDate('created_at', '>=', $date)
            )
            ->when(
                $this->filters['until'] ?? null,
                fn($q, $date) =>
                $q->whereDate('created_at', '<=', $date)
            );
    }


}
