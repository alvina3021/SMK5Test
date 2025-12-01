<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nis',      // Tambahkan ini
        'role',     // Pastikan role ada
        'nip',      // Pastikan nip ada
        'kelas',    // Tambahkan ini
        'jurusan',  // Tambahkan ini
        'profile_photo_path'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // ==========================================
    // TAMBAHAN RELASI (WAJIB ADA UNTUK DASHBOARD GURU)
    // ==========================================

    /**
     * Relasi ke Tabel SiswaData (Data Pribadi)
     * Satu User (Siswa) bisa punya banyak history pengisian data pribadi
     */
    public function siswaData()
    {
        return $this->hasMany(SiswaData::class, 'user_id');
    }

    /**
     * Relasi ke Tabel RiasecResult
     * Satu User (Siswa) bisa punya banyak history hasil tes RIASEC
     */
    public function riasecResult()
    {
        return $this->hasMany(RiasecResult::class, 'user_id');
    }

    // Jika nanti ada tes lain (AUM, Motivasi, dll), tambahkan juga di sini:
    /*
    public function aumResult()
    {
        return $this->hasMany(AumResult::class, 'user_id');
    }
    */
}
