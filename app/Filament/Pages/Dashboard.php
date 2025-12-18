<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Forms\Components\DatePicker;

class Dashboard extends BaseDashboard
{

    protected function getFiltersFormSchema(): array
    {
        return [
            DatePicker::make('from')
                ->label('Dari Tanggal')
                ->maxDate(now()),

            DatePicker::make('until')
                ->label('Sampai Tanggal')
                ->maxDate(now()),
        ];
    }
}