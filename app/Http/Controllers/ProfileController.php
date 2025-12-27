<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SiswaData;
use Illuminate\Support\Facades\File; // Tambahkan ini untuk manajemen file

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_profil_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // --- LOKASI PENYIMPANAN ---
            // Kita taruh di public/storage/app/public/uploads/profil
            // Supaya cocok dengan panggilan asset('storage/app/public/...') di dashboard
            $destinationPath = public_path('app/public/uploads/profil');

            // Buat folder jika belum ada
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // --- HAPUS FOTO LAMA ---
            if ($user->profile_photo_path) {
                // Path fisik file lama
                $oldFile = public_path('app/public/' . $user->profile_photo_path);
                
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }

			// --- 3. SIMPAN FOTO BARU ---
            $file->move($destinationPath, $filename);

            // Path yang akan disimpan di Database
            $dbPath = 'uploads/profil/' . $filename;

            // --- 4. UPDATE TABEL USERS ---
            $user->forceFill([
                'profile_photo_path' => $dbPath,
            ])->save();

            // --- 5. SINKRONISASI KE TABEL SISWA_DATA (PENTING) ---
            // Jika user ini sudah punya data di siswa_data, update juga fotonya disana
            // agar data form pendaftaran dan data akun tetap sama.
            $siswaData = SiswaData::where('user_id', $user->id)->first();
            if ($siswaData) {
                $siswaData->update([
                    'foto_profil_path' => $dbPath
                ]);
            }
        }

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}