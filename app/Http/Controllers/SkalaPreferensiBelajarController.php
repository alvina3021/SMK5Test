<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SkalaPreferensiBelajar;

class SkalaPreferensiBelajarController extends Controller
{
    /**
     * Halaman Instruksi (Landing Page Modul)
     */
    public function index()
    {
        // Reset session jika ada sisa data tes sebelumnya
        session()->forget(['skala_preferensi_answers']);

        $user = Auth::user();

        // Cek apakah user sudah pernah mengerjakan
        $result = SkalaPreferensiBelajar::where('user_id', $user->id)->latest()->first();

        return view('skala_preferensi_belajar', compact('user', 'result'));
    }

    /**
     * Halaman Form Soal
     */
    public function form()
    {
        $user = Auth::user();
        return view('skala_preferensi_belajar_form', compact('user'));
    }

    /**
     * Simpan Jawaban
     */
    public function store(Request $request)
    {
        // Ambil semua input kecuali token
        $answers = $request->except('_token');

        if (empty($answers)) {
            return back()->with('error', 'Mohon isi kuesioner terlebih dahulu.');
        }

        // Simpan ke Database
        SkalaPreferensiBelajar::create([
            'user_id' => Auth::id(),
            'answers' => $answers,
        ]);

        // Redirect ke halaman finish (Anda perlu buat view ini nanti)
        return redirect()->route('skala_preferensi_belajar.finish')->with('success', 'Tes Skala Preferensi Belajar berhasil disimpan!');
    }

    public function finish()
    {
        $user = Auth::user();

        // 1. Ambil hasil tes TERBARU
        $result = SkalaPreferensiBelajar::where('user_id', $user->id)->latest()->first();

        if (!$result) {
            return redirect()->route('skala_preferensi_belajar.form');
        }

        // 2. Decode Jawaban
        $answers = is_string($result->answers) ? json_decode($result->answers, true) : $result->answers;
        if (!is_array($answers)) $answers = [];

        // 3. Inisialisasi Skor untuk 8 Kategori (Sesuai PDF)
        $scores = [
            'Visual-Spasial'  => 0, // Kode V
            'Linguistik'      => 0, // Kode L
            'Logis-Matematis' => 0, // Kode T
            'Kinestetik'      => 0, // Kode K
            'Musikal'         => 0, // Kode M
            'Interpersonal'   => 0, // Kode E
            'Intrapersonal'   => 0, // Kode A
            'Naturalis'       => 0  // Kode N
        ];

        // 4. Hitung Skor
        foreach ($answers as $key => $val) {
            // Format Key: "ans_slug-kategori_KodeSoal" (contoh: ans_visual-spasial_V1)
            // Kita ambil Huruf Depan dari Kode Soal (V, L, T, K, dll)

            $parts = explode('_', $key);
            // $parts[0] = ans
            // $parts[1] = visual-spasial
            // $parts[2] = V1

            if (isset($parts[2])) {
                $code = strtoupper(substr($parts[2], 0, 1)); // Ambil huruf pertama (V, L, T...)
                $val = (int)$val;

                switch ($code) {
                    case 'V': $scores['Visual-Spasial'] += $val; break;
                    case 'L': $scores['Linguistik'] += $val; break;
                    case 'T': $scores['Logis-Matematis'] += $val; break;
                    case 'K': $scores['Kinestetik'] += $val; break;
                    case 'M': $scores['Musikal'] += $val; break;
                    case 'E': $scores['Interpersonal'] += $val; break;
                    case 'A': $scores['Intrapersonal'] += $val; break;
                    case 'N': $scores['Naturalis'] += $val; break;
                }
            }
        }

        // 5. Urutkan Skor Tertinggi
        arsort($scores);
        $topCategory = array_key_first($scores);
        $topScore = $scores[$topCategory];

        // 6. Deskripsi Singkat (Bisa dilengkapi)
        $descriptions = [
            'Visual-Spasial'  => 'Anda belajar paling baik melalui gambar, grafik, dan visualisasi ruang.',
            'Linguistik'      => 'Anda unggul dalam penggunaan kata-kata, membaca, dan menulis.',
            'Logis-Matematis' => 'Anda menyukai pola, logika, angka, dan berpikir sistematis.',
            'Kinestetik'      => 'Anda belajar melalui gerakan fisik, sentuhan, dan praktik langsung.',
            'Musikal'         => 'Anda peka terhadap nada, irama, dan belajar baik dengan musik.',
            'Interpersonal'   => 'Anda belajar paling baik melalui interaksi sosial dan kerjasama tim.',
            'Intrapersonal'   => 'Anda memahami diri sendiri dengan baik dan suka bekerja mandiri.',
            'Naturalis'       => 'Anda terhubung kuat dengan alam dan lingkungan sekitar.'
        ];
        $topDesc = $descriptions[$topCategory] ?? 'Deskripsi tidak tersedia.';

        // 7. Kirim Data ke View
        session()->now('scores', $scores);
        session()->now('topCategory', $topCategory);
        session()->now('topScore', $topScore);
        session()->now('topDesc', $topDesc);

        return view('skala_preferensi_belajar_finish', compact('user', 'result'));
    }
}
