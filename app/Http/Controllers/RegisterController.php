<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi Input
        // Jika validasi ini gagal (misal NIS duplikat),
        // sistem otomatis kembali ke halaman daftar (tidak lanjut ke bawah).
        $request->validate([
            'name'     => 'required|string|max:255',
            'nis'      => 'required|string|unique:users', // Pastikan NIS belum dipakai
            'email'    => 'required|email|unique:users', // Pastikan Email belum dipakai
            'kelas'    => 'required',
            'jurusan'  => 'required',
            'password' => 'required|min:6', // Password minimal 6 karakter
        ]);

        // 2. Simpan Data User Baru
        User::create([
            'name'     => $request->name,
            'nis'      => $request->nis,
            'email'    => $request->email,
            'kelas'    => $request->kelas,
            'jurusan'  => $request->jurusan,
            'password' => Hash::make($request->password),
        ]);

        // 3. REDIRECT KE HALAMAN LOGIN
        // Menggunakan route('login') agar user diarahkan untuk masuk setelah daftar
        return redirect()->route('login')->with('success', 'Pendaftaran Berhasil! Silakan login dengan akun Anda.');
    }
}
