<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MotivasiBelajarResult;

class MotivasiBelajarController extends Controller
{
    /**
     * HALAMAN PINTU MASUK (GATEKEEPER/INSTRUKSI)
     * Route: motivasi.index
     */
    public function index()
    {
        // 1. RESET SESSION: Bersihkan sisa data jika ada (Best Practice)
        session()->forget(['motivasi_answers']);

        $user = Auth::user();

        // 2. Ambil data terakhir untuk cek status di view
        // (Misal untuk menampilkan: "Terakhir dikerjakan: 12 Jan 2024")
        $result = MotivasiBelajarResult::where('user_id', $user->id)->latest()->first();

        return view('motivasi_belajar', compact('user', 'result'));
    }

    /**
     * HALAMAN FORM SOAL
     * Route: motivasi.form
     */
    public function form()
    {
        $user = Auth::user();

        // PERBAIKAN LOGIKA "ULANGI TES":
        // Kita HAPUS pengecekan "if (exists) redirect".
        // Tujuannya agar siswa BISA masuk ke sini lagi untuk mengerjakan ulang (Re-take).

        // Form selalu dibuka dalam keadaan bersih karena kita tidak mengirim data jawaban lama.
        return view('motivasi_belajar_form', compact('user'));
    }

    /**
     * MENYIMPAN JAWABAN
     * Route: motivasi.store
     */
    public function store(Request $request)
    {
        // 1. Ambil semua jawaban (kecuali token CSRF)
        $answers = $request->except('_token');

        // 2. Validasi sederhana
        if (empty($answers)) {
            return back()->with('error', 'Mohon isi kuesioner terlebih dahulu.');
        }

        // 3. Simpan ke Database
        // Gunakan CREATE agar tersimpan sebagai History (Riwayat baru).
        // Nanti di TesSayaController, kita ambil yang latest().
        MotivasiBelajarResult::create([
            'user_id' => Auth::id(),
            'answers' => $answers, // Pastikan model punya $casts = ['answers' => 'array']
            // 'kelas' => Auth::user()->kelas ?? '-', // Uncomment jika tabel motivasi punya kolom kelas
        ]);

        // 4. Redirect ke halaman FINISH (Hasil)
        return redirect()->route('motivasi.finish')->with('success', 'Tes Motivasi Belajar berhasil disimpan!');
    }

    /**
     * HALAMAN SELESAI / HASIL
     * Route: motivasi.finish
     */
    public function finish()
    {
        $user = Auth::user();

        // Ambil hasil TERBARU (latest)
        $result = MotivasiBelajarResult::where('user_id', $user->id)->latest()->first();

        // Jika belum ada data (akses paksa URL), kembalikan ke form
        if (!$result) {
            return redirect()->route('motivasi.form');
        }

        // Tampilkan View Hasil
        // Pastikan Anda membuat view 'motivasi_belajar_result' untuk menampilkan skor/interpretasi
        return view('motivasi_belajar_result', compact('user', 'result'));
    }
}
