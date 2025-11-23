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
            $table->string('foto_profil_path')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('agama')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('status_anak')->nullable(); // Kandung/Angkat
            $table->integer('anak_ke')->nullable();
            $table->integer('jumlah_saudara')->nullable();
            $table->string('status_orang_tua')->nullable(); // Lengkap/Cerai/Yatim
            $table->string('uang_saku')->nullable(); // Range string
            $table->json('bantuan_pemerintah')->nullable(); // Disimpan sebagai JSON array karena checkbox
            $table->string('foto_kartu_bantuan_path')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kepemilikan_rumah')->nullable();
            $table->string('no_hp')->nullable();
            $table->text('hobi')->nullable();
            $table->text('kelebihan')->nullable();
            $table->text('kelemahan')->nullable();

            // --- STEP 2: DATA AYAH ---
            $table->string('nama_ayah')->nullable();
            $table->string('status_ayah')->nullable(); // Hidup/Almarhum
            $table->string('pendidikan_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('gaji_ayah')->nullable();
            $table->text('alamat_ayah')->nullable();
            $table->string('no_hp_ayah')->nullable();

            // Tambahan (Opsional untuk pengembangan masa depan jika ada Data Ibu)
            // $table->string('nama_ibu')->nullable();
            // ... dst

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa_data');
    }
};
