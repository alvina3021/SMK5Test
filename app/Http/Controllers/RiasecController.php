<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RiasecResult;
use Illuminate\Support\Str; // Tambahkan ini untuk helper string jika dibutuhkan

class RiasecController extends Controller
{
    /**
     * Halaman Pintu Masuk (GATEKEEPER)
     * Mengecek apakah user sudah mengerjakan atau belum.
     * Jika SUDAH: Hitung skor dari DB -> Tampilkan Hasil.
     * Jika BELUM: Tampilkan Halaman Instruksi.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. CEK DATABASE: Ambil data hasil tes user ini
        $result = RiasecResult::where('user_id', $user->id)->first();

        // 2. LOGIKA PENGALIHAN
        if ($result) {
            // --- MULAI LOGIKA PERHITUNGAN SKOR DARI KODE SEBELUMNYA ---

            // Ambil jawaban mentah dari database
            // Pastikan di Model RiasecResult ada: protected $casts = ['answers' => 'array'];
            $answers = $result->answers;

            // Definisi Kategori
            $categories = [
                'realistic-r'     => ['name' => 'Realistic', 'code' => 'R'],
                'investigative-i' => ['name' => 'Investigative', 'code' => 'I'],
                'artistic-a'      => ['name' => 'Artistic', 'code' => 'A'],
                'social-s'        => ['name' => 'Social', 'code' => 'S'],
                'enterprising-e'  => ['name' => 'Enterprising', 'code' => 'E'],
                'conventional-c'  => ['name' => 'Conventional', 'code' => 'C'],
            ];

            $scores = [];

            // Hitung Skor (Looping data jawaban yang tersimpan)
            foreach ($categories as $slug => $data) {
                $total = 0;
                // Kita loop asumsi max 20 soal per kategori
                for ($i = 0; $i < 20; $i++) {
                    $keyName = "ans_{$slug}_{$i}";

                    // Cek apakah key jawaban ada di data database
                    if (isset($answers[$keyName])) {
                        $total += (int) $answers[$keyName];
                    }
                }
                $scores[$data['name']] = $total;
            }

            // Urutkan skor dari tertinggi ke terendah
            arsort($scores);

            // Ambil Top 3 Kepribadian
            $topThree = array_slice(array_keys($scores), 0, 3);
            $topResult = $topThree[0]; // Dominan

            // Definisi Deskripsi
            $descriptions = [
                'Realistic' => 'Anda adalah tipe "Do-ers". Anda suka bekerja dengan benda, alat, mesin, tumbuhan, atau hewan. Anda lebih menyukai pekerjaan fisik dan aktivitas luar ruangan.',
                'Investigative' => 'Anda adalah tipe "Thinkers". Anda suka mengamati, belajar, menyelidiki, menganalisis, mengevaluasi, atau memecahkan masalah ilmiah.',
                'Artistic' => 'Anda adalah tipe "Creators". Anda memiliki kemampuan artistik, inovatif, dan intuisi yang kuat. Anda suka bekerja dalam situasi tidak terstruktur menggunakan imajinasi.',
                'Social' => 'Anda adalah tipe "Helpers". Anda suka bekerja dengan orang lain untuk mencerahkan, menginformasikan, menyembuhkan, atau melatih.',
                'Enterprising' => 'Anda adalah tipe "Persuaders". Anda suka bekerja dengan orang lain untuk mempengaruhi, membujuk, memimpin, atau mengelola demi tujuan organisasi.',
                'Conventional' => 'Anda adalah tipe "Organizers". Anda suka bekerja dengan data, memiliki kemampuan administrasi, menyukai detail, struktur, dan keteraturan.'
            ];

            $description = $descriptions[$topResult] ?? 'Deskripsi tidak ditemukan.';

            // --- SELESAI PERHITUNGAN ---

            // JIKA SUDAH: Tampilkan view finish dengan membawa data hasil perhitungan
            // Kita gunakan session flash untuk 'scores' agar kompatibel dengan view finish sebelumnya,
            // atau passing via compact langsung (lebih direkomendasikan).
            // Di sini saya pakai flash session agar view riasec_finish Anda (yang pakai session(...)) tetap jalan.

            session()->now('scores', $scores);
            session()->now('topResult', $topResult);
            session()->now('topThree', $topThree);
            session()->now('description', $description);

            return view('riasec_finish', compact('user', 'scores', 'topResult', 'description'));
        }

        // JIKA BELUM: Tampilkan Halaman Instruksi (Landing Page Tes)
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
            return redirect()->route('riasec.index');
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

        // 2. Tentukan Nilai Kelas (Null coalescing operator)
        $kelasOtomatis = Auth::user()->kelas ?? '-';

        // 3. Simpan ke Database
        // Pastikan 'answers' dikonversi jadi JSON otomatis oleh Model (Casting)
        RiasecResult::create([
            'user_id' => Auth::id(),
            'kelas'   => $kelasOtomatis,
            'answers' => $answers,
        ]);

        // 4. REDIRECT KE INDEX
        // Index akan mendeteksi data sudah ada -> lalu menghitung skor -> lalu menampilkan hasil.
        return redirect()->route('riasec.index');
    }

    /**
     * Method finish() opsional.
     * Redirect ke index saja biar terpusat.
     */
    public function finish()
    {
        return redirect()->route('riasec.index');
    }
}
