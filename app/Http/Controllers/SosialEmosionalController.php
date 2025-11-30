<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SosialEmosionalResult;

class SosialEmosionalController extends Controller
{
    /**
     * HALAMAN PINTU MASUK (GATEKEEPER)
     * Route: sosial_emosional.index
     */
    public function index()
    {
        // 1. RESET SESSION: Bersihkan session step 1 agar mulai dari awal
        session()->forget(['sosial_emosional_step1']);

        $user = Auth::user();

        // 2. Ambil data terakhir untuk status
        $result = SosialEmosionalResult::where('user_id', $user->id)->latest()->first();

        return view('sosial_emosional', compact('user', 'result'));
    }

    /**
     * STEP 1: FORM DATA SOSIAL & EMOSIONAL
     * Route: sosial_emosional.form
     */
    public function form()
    {
        $user = Auth::user();

        // LOGIKA ULANGI TES: Hapus pengecekan exists() agar bisa re-take.

        return view('sosial_emosional_form', compact('user'));
    }

    /**
     * PROSES SIMPAN STEP 1 (Ke Session)
     */
    public function store(Request $request)
    {
        $dataStep1 = $request->except('_token');

        // Simpan sementara ke session
        $request->session()->put('sosial_emosional_step1', $dataStep1);

        // Lanjut ke Step 2
        return redirect()->route('sosial_emosional_step2');
    }

    /**
     * STEP 2: KESEHATAN MENTAL
     * Route: sosial_emosional.step2
     */
    public function step2()
    {
        $user = Auth::user();

        // LOGIKA ULANGI TES: Hapus pengecekan exists().

        // PROTEKSI WAJIB: Harus lewat step 1 dulu
        if (!session()->has('sosial_emosional_step1')) {
            return redirect()->route('sosial_emosional.form');
        }

        return view('sosial_emosional_step2', compact('user'));
    }

    /**
     * PROSES SIMPAN STEP 2 (FINAL - Ke Database)
     */
    public function storeStep2(Request $request)
    {
        $dataStep2 = $request->except('_token');
        $dataStep1 = session()->get('sosial_emosional_step1');

        // Gabungkan Jawaban
        $allAnswers = array_merge($dataStep1, $dataStep2);

        // Simpan ke Database (Create New History)
        SosialEmosionalResult::create([
            'user_id' => Auth::id(),
            'answers' => $allAnswers, // Cast array di Model
        ]);

        // Bersihkan Session
        $request->session()->forget('sosial_emosional_step1');

        // Redirect ke Finish
        return redirect()->route('sosial_emosional.finish')->with('success', 'Tes Sosial Emosional berhasil disimpan!');
    }

    /**
     * HALAMAN SELESAI / HASIL
     * Route: sosial_emosional.finish
     */
    public function finish()
    {
        $user = Auth::user();

        // Ambil hasil TERBARU
        $result = SosialEmosionalResult::where('user_id', $user->id)->latest()->first();

        if (!$result) {
            return redirect()->route('sosial_emosional.form');
        }

        // Tampilkan View Hasil
        // Pastikan view 'sosial_emosional_result' ada
        return view('sosial_emosional_result', compact('user', 'result'));
    }
}
