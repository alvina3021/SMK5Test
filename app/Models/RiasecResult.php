<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiasecResult extends Model
{
    protected $fillable = [
        'user_id',
        'kelas',
        'answers',
    ];

    // Pastikan casting ini ada agar array jawaban otomatis jadi JSON saat masuk DB
    protected $casts = [
        'answers' => 'array',
    ];

    /**
     * Relasi ke Model User
     * Setiap hasil tes dimiliki oleh satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
