<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('siswa_data', function (Blueprint $table) {
            // Tambahkan kolom yang hilang (nullable agar aman)
            // Cek juga apakah no_hp_ayah sudah ada? jika belum tambahkan sekalian

            if (!Schema::hasColumn('siswa_data', 'no_hp_ibu')) {
                $table->string('no_hp_ibu')->nullable()->after('alamat_ibu');
            }

            // Jaga-jaga jika no_hp_ayah juga belum ada
            if (!Schema::hasColumn('siswa_data', 'no_hp_ayah')) {
                $table->string('no_hp_ayah')->nullable()->after('alamat_ayah');
            }
        });
    }

    public function down()
    {
        Schema::table('siswa_data', function (Blueprint $table) {
            $table->dropColumn(['no_hp_ibu', 'no_hp_ayah']);
        });
    }
};
