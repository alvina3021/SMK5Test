<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaData extends Model
{
    use HasFactory;

    protected $table = 'siswa_data'; // Pastikan nama tabel sesuai migrasi

    // Gunakan guarded kosong agar semua kolom bisa diisi (mass assignment)
    protected $guarded = [];

    /**
     * Casting tipe data
     * 'bantuan_pemerintah' -> array (agar otomatis decode JSON)
     */
    protected $casts = [
        'bantuan_pemerintah' => 'array',
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
