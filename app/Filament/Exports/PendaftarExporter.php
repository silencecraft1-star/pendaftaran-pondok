<?php

namespace App\Filament\Exports;

use App\Models\Pendaftar;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\Builder;

class PendaftarExporter extends Exporter
{
    protected static ?string $model = Pendaftar::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('nama'),
            ExportColumn::make('tanggal_lahir'),
            ExportColumn::make('telepon_orang_tua'),
            ExportColumn::make('alamat_pribadi'),
            ExportColumn::make('tempat_lahir'),
            ExportColumn::make('nama_sekolah'),
            ExportColumn::make('alamat_sekolah'),
            ExportColumn::make('nama_panjang_ortu'),
            ExportColumn::make('profesi_ortu'),
            ExportColumn::make('jenis_kelamin'),
            ExportColumn::make('alamat_ortu'),
            ExportColumn::make('program_pilihan'),
            ExportColumn::make('dari_siapa'),
            ExportColumn::make('is_verified'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }


    public static function modifyQuery(Builder $query): Builder
    {
        $data = request()->all();

        return $query
            ->when(
                $data['date_from'] ?? null,
                fn($q, $from) => $q->whereDate('created_at', '>=', $from)
            )
            ->when(
                $data['date_until'] ?? null,
                fn($q, $until) => $q->whereDate('created_at', '<=', $until)
            );
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your pendaftar export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
