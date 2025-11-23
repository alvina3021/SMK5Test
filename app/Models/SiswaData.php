<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaData extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit (opsional tapi disarankan)
    protected $table = 'siswa_data';

    // Field yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'user_id',
        // Step 1
        'kelas',
        'nama_lengkap',
        'foto_profil_path',
        'jenis_kelamin',
        'agama',
        'tempat_lahir',
        'tanggal_lahir',
        'status_anak',
        'anak_ke',
        'jumlah_saudara',
        'status_orang_tua',
        'uang_saku',
        'bantuan_pemerintah',
        'foto_kartu_bantuan_path',
        'alamat',
        'kepemilikan_rumah',
        'no_hp',
        'hobi',
        'kelebihan',
        'kelemahan',
        // Step 2 (Ayah)
        'nama_ayah',
        'status_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'gaji_ayah',
        'alamat_ayah',
        'no_hp_ayah',
    ];

    // Mengubah format data secara otomatis
    protected $casts = [
        'bantuan_pemerintah' => 'array', // Otomatis ubah JSON di DB jadi Array di PHP
        'tanggal_lahir' => 'date',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
