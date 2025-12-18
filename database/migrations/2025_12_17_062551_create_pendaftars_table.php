<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftars', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->string('telepon_orang_tua');
            $table->text('alamat_pribadi');
            $table->string('tempat_lahir');
            $table->string('nama_sekolah');
            $table->text('alamat_sekolah');
            $table->string('nama_panjang_ortu');
            $table->string('profesi_ortu');
            $table->string('jenis_kelamin');
            $table->text('alamat_ortu');
            $table->string('program_pilihan');
            $table->string('dari_siapa');
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftars');
    }
};
