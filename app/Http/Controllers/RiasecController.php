<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RiasecResult; // Pastikan Model di-import

class RiasecController extends Controller
{
    /**
     * Halaman Pintu Masuk (GATEKEEPER)
     * Mengecek apakah user sudah mengerjakan atau belum.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. CEK DATABASE: Apakah user ini sudah pernah mengerjakan?
        $sudahMengerjakan = RiasecResult::where('user_id', $user->id)->exists();

        // 2. LOGIKA PENGALIHAN
        if ($sudahMengerjakan) {
            // JIKA SUDAH: Langsung tampilkan view 'riasec_finish'
            // Kita tidak perlu redirect ke route '/riasec/selesai' terpisah,
            // cukup render view-nya di sini agar URL tetap '/riasec' tapi isinya halaman selesai.
            return view('riasec_finish', compact('user'));
        }

        // JIKA BELUM: Tampilkan Halaman Instruksi
        return view('riasec', compact('user'));
    }

    /**
     * Halaman Form (Pertanyaan)
     */
    public function form()
    {
        $user = Auth::user();

        // PROTEKSI: Jika user iseng tembak URL /riasec/tes padahal sudah selesai
        $sudahMengerjakan = RiasecResult::where('user_id', $user->id)->exists();
        if ($sudahMengerjakan) {
            return redirect()->route('riasec.index'); // Tendang balik ke index (yang akan menampilkan finish)
        }

        return view('riasec_form', compact('user'));
    }

    /**
     * Proses Simpan Data
     */
    public function store(Request $request)
    {
        // 1. Ambil data jawaban
        $answers = $request->except('_token');

        // 2. Tentukan Nilai Kelas
        $kelasOtomatis = Auth::user()->kelas ?? '-';

        // 3. Simpan ke Database
        RiasecResult::create([
            'user_id' => Auth::id(),
            'kelas'   => $kelasOtomatis,
            'answers' => $answers,
        ]);

        // 4. REDIRECT KE INDEX (PENTING)
        // Kita kembalikan ke route 'riasec.index'.
        // Karena data baru saja disimpan, maka saat method index() dijalankan,
        // ia akan mendeteksi data sudah ada dan otomatis menampilkan view 'riasec_finish'.
        return redirect()->route('riasec.index');
    }

    /**
     * Method finish() opsional.
     * Jika kamu menggunakan logika di index(), method ini sebenarnya tidak dipakai lagi.
     * Tapi boleh dibiarkan jika ingin diakses manual.
     */
    public function finish()
    {
        $user = Auth::user();
        return view('riasec_finish', compact('user'));
    }
}
