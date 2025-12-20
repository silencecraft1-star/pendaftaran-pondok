<?php

namespace App\Exports;

use App\Models\Pendaftar;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class PendaftarExport implements
    FromQuery,
    WithHeadings,
    WithMapping
{
   use Exportable;

    protected ?string $dateFrom;
    protected ?string $dateUntil;

    public function __construct(?string $dateFrom = null, ?string $dateUntil = null)
    {
        $this->dateFrom  = $dateFrom;
        $this->dateUntil = $dateUntil;
    }

    /**
     * Setara dengan modifyQuery() di Filament Exporter
     */
    public function query(): Builder
    {
        return Pendaftar::query()
            ->when(
                $this->dateFrom,
                fn ($q) => $q->whereDate('created_at', '>=', $this->dateFrom)
            )
            ->when(
                $this->dateUntil,
                fn ($q) => $q->whereDate('created_at', '<=', $this->dateUntil)
            );
    }

    /**
     * Heading Excel
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Tanggal Lahir',
            'Telepon Orang Tua',
            'Alamat Pribadi',
            'Tempat Lahir',
            'Nama Sekolah',
            'Alamat Sekolah',
            'Nama Panjang Ortu',
            'Profesi Ortu',
            'Jenis Kelamin',
            'Alamat Ortu',
            'Program Pilihan',
            'Dari Siapa',
            'Terverifikasi',
            'Dibuat Pada',
            'Diupdate Pada',
        ];
    }

    /**
     * Mapping kolom (setara ExportColumn)
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->nama,
            $row->tanggal_lahir,
            $row->telepon_orang_tua,
            $row->alamat_pribadi,
            $row->tempat_lahir,
            $row->nama_sekolah,
            $row->alamat_sekolah,
            $row->nama_panjang_ortu,
            $row->profesi_ortu,
            $row->jenis_kelamin,
            $row->alamat_ortu,
            $row->program_pilihan,
            $row->dari_siapa,
            $row->is_verified ? 'Ya' : 'Tidak',
            optional($row->created_at)->format('d-m-Y H:i'),
            optional($row->updated_at)->format('d-m-Y H:i'),
        ];
    }
}
