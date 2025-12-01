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
            'identity' => ['required'], // Bisa NISN, NIP, atau Email
            'password' => ['required'],
        ]);

        // Coba login dengan berbagai kemungkinan identitas
        // 1. Email (Umum)
        // 2. NIS (Siswa)
        // 3. NIP (Guru)
        if (Auth::attempt(['email' => $request->identity, 'password' => $request->password]) ||
            Auth::attempt(['nis' => $request->identity, 'password' => $request->password]) ||
            Auth::attempt(['nip' => $request->identity, 'password' => $request->password])) {

            $request->session()->regenerate();

            // --- LOGIKA PENGECEKAN ROLE ---
            $user = Auth::user();

            // 1. Jika Role adalah GURU -> Arahkan ke Dashboard Guru
            if ($user->role === 'guru') {
                return redirect()->route('guru.dashboard');
            }

            // 2. Jika Role adalah SISWA (Default) -> Arahkan ke Dashboard Siswa
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'identity' => 'Detail login tidak valid.',
        ])->onlyInput('identity');
    }

    // Memproses logout (FUNGSI BARU)
    public function logout(Request $request)
    {
        // 1. Logout user dari facade Auth
        Auth::logout();

        // 2. Invalidate session (menghapus data sesi saat ini agar tidak bisa dipakai lagi)
        $request->session()->invalidate();

        // 3. Regenerate CSRF token (untuk keamanan form selanjutnya)
        $request->session()->regenerateToken();

        // 4. Redirect ke halaman login (atau halaman utama)
        return redirect()->route('login');
    }
}
