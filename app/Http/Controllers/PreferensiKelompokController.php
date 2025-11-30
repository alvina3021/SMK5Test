<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PreferensiKelompok;

class PreferensiKelompokController extends Controller
{
    /**
     * HALAMAN PINTU MASUK (GATEKEEPER)
     * Route: preferensi_kelompok.index
     */
    public function index()
    {
        // 1. RESET SESSION: Bersihkan jika ada sisa session (Best Practice)
        session()->forget(['preferensi_answers']);

        $user = Auth::user();

        // 2. Ambil data terakhir untuk cek status di view
        $result = PreferensiKelompok::where('user_id', $user->id)->latest()->first();

        return view('preferensi_kelompok', compact('user', 'result'));
    }

    /**
     * HALAMAN FORM SOAL
     * Route: preferensi_kelompok.form
     */
    public function form()
    {
        $user = Auth::user();

        // PERBAIKAN LOGIKA "ULANGI TES":
        // Kita HAPUS pengecekan "if (exists) redirect".
        // Agar siswa BISA mengerjakan ulang (Re-take).

        return view('preferensi_kelompok_form', compact('user'));
    }

    /**
     * MENYIMPAN JAWABAN
     * Route: preferensi_kelompok.store
     */
    public function store(Request $request)
    {
        // 1. Ambil data jawaban
        $data = $request->except('_token');

        // 2. Validasi sederhana
        if (empty($data)) {
            return back()->with('error', 'Mohon isi kuesioner terlebih dahulu.');
        }

        // 3. Simpan ke Database (History Baru)
        PreferensiKelompok::create([
            'user_id' => Auth::id(),
            'answers' => $data, // Pastikan model punya $casts = ['answers' => 'array']
        ]);

        // 4. Redirect ke halaman FINISH (Hasil)
        return redirect()->route('preferensi_kelompok.finish')->with('success', 'Tes Preferensi Kelompok berhasil disimpan!');
    }

    /**
     * HALAMAN SELESAI / HASIL
     * Route: preferensi_kelompok.finish
     */
    public function finish()
    {
        $user = Auth::user();

        // Ambil hasil TERBARU (latest)
        $result = PreferensiKelompok::where('user_id', $user->id)->latest()->first();

        // Jika belum ada data, kembalikan ke form
        if (!$result) {
            return redirect()->route('preferensi_kelompok.form');
        }

        // Tampilkan View Hasil
        // Pastikan Anda membuat view 'preferensi_kelompok_result'
        return view('preferensi_kelompok_result', compact('user', 'result'));
    }
}
