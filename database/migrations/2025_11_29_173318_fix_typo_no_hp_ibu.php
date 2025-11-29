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
    Schema::table('siswa_data', function (Blueprint $table) {
        // Hapus kolom typo jika ada
        if (Schema::hasColumn('siswa_data', 'no_hp_ibi')) {
            $table->dropColumn('no_hp_ibi');
        }
        // Tambahkan kolom yang benar jika belum ada
        if (!Schema::hasColumn('siswa_data', 'no_hp_ibu')) {
            $table->string('no_hp_ibu')->nullable();
        } else {
            // Jika sudah ada, pastikan dia nullable
            $table->string('no_hp_ibu')->nullable()->change();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa_data', function (Blueprint $table) {
            //
        });
    }
};
