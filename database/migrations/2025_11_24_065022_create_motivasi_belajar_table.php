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
    Schema::create('motivasi_belajar', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel users
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        // Kolom untuk menyimpan jawaban (karena banyak soal, kita simpan sebagai JSON)
        $table->json('answers')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motivasi_belajar');
    }
};
