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
        return redirect()->route('motivasi_belajar.finish')->with('success', 'Tes Motivasi Belajar berhasil disimpan!');
    }

    /**
     * HALAMAN SELESAI / HASIL
     * Route: motivasi.finish
     */
    public function finish()
    {
        $user = Auth::user();

        // 1. Ambil hasil tes TERBARU
        $result = MotivasiBelajarResult::where('user_id', $user->id)->latest()->first();

        if (!$result) {
            return redirect()->route('motivasi.form');
        }

        // 2. Decode Jawaban
        $answers = is_string($result->answers) ? json_decode($result->answers, true) : $result->answers;
        if (!is_array($answers)) $answers = [];

        // 3. Inisialisasi Skor
        $totalScore = 0;
        $scoresPerSection = [
            'Motivasi Intrinsik' => 0,
            'Motivasi Ekstrinsik' => 0,
            'Ketekunan & Disiplin' => 0,
            'Kebutuhan Berprestasi' => 0,
        ];

        // Mapping Slug Key dari Form ke Nama Kategori yang Rapi
        // Slug diambil dari Str::slug() di view form
        $sectionMap = [
            'a-motivasi-intrinsik' => 'Motivasi Intrinsik',
            'b-motivasi-ekstrinsik' => 'Motivasi Ekstrinsik',
            'c-ketekunan-dan-disiplin-belajar' => 'Ketekunan & Disiplin',
            'd-kebutuhan-berprestasi' => 'Kebutuhan Berprestasi',
        ];

        // 4. Hitung Skor
        foreach ($answers as $key => $val) {
            // Format Key: ans_{slug}_{index}
            // Contoh: ans_a-motivasi-intrinsik_0
            $parts = explode('_', $key);

            if (isset($parts[1]) && isset($sectionMap[$parts[1]])) {
                $categoryName = $sectionMap[$parts[1]];
                $score = (int)$val;

                // Tambah ke Total
                $totalScore += $score;

                // Tambah ke Per Kategori
                $scoresPerSection[$categoryName] += $score;
            }
        }

        // 5. Tentukan Kategori Berdasarkan Total Skor
        // Asumsi: 20 Soal, Skala 1-4.
        // Min Score: 20 x 1 = 20
        // Max Score: 20 x 4 = 80
        // Rentang: 60 poin.

        $kategori = '';
        $warna = '';
        $deskripsi = '';

        if ($totalScore <= 40) {
            $kategori = 'Rendah';
            $warna = 'text-red-600 bg-red-100 border-red-200';
            $deskripsi = 'Motivasi belajar Anda saat ini tergolong rendah. Anda mungkin sering merasa malas, menunda tugas, atau kurang memiliki tujuan belajar yang jelas. Perlu bimbingan untuk menemukan semangat belajar kembali.';
        } elseif ($totalScore <= 60) {
            // Sesuai PDF: Skor 42 masuk "Sedang"
            $kategori = 'Sedang';
            $warna = 'text-yellow-600 bg-yellow-100 border-yellow-200';
            $deskripsi = 'Motivasi belajar Anda cukup baik. Anda memiliki keinginan untuk belajar, namun terkadang masih dipengaruhi oleh suasana hati atau faktor luar. Pertahankan dan tingkatkan konsistensi Anda.';
        } else {
            $kategori = 'Tinggi';
            $warna = 'text-green-600 bg-green-100 border-green-200';
            $deskripsi = 'Luar biasa! Anda memiliki motivasi belajar yang sangat tinggi. Anda tekun, disiplin, dan memiliki orientasi prestasi yang kuat. Pertahankan semangat ini untuk mencapai cita-cita.';
        }

        // 6. Kirim Data ke View
        session()->now('totalScore', $totalScore);
        session()->now('scoresPerSection', $scoresPerSection);
        session()->now('kategori', $kategori);
        session()->now('warna', $warna);
        session()->now('deskripsi', $deskripsi);

        return view('motivasi_belajar_finish', compact('user', 'result'));
    }
}
