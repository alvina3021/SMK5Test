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
        Schema::create('riasec_results', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel users (Foreign Key)
            // onDelete('cascade') berarti jika user dihapus, hasil tesnya juga terhapus
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('kelas');

            // Tipe data JSON untuk menyimpan jawaban dinamis (ans_r_1, ans_s_2, dll)
            // Ini lebih fleksibel daripada membuat ratusan kolom
            $table->json('answers');

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riasec_results');
    }
};
