<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaData extends Model
{
    use HasFactory;

    protected $table = 'siswa_data'; // Sesuaikan dengan nama tabel Anda

    // Gunakan guarded kosong agar SEMUA kolom bisa diisi (Mass Assignment)
    protected $guarded = [];

    // Opsi alternatif jika ingin manual (pilih salah satu, tapi guarded lebih mudah)
    // protected $fillable = [
    //     'user_id', 'nama_lengkap', 'kelas', 'nama_wali', 'alamat_wali', ...
    // ];


    /**
     * Menghubungkan data siswa ke tabel User (Relasi One-to-One)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
