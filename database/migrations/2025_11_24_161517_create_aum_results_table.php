<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('aum_results', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->json('selected_problems'); // Menyimpan ID masalah Langkah 1 (Array JSON)
        $table->json('heavy_problems')->nullable(); // Menyimpan ID masalah berat Langkah 2
        $table->json('consultation_data')->nullable(); // Menyimpan jawaban Langkah 3 (A,B,C,D)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aum_results');
    }
};
