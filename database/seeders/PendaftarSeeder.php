<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PendaftarSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Ahmad Fauzi',
                'tanggal_lahir' => '2008-03-12',
                'telepon_orang_tua' => '081234567890',
                'alamat_pribadi' => 'Jl. Melati No. 12, Nganjuk',
                'tempat_lahir' => 'Nganjuk',
                'nama_sekolah' => 'SMP Negeri 1 Nganjuk',
                'alamat_sekolah' => 'Jl. A. Yani No. 45, Nganjuk',
                'nama_panjang_ortu' => 'Budi Santoso',
                'profesi_ortu' => 'Petani',
                'jenis_kelamin' => 'laki',
                'alamat_ortu' => 'Jl. Melati No. 12, Nganjuk',
                'program_pilihan' => 'reguler',
                'dari_siapa' => 'Teman',
                'is_verified' => true,
            ],
        ];

        $namaDepan = ['Andi','Budi','Citra','Dewi','Eka','Fajar','Gita','Hadi','Intan','Joko'];
        $namaBelakang = ['Santoso','Pratama','Wijaya','Saputra','Lestari','Putri'];
        $sekolah = ['SMP Negeri 1','SMP Negeri 2','MTs Negeri','SMP Islam'];
        $kota = ['Nganjuk','Kediri','Jombang','Tulungagung'];
        $profesi = ['Petani','Wiraswasta','PNS','Guru','Pedagang'];
        $sumber = ['Teman','Media Sosial','Guru','Orang Tua','Banner'];
        $program = ['reguler','intensif'];

        for ($i = 1; $i <= 29; $i++) {
            $data[] = [
                'nama' => $namaDepan[array_rand($namaDepan)] . ' ' . $namaBelakang[array_rand($namaBelakang)],
                'tanggal_lahir' => Carbon::now()->subYears(rand(12, 16))->subDays(rand(1, 365)),
                'telepon_orang_tua' => '08' . rand(1111111111, 9999999999),
                'alamat_pribadi' => 'Jl. Mawar No. ' . rand(1, 100) . ', ' . $kota[array_rand($kota)],
                'tempat_lahir' => $kota[array_rand($kota)],
                'nama_sekolah' => $sekolah[array_rand($sekolah)] . ' ' . $kota[array_rand($kota)],
                'alamat_sekolah' => 'Jl. Pendidikan No. ' . rand(1, 50) . ', ' . $kota[array_rand($kota)],
                'nama_panjang_ortu' => $namaDepan[array_rand($namaDepan)] . ' ' . $namaBelakang[array_rand($namaBelakang)],
                'profesi_ortu' => $profesi[array_rand($profesi)],
                'jenis_kelamin' => rand(0,1) ? 'laki' : 'perempuan',
                'alamat_ortu' => 'Jl. Kenanga No. ' . rand(1, 100) . ', ' . $kota[array_rand($kota)],
                'program_pilihan' => $program[array_rand($program)],
                'dari_siapa' => $sumber[array_rand($sumber)],
                'is_verified' => rand(0,1),
            ];
        }

        DB::table('pendaftars')->insert($data);
    }
}
