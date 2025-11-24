<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MotivasiBelajarResult; // Pastikan Model di-import

class MotivasiBelajarController extends Controller
{
    /**
     * HALAMAN PINTU MASUK (GATEKEEPER)
     */
    public function index()
    {
        $user = Auth::user();

        // 1. CEK DATABASE: Apakah user ini sudah mengerjakan?
        $sudahMengerjakan = MotivasiBelajarResult::where('user_id', $user->id)->exists();

        // 2. LOGIKA PENGALIHAN
        if ($sudahMengerjakan) {
            // JIKA SUDAH: Langsung tampilkan view Selesai
            // Pastikan nama view sesuai file yang kamu buat (motivasi_finish.blade.php)
            return view('motivasi_belajar_finish', compact('user'));
        }

        // JIKA BELUM: Tampilkan Halaman Instruksi
        return view('motivasi_belajar', compact('user'));
    }

    /**
     * HALAMAN FORM SOAL
     */
    public function form()
    {
        $user = Auth::user();

        // PROTEKSI: Jika sudah selesai, tendang ke index
        if (MotivasiBelajarResult::where('user_id', $user->id)->exists()) {
             return redirect()->route('motivasi.index');
        }

        return view('motivasi_belajar_form', compact('user'));
    }

    /**
     * MENYIMPAN JAWABAN
     */
    public function store(Request $request)
    {
        // 1. Ambil semua jawaban (kecuali token CSRF)
        $data = $request->except('_token');

        // 2. Simpan ke Database
        // Pastikan model MotivasiBelajarResult sudah memiliki $casts = ['answers' => 'array']
        MotivasiBelajarResult::create([
            'user_id' => Auth::id(),
            'answers' => $data,
            // 'score' => ..., // Tambahkan logika hitung skor di sini jika nanti diperlukan
        ]);

        // 3. REDIRECT KE INDEX
        // Method index() otomatis akan mendeteksi data sudah ada dan menampilkan halaman finish.
        return redirect()->route('motivasi.index');
    }

    /**
     * HALAMAN SELESAI (Opsional)
     */
    public function finish()
    {
        $user = Auth::user();
        return view('motivasi_finish', compact('user'));
    }
}
