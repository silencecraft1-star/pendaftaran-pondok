<?php

namespace App\Filament\Resources\PendaftarResource\Pages;

use App\Filament\Resources\PendaftarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Exports\Enums\ExportFormat;
use App\Exports\PendaftarExport;
use Filament\Forms\Components\DatePicker;
use Maatwebsite\Excel\Facades\Excel;

class ListPendaftars extends ListRecords
{
    protected static string $resource = PendaftarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Pendaftar')
                ->icon('heroicon-o-plus-circle'),

            Actions\Action::make('export')
                ->label('Export Data Pendaftar')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->form([
                    DatePicker::make('date_from')
                        ->label('Dari Tanggal')
                        ->default(now()->startOfMonth()),

                    DatePicker::make('date_until')
                        ->label('Sampai Tanggal')
                        ->default(now()),
                ])
                ->action(function (array $data) {
                    return Excel::download(
                        new PendaftarExport(
                            $data['date_from'] ?? null,
                            $data['date_until'] ?? null,
                        ),
                        'pendaftar_' . now()->format('Y-m-d') . '.xlsx'
                    );
                })
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // Anda bisa menambahkan widgets di sini
            // Misalnya: PendaftarStats::class,
        ];
    }
}