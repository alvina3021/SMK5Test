<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudiHabitResult;

class StudiHabitController extends Controller
{
    /**
     * HALAMAN PINTU MASUK (GATEKEEPER)
     * Route: studi_habit.index
     */
    public function index()
    {
        // 1. RESET SESSION: Bersihkan session step 1
        session()->forget(['studi_habit_step1']);

        $user = Auth::user();

        // 2. Ambil data terakhir untuk status
        $result = StudiHabitResult::where('user_id', $user->id)->latest()->first();

        return view('studi_habit', compact('user', 'result'));
    }

    /**
     * STEP 1: FORM SOAL KEBIASAAN BELAJAR
     * Route: studi_habit.form
     */
    public function form()
    {
        $user = Auth::user();

        // LOGIKA ULANGI TES: Hapus pengecekan exists() agar bisa re-take.

        return view('studi_habit_form', compact('user'));
    }

    /**
     * PROSES SIMPAN STEP 1 (Ke Session)
     */
    public function store(Request $request)
    {
        $dataStep1 = $request->except('_token');

        // Simpan sementara ke session
        $request->session()->put('studi_habit_step1', $dataStep1);

        // Lanjut ke Step 2
        return redirect()->route('studi_habit.step2');
    }

    /**
     * STEP 2: GAYA BELAJAR
     * Route: studi_habit.step2
     */
    public function step2()
    {
        $user = Auth::user();

        // LOGIKA ULANGI TES: Hapus pengecekan exists().

        // PROTEKSI WAJIB: Harus lewat step 1 dulu
        if (!session()->has('studi_habit_step1')) {
            return redirect()->route('studi_habit.form');
        }

        return view('studi_habit_step2', compact('user'));
    }

    /**
     * PROSES SIMPAN STEP 2 (FINAL - Ke Database)
     */
    public function storeStep2(Request $request)
    {
        $dataStep2 = $request->except('_token');
        $dataStep1 = session()->get('studi_habit_step1');

        // Gabungkan Jawaban
        $allAnswers = array_merge($dataStep1, $dataStep2);

        // Simpan ke Database (Create New History)
        StudiHabitResult::create([
            'user_id' => Auth::id(),
            'answers' => $allAnswers, // Cast array di Model
        ]);

        // Bersihkan Session
        $request->session()->forget('studi_habit_step1');

        // Redirect ke Finish
        return redirect()->route('studi_habit.finish')->with('success', 'Tes Studi Habit berhasil disimpan!');
    }

    /**
     * HALAMAN SELESAI / HASIL
     * Route: studi_habit.finish
     */
    public function finish()
    {
        $user = Auth::user();

        // Ambil hasil TERBARU
        $result = StudiHabitResult::where('user_id', $user->id)->latest()->first();

        if (!$result) {
            return redirect()->route('studi_habit.form');
        }

        // Tampilkan View Hasil
        // Pastikan view 'studi_habit_result' ada
        return view('studi_habit_result', compact('user', 'result'));
    }
}
