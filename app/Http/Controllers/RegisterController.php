<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'kelas' => 'required',
            'jurusan' => 'required',
            'password' => 'required|min:6',
        ]);

        // Simpan
        User::create([
            'name' => $request->name,
            'nis' => $request->nis,
            'email' => $request->email,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'password' => Hash::make($request->password),
        ]);

        // Redirect (Ganti '/' dengan rute tujuan setelah sukses)
        return redirect('/')->with('success', 'Pendaftaran Berhasil!');
    }
}
