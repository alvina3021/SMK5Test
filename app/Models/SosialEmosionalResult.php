<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SosialEmosionalResult extends Model
{
    use HasFactory;

    protected $table = 'sosial_emosional';

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
