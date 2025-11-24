<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferensiKelompok extends Model
{
    use HasFactory;

    protected $table = 'preferensi_kelompok';

    protected $fillable = [
        'user_id',
        'answers',
    ];

    protected $casts = [
        'answers' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
