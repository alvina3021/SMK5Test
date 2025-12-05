<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkalaPreferensiBelajar extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'skala_preferensi_belajar';

    protected $fillable = [
        'user_id',
        'answers', // Menyimpan jawaban dalam format JSON
    ];

    protected $casts = [
        'answers' => 'array', // Otomatis convert JSON <-> Array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
