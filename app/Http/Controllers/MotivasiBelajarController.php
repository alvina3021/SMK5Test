<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MotivasiBelajarController extends Controller
{
    /**
     * Menampilkan halaman instruksi (Landing Page Motivasi Belajar).
     */
    public function index()
    {
        $user = Auth::user();
        // Mengirim data user untuk keperluan navbar (nama & inisial)
        return view('motivasi_belajar', compact('user'));
    }

    /**
     * Menampilkan halaman form soal (Placeholder untuk langkah selanjutnya).
     */

    // 1. Menampilkan Form Soal
    public function form()
    {
        $user = Auth::user();
        return view('motivasi_belajar_form', compact('user'));
    }

    // 2. Menyimpan Jawaban
    public function store(Request $request)
    {
        // Validasi sederhana (opsional, karena radio button required)
        // $request->validate([...]);

        $data = $request->except('_token');

        // Contoh logika penyimpanan (sesuaikan dengan Model Anda nanti)
        /*
        MotivasiResult::create([
            'user_id' => Auth::id(),
            'answers' => $data,
            'score'   => ..., // Bisa dihitung total skornya di sini
        ]);
        */

        // Redirect ke halaman selesai
        return redirect()->route('motivasi.finish');
    }

    // 3. Halaman Selesai
    public function finish()
    {
        $user = Auth::user();
        return view('motivasi_belajar_finish', compact('user'));
    }

}
