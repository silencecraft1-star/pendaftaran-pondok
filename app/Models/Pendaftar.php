<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Pendaftar extends Model
{
    //

    use Notifiable;
    protected $table = "pendaftars";

    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'telepon_orang_tua',
        'alamat_pribadi',
        'tempat_lahir',
        'nama_sekolah',
        'alamat_sekolah',
        'nama_panjang_ortu',
        'profesi_ortu',
        'jenis_kelamin',
        'alamat_ortu',
        'program_pilihan',
        'dari_siapa',
        'is_verified',
    ];

}
