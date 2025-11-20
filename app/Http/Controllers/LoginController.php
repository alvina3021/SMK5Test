<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function index()
    {
        return view('login');
    }

    // Memproses login
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'identity' => ['required'], // Bisa NISN atau Email/Username
            'password' => ['required'],
        ]);

        // Coba login (disesuaikan nanti apakah pakai email atau nis)
        // Untuk sementara kita anggap 'identity' adalah email agar cocok dengan tabel user
        if (Auth::attempt(['email' => $request->identity, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('/'); // Redirect ke home setelah sukses
        }

        return back()->withErrors([
            'identity' => 'Detail login tidak valid.',
        ]);
    }
}
