<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RiasecResult;

class RiasecController extends Controller
{
    // 1. Halaman Instruksi (Landing Page)
    public function index()
    {
        $user = Auth::user();
        return view('riasec', compact('user'));
    }

    // 2. Halaman Form (Pertanyaan)
    public function form()
    {
        $user = Auth::user();
        return view('riasec_form', compact('user'));
    }

    // 3. Proses Simpan Data
    public function store(Request $request)
    {
        // 1. Ambil semua jawaban soal (kecuali token CSRF)
        // Karena tidak ada input 'kelas' di form, $data ini murni isinya jawaban soal (ans_realistic_0, dst).
        $answers = $request->except('_token');

        // 2. Tentukan Nilai Kelas Secara Otomatis (Backend Logic)
        // Logika: Coba ambil dari Auth::user()->kelas.
        // Jika null/tidak ada, pakai default value '-' agar tidak error SQL.
        $kelasOtomatis = Auth::user()->kelas ?? '-';

        // C. Simpan ke Database
        RiasecResult::create([
            'user_id' => Auth::id(),
            'kelas'   => $kelasOtomatis, // Diisi otomatis oleh sistem
            'answers' => $answers,       // Array jawaban (pastikan cast 'array' ada di Model)
        ]);


        // D. Redirect
        return redirect()->route('riasec.finish');
    }

    // 4. Halaman Selesai
   public function finish()
    {
        $user = Auth::user();
        return view('riasec_finish', compact('user'));
    }
}
