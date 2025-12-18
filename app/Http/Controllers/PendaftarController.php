<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use Exception;
use Illuminate\Http\Request;

class PendaftarController extends Controller
{
    //
    public function store(Request $request) {

        try {
            $data = [
                "nama" => $request->input('nama'),
                "tanggal_lahir" => $request->input('tanggalLahir'),
                "telepon_orang_tua" => $request->input('teleponOrangTua'),
                "alamat_pribadi" => $request->input('alamatPribadi'),
                "tempat_lahir" => $request->input('tempatLahir'),
                "nama_sekolah" => $request->input('namaSekolah'),
                "alamat_sekolah" => $request->input('alamatSekolah'),
                "nama_panjang_ortu" => $request->input('namaPanjangOrtu'),
                "profesi_ortu" => $request->input('profesiOrtu'),
                "jenis_kelamin" => $request->input('jenisKelamin'),
                "alamat_ortu" => $request->input('alamatOrtu'),
                "program_pilihan" => $request->input('programPilihan'),
                "dari_siapa" => $request->input('dariSiapa'),
            ];
            Pendaftar::create($data);

            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
