<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AumResult extends Model
{
    use HasFactory;

    protected $table = 'aum_results';
    protected $guarded = [];

    // Casting JSON agar otomatis jadi Array saat diambil
    protected $casts = [
    'selected_problems' => 'array',
    'heavy_problems' => 'array',
    'consultation_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
