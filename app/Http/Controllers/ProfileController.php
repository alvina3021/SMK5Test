<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    // Menampilkan Halaman Profil
    public function index()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    // Mengupdate Foto Profil
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika bukan default (opsional, jika Anda menyimpan path default)
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Simpan foto baru
            $path = $request->file('photo')->store('profile-photos', 'public');

            // Update database (Pastikan kolom 'profile_photo_path' ada di tabel users atau sesuaikan)
            // Jika belum ada kolom khusus, kita bisa sementara simpan di kolom lain atau buat migrasi baru.
            // Di sini saya asumsikan kita update ke tabel User.
            // *Catatan: Anda mungkin perlu menambahkan 'profile_photo_path' ke fillable di User model.*

            /** @var \App\Models\User $user */
            $user->forceFill([
                'profile_photo_path' => $path,
            ])->save();
        }

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}
