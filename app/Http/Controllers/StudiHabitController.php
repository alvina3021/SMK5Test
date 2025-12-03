<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudiHabitResult;
use Illuminate\Support\Str; // PENTING: Wajib ada agar Str::contains berjalan

class StudiHabitController extends Controller
{
    /**
     * HALAMAN PINTU MASUK (GATEKEEPER)
     * Route: studi_habit.index
     */
    public function index()
    {
        // 1. RESET SESSION: Bersihkan session step 1 agar mulai dari bersih
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
        return view('studi_habit_form', compact('user'));
    }

    /**
     * PROSES SIMPAN STEP 1 (Ke Session)
     */
    public function store(Request $request)
    {
        $dataStep1 = $request->except('_token');

        // Validasi sederhana agar tidak menyimpan data kosong
        if (empty($dataStep1)) {
            return back()->with('error', 'Mohon isi kuesioner terlebih dahulu.');
        }

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

        // PROTEKSI WAJIB: Harus lewat step 1 dulu
        // Jika session step 1 tidak ada, tendang balik ke form awal
        if (!session()->has('studi_habit_step1')) {
            return redirect()->route('studi_habit.form')
                ->with('error', 'Sesi telah berakhir, silakan mulai dari awal.');
        }

        return view('studi_habit_step2', compact('user'));
    }

    /**
     * PROSES SIMPAN STEP 2 (FINAL - Ke Database)
     */
    public function storeStep2(Request $request)
    {
        // 1. Ambil data dari Input Step 2
        $dataStep2 = $request->except('_token');

        // 2. Ambil data dari Session Step 1
        $dataStep1 = session()->get('studi_habit_step1');

        // --- PERBAIKAN UTAMA (VALIDASI ANTI-CRASH) ---
        // Cek apakah $dataStep1 itu kosong/null sebelum di-merge
        if (!$dataStep1 || !is_array($dataStep1)) {
            // Jika kosong (karena session expired atau terhapus),
            // Redirect paksa kembali ke Step 1 dengan pesan error.
            return redirect()->route('studi_habit.form')
                ->with('error', 'Maaf, sesi Anda telah berakhir atau data langkah 1 hilang. Silakan ulangi tes dari awal.');
        }
        // ------------------------------------------------

        // 3. Gabungkan Jawaban (Sekarang aman karena $dataStep1 pasti array)
        $allAnswers = array_merge($dataStep1, $dataStep2);

        // 4. Simpan ke Database
        StudiHabitResult::create([
            'user_id' => Auth::id(),
            'answers' => $allAnswers, // Pastikan Model memiliki cast 'array'
        ]);

        // 5. Bersihkan Session
        $request->session()->forget('studi_habit_step1');

        // 6. Redirect ke Finish
        return redirect()->route('studi_habit.finish')->with('success', 'Tes berhasil disimpan!');
    }

    /**
     * HALAMAN SELESAI / HASIL
     * Route: studi_habit.finish
     */
    public function finish()
    {
        $user = Auth::user();

        // 1. Ambil hasil tes TERBARU
        $result = StudiHabitResult::where('user_id', $user->id)->latest()->first();

        if (!$result) {
            return redirect()->route('studi_habit.form');
        }

        // 2. DECODE JAWABAN
        $answers = is_string($result->answers) ? json_decode($result->answers, true) : $result->answers;
        if (!is_array($answers)) $answers = [];

        // 3. INISIALISASI VARIABEL HITUNG
        // A. Studi Habit (Skor Total)
        $habitScore = 0;

        // B. Gaya Belajar (Visual, Auditori, Kinestetik)
        $styleScores = [
            'Visual' => 0,
            'Auditori' => 0,
            'Kinestetik' => 0
        ];

        // 4. LOOPING JAWABAN & HITUNG SKOR
        foreach ($answers as $key => $val) {
            $val = (int)$val; // Pastikan nilai integer

            // --- LOGIKA STUDI HABIT (STEP 1) ---
            // Key dari form step 1 mengandung 'studi-habit'
            // Contoh key: "ans_a-studi-habit_0"
            if (Str::contains($key, 'studi-habit')) {
                $habitScore += $val;
            }

            // --- LOGIKA GAYA BELAJAR (STEP 2) ---
            // Key eksplisit: visual_1, auditori_2, kinestik_3, dst.
            elseif (Str::contains($key, 'visual')) {
                $styleScores['Visual'] += $val;
            }
            elseif (Str::contains($key, 'auditori')) {
                $styleScores['Auditori'] += $val;
            }
            // Perhatikan: di blade Anda menulis 'kinestik' (typo), jadi di sini juga harus 'kinestik'
            // Jika nanti blade diperbaiki jadi 'kinestetik', di sini juga ubah.
            elseif (Str::contains($key, 'kinestik')) {
                $styleScores['Kinestetik'] += $val;
            }
        }

        // 5. ANALISIS KATEGORI STUDI HABIT
        // Rentang (Rule of Thumb):
        // > 48 (Sangat Baik), 36-48 (Baik), 24-36 (Cukup), < 24 (Kurang)
        $habitCategory = '';
        $habitColor = '';

        if ($habitScore >= 48) {
            $habitCategory = 'Sangat Baik';
            $habitColor = 'text-green-600 bg-green-100 border-green-200';
        } elseif ($habitScore >= 36) {
            $habitCategory = 'Baik';
            $habitColor = 'text-blue-600 bg-blue-100 border-blue-200';
        } elseif ($habitScore >= 24) {
            $habitCategory = 'Cukup';
            $habitColor = 'text-yellow-600 bg-yellow-100 border-yellow-200';
        } else {
            $habitCategory = 'Perlu Perbaikan';
            $habitColor = 'text-red-600 bg-red-100 border-red-200';
        }

        // 6. ANALISIS GAYA BELAJAR DOMINAN
        // Cari nilai tertinggi
        arsort($styleScores); // Urutkan dari terbesar
        $dominantStyle = array_key_first($styleScores); // Ambil kunci pertama (Visual/Auditori/Kinestetik)

        // Deskripsi Gaya Belajar
        $descriptions = [
            'Visual' => 'Anda belajar paling baik dengan melihat. Gambar, diagram, grafik, dan catatan berwarna sangat membantu Anda memahami informasi.',
            'Auditori' => 'Anda belajar paling baik dengan mendengar. Mendengarkan penjelasan guru, berdiskusi, atau membaca dengan suara keras sangat efektif bagi Anda.',
            'Kinestetik' => 'Anda belajar paling baik dengan melakukan (gerak). Praktik langsung, eksperimen, atau belajar sambil bergerak membantu Anda mengingat informasi.'
        ];
        $dominantDesc = $descriptions[$dominantStyle] ?? '-';

        // 7. KIRIM DATA KE VIEW (Via Session Flash agar bersih)
        session()->now('habitScore', $habitScore);
        session()->now('habitCategory', $habitCategory);
        session()->now('habitColor', $habitColor);
        session()->now('styleScores', $styleScores);
        session()->now('dominantStyle', $dominantStyle);
        session()->now('dominantDesc', $dominantDesc);

        return view('studi_habit_finish', compact('user', 'result'));
    }
}
