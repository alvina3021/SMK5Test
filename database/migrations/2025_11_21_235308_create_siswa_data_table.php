<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa_data', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users (akun siswa)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // --- STEP 1: DATA DIRI ---
            $table->string('kelas')->nullable();
            $table->string('nama_lengkap')->nullable(); // Snapshot nama saat pengisian
            $table->string('foto_profil_path');
            $table->string('jenis_kelamin');
            $table->string('agama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('status_anak'); // Kandung/Angkat
            $table->integer('anak_ke');
            $table->integer('jumlah_saudara');
            $table->string('status_orang_tua'); // Lengkap/Cerai/Yatim
            $table->string('uang_saku'); // Range string
            $table->json('bantuan_pemerintah'); // Disimpan sebagai JSON array karena checkbox
            $table->string('foto_kartu_bantuan_path')->nullable();
            $table->text('alamat');
            $table->string('kepemilikan_rumah');
            $table->string('no_hp');
            $table->text('hobi');
            $table->text('kelebihan');
            $table->text('kelemahan');

            // --- STEP 2: DATA AYAH ---
            $table->string('nama_ayah');
            $table->string('status_ayah'); // Hidup/Almarhum
            $table->string('pendidikan_ayah');
            $table->string('pekerjaan_ayah');
            $table->string('gaji_ayah');
            $table->text('alamat_ayah')->nullable();
            $table->string('no_hp_ayah');

            // Tambahan (Opsional untuk pengembangan masa depan jika ada Data Ibu)
            $table->string('nama_ibu');
            $table->string('status_ibu'); // Hidup/Almarhum
            $table->string('pendidikan_ibu');
            $table->string('pekerjaan_ibu');
            $table->string('gaji_ibu');
            $table->text('alamat_ibu')->nullable();
            $table->string('no_hp_ibu')->nullable();

            // --- STEP 3: WALI (OPSIONAL / NULLABLE) ---
            // Kita gunakan ->nullable() agar database tidak error jika dikosongi.
            $table->string('nama_wali')->nullable();
            $table->text('alamat_wali')->nullable();
            $table->string('pendidikan_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('penghasilan_wali')->nullable();
            $table->string('no_hp_wali')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa_data');
    }
};
