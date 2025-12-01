<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Guru (Wajib ada NIP, NIS & Kelas Null)
        User::create([
            'name' => 'Bapak Guru BK',
            'email' => 'guru@smkn5malang.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'guru',
            'nip' => '198001012000121001', // Data NIP Guru
            'nis' => null,
            'kelas' => null,
            'jurusan' => null,
        ]);

        // 2. Akun Siswa (Wajib ada NIS & Kelas, NIP Null)
        User::create([
            'name' => 'Siswa Contoh',
            'email' => 'siswa@smkn5malang.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
            'nip' => null,
            'nis' => '12345678', // Data NIS Siswa
            'kelas' => 'XII RPL 1',
            'jurusan' => 'RPL',
        ]);
    }
}
