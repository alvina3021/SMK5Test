<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudiHabitResult extends Model
{
    use HasFactory;

    protected $table = 'studi_habit';

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
