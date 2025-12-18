<?php

namespace App\Filament\Resources\PendaftarResource\Pages;

use App\Filament\Resources\PendaftarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Exports\Enums\ExportFormat;
use App\Filament\Exports\PendaftarExporter;
use Filament\Forms\Components\DatePicker;

class ListPendaftars extends ListRecords
{
    protected static string $resource = PendaftarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Pendaftar')
                ->icon('heroicon-o-plus-circle'),

            Actions\ExportAction::make()
                ->exporter(PendaftarExporter::class)
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->columnMapping(false)
                ->formats([
                    ExportFormat::Xlsx,
                    ExportFormat::Csv,
                ])
                ->form([
                    DatePicker::make('date_from')
                        ->label('Dari Tanggal')
                        ->default(now()->startOfMonth()),

                    DatePicker::make('date_until')
                        ->label('Sampai Tanggal')
                        ->default(now()),
                ])
        ];
    }

    private function exportToExcel()
    {
        // Implementasi export ke Excel
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // Anda bisa menambahkan widgets di sini
            // Misalnya: PendaftarStats::class,
        ];
    }
}