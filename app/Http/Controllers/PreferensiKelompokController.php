<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PreferensiKelompok; // Pastikan Model di-import dengan benar

class PreferensiKelompokController extends Controller
{
    /**
     * HALAMAN PINTU MASUK (GATEKEEPER)
     * Logika: Cek DB -> Jika ada ke Finish -> Jika tidak ke Instruksi
     */
    public function index()
    {
        $user = Auth::user();

        // 1. CEK DATABASE: Apakah user ini sudah mengerjakan?
        $sudahMengerjakan = PreferensiKelompok::where('user_id', $user->id)->exists();

        // 2. LOGIKA PENGALIHAN
        if ($sudahMengerjakan) {
            // JIKA SUDAH: Langsung tampilkan view Selesai
            return view('preferensi_kelompok_finish', compact('user'));
        }

        // JIKA BELUM: Tampilkan Halaman Instruksi
        return view('preferensi_kelompok', compact('user'));
    }

    /**
     * HALAMAN FORM SOAL
     */
    public function form()
    {
        $user = Auth::user();

        // PROTEKSI: Jika sudah selesai, tendang balik ke index
        if (PreferensiKelompok::where('user_id', $user->id)->exists()) {
             return redirect()->route('preferensi_kelompok.index');
        }

        return view('preferensi_kelompok_form', compact('user'));
    }

    /**
     * MENYIMPAN JAWABAN
     */
    public function store(Request $request)
    {
        // 1. Ambil data jawaban (kecuali token)
        $data = $request->except('_token');

        // 2. Simpan ke Database
        // Pastikan model PreferensiKelompok memiliki properti $fillable dan $casts yang benar
        PreferensiKelompok::create([
            'user_id' => Auth::id(),
            'answers' => $data,
        ]);

        // 3. REDIRECT KE INDEX
        // Method index() akan otomatis mendeteksi data sudah ada dan menampilkan halaman finish.
        return redirect()->route('preferensi_kelompok.index');
    }

    /**
     * HALAMAN SELESAI (Opsional)
     */
    public function finish()
    {
        $user = Auth::user();
        return view('preferensi_kelompok_finish', compact('user'));
    }
}
