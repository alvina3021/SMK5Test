<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotivasiBelajarResult extends Model
{
    use HasFactory;

    // 1. Tentukan nama tabel secara eksplisit (Sesuai Migrasi)
    protected $table = 'motivasi_belajar';

    // 2. Izinkan kolom ini diisi (Mass Assignment)
    protected $fillable = [
        'user_id',
        'answers', // Menyimpan jawaban dalam bentuk JSON
        'score',   // (Opsional) Jika nanti ingin menyimpan total skor
    ];

    // 3. Ubah otomatis JSON di database menjadi Array di PHP
    protected $casts = [
        'answers' => 'array',
    ];

    // 4. Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
