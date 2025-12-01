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
        // 1. Tabel Users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();

            // --- KOLOM TAMBAHAN (Sesuai kebutuhan sistem Anda) ---

            // Role: Pembeda antara 'siswa' dan 'guru'
            $table->string('role')->default('siswa');

            // Identitas: Dibuat nullable agar fleksibel
            // Siswa isi NIS (NIP kosong), Guru isi NIP (NIS kosong)
            $table->string('nis')->unique()->nullable();
            $table->string('nip')->unique()->nullable();

            // Data Akademik Siswa (Guru tidak perlu isi ini, jadi nullable)
            $table->string('kelas')->nullable();
            $table->string('jurusan')->nullable();

            // -----------------------------------------------------

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. Tabel Password Reset Tokens (Wajib ada bawaan Laravel)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // 3. Tabel Sessions (PENTING: Jangan dihapus jika SESSION_DRIVER=database)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};


//{
    /**
     * Run the migrations.
     */
    //public function up(): void
    //{
        //Schema::create('users', function (Blueprint $table) {
        //$table->id();
        //$table->string('name'); // Untuk Nama Lengkap
        //$table->string('nis')->unique(); // Tambahan: Untuk NIS (Harus unik)
        //$table->string('email')->unique(); // Untuk Email
        //$table->string('kelas'); // Tambahan: Untuk Kelas (10, 11, 12)
        //$table->string('jurusan'); // Tambahan: Untuk Jurusan (RPL, TKJ, dll)
        //$table->timestamp('email_verified_at')->nullable();
        //$table->string('password'); // Untuk Password
        //$table->rememberToken();
        //$table->timestamps();
    //});

        //Schema::create('password_reset_tokens', function (Blueprint $table) {
            //$table->string('email')->primary();
            //$table->string('token');
            //$table->timestamp('created_at')->nullable();
        //});

        //Schema::create('sessions', function (Blueprint $table) {
           // $table->string('id')->primary();
            //$table->foreignId('user_id')->nullable()->index();
            //$table->string('ip_address', 45)->nullable();
            //$table->text('user_agent')->nullable();
            //$table->longText('payload');
            //$table->integer('last_activity')->index();
        //});
    //}

    /**
     * Reverse the migrations.
     */
    //public function down(): void
    //{
       // Schema::dropIfExists('users');
        //Schema::dropIfExists('password_reset_tokens');
        //Schema::dropIfExists('sessions');
    //}
//};
