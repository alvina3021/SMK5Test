<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RiasecResult;

class RiasecController extends Controller
{
    /**
     * DATABASE SOAL RIASEC (PRIVATE METHOD)
     * Digunakan untuk menampilkan pertanyaan di form
     */
    private function getQuestions()
    {
        return [
            'R' => [
                'Saya suka bekerja dengan alat-alat mesin atau perkakas.',
                'Saya suka memperbaiki alat-alat listrik atau mekanik.',
                'Saya suka aktivitas di luar ruangan (berkebun, merawat hewan, dll).',
                'Saya praktis dan suka mengerjakan sesuatu yang nyata.',
                'Saya lebih suka bekerja sendiri daripada berkelompok.',
                'Saya suka membuat barang kerajinan tangan atau kayu.',
                'Saya suka pelajaran keterampilan atau teknik.'
            ],
            'I' => [
                'Saya suka membaca buku-buku ilmiah atau pengetahuan.',
                'Saya suka memecahkan masalah matematika atau teka-teki.',
                'Saya ingin tahu bagaimana sesuatu bekerja (analitis).',
                'Saya suka melakukan eksperimen atau penelitian.',
                'Saya lebih suka bekerja dengan ide daripada data atau orang.',
                'Saya suka pelajaran sains (Biologi, Fisika, Kimia).',
                'Saya teliti dan suka mengamati lingkungan sekitar.'
            ],
            'A' => [
                'Saya suka menggambar, melukis, atau membuat sketsa.',
                'Saya suka bermain musik atau bernyanyi.',
                'Saya suka menulis cerita, puisi, atau naskah drama.',
                'Saya suka menjadi aktor/aktris dalam pementasan.',
                'Saya kreatif dan memiliki imajinasi yang kuat.',
                'Saya suka mendesain pakaian, poster, atau interior.',
                'Saya tidak suka aturan yang kaku dan mengikat.'
            ],
            'S' => [
                'Saya suka membantu orang lain yang sedang kesulitan.',
                'Saya suka mengajar atau melatih orang lain.',
                'Saya suka bekerja dalam kelompok atau tim.',
                'Saya mudah bergaul dan suka berbicara dengan orang baru.',
                'Saya peduli dengan masalah sosial di masyarakat.',
                'Saya suka merawat orang sakit atau anak-anak.',
                'Saya bisa menjadi pendengar yang baik bagi teman.'
            ],
            'E' => [
                'Saya suka menjadi pemimpin dalam kelompok.',
                'Saya suka meyakinkan atau mempengaruhi orang lain.',
                'Saya suka berjualan atau berbisnis.',
                'Saya berani mengambil risiko untuk mencapai tujuan.',
                'Saya suka berpidato atau berbicara di depan umum.',
                'Saya ambisius dan ingin sukses secara finansial.',
                'Saya suka mengorganisir acara atau kegiatan.'
            ],
            'C' => [
                'Saya suka bekerja dengan angka dan data statistik.',
                'Saya suka menyusun arsip atau merapikan dokumen.',
                'Saya bekerja dengan teliti, rapi, dan teratur.',
                'Saya suka mengikuti aturan dan prosedur yang jelas.',
                'Saya suka pekerjaan administrasi atau pembukuan.',
                'Saya suka mengoperasikan komputer untuk pengolahan data.',
                'Saya bertanggung jawab terhadap rincian tugas.'
            ]
        ];
    }

    /**
     * DATABASE DESKRIPSI KEPRIBADIAN (PRIVATE METHOD)
     * Digunakan untuk hasil analisa di halaman finish
     */
    private function getDescriptions()
    {
        return [
            'R' => [
                'name' => 'Realistic',
                'desc' => 'Tipe Realistic menyukai pekerjaan yang melibatkan benda, alat, mesin, dan hewan. Anda adalah orang yang praktis, menyukai aktivitas fisik, dan lebih suka bekerja dengan benda nyata dibandingkan dengan ide-ide abstrak atau orang lain secara intens.'
            ],
            'I' => [
                'name' => 'Investigative',
                'desc' => 'Tipe Investigative menyukai observasi, belajar, menyelidiki, menganalisis, mengevaluasi, dan memecahkan masalah. Anda memiliki rasa ingin tahu yang tinggi, menyukai sains, dan lebih suka bekerja secara mandiri dengan data atau ide.'
            ],
            'A' => [
                'name' => 'Artistic',
                'desc' => 'Tipe Artistic memiliki kemampuan artistik, inovatif, dan intuisi yang kuat. Anda menyukai situasi yang tidak terstruktur di mana Anda bisa menggunakan imajinasi dan kreativitas. Anda cenderung ekspresif dan orisinil.'
            ],
            'S' => [
                'name' => 'Social',
                'desc' => 'Tipe Social suka bekerja dengan orang lain untuk memberitahu, mencerahkan, membantu, melatih, atau menyembuhkan. Anda memiliki kemampuan komunikasi yang baik, sabar, empati tinggi, dan suka bekerja dalam tim.'
            ],
            'E' => [
                'name' => 'Enterprising',
                'desc' => 'Tipe Enterprising suka bekerja dengan orang lain untuk mempengaruhi, membujuk, memimpin, atau mengelola demi tujuan organisasi atau keuntungan ekonomi. Anda energik, ambisius, percaya diri, dan berani mengambil risiko.'
            ],
            'C' => [
                'name' => 'Conventional',
                'desc' => 'Tipe Conventional menyukai pekerjaan yang berhubungan dengan data, berkas, dan angka. Anda teliti, rapi, teratur, dan suka mengikuti prosedur atau instruksi yang jelas. Anda bekerja dengan sangat baik dalam struktur yang terorganisir.'
            ]
        ];
    }

    /**
     * Halaman Pintu Masuk (Instruksi)
     * Route: riasec.index
     */
    public function index()
    {
        // Bersihkan session sisa jawaban form jika ada
        session()->forget(['riasec_answers']);

        $user = Auth::user();

        // Ambil data terakhir untuk ditampilkan statusnya di view (jika diperlukan)
        $result = RiasecResult::where('user_id', $user->id)->latest()->first();

        return view('riasec', compact('user', 'result'));
    }

    /**
     * Halaman Form (Pertanyaan)
     * Route: riasec.form
     */
    public function form()
    {
        $user = Auth::user();

        // Ambil data soal untuk dikirim ke view
        $categories = $this->getQuestions();

        return view('riasec_form', compact('user', 'categories'));
    }

    /**
     * Proses Simpan Data
     * Route: riasec.store
     */
    public function store(Request $request)
    {
        // 1. Ambil data jawaban
        $answers = $request->except('_token');

        // 2. Validasi sederhana
        if (empty($answers)) {
            return back()->with('error', 'Mohon isi kuesioner terlebih dahulu.');
        }

        // 3. Simpan ke Database
        // Menggunakan create() agar tersimpan sebagai riwayat baru
        $kelasOtomatis = Auth::user()->kelas ?? '-';

        RiasecResult::create([
            'user_id' => Auth::id(),
            'kelas'   => $kelasOtomatis,
            'answers' => $answers, // Pastikan model RiasecResult memiliki cast 'array'
        ]);

        // 4. Redirect ke halaman hasil
        return redirect()->route('riasec.finish')->with('success', 'Tes RIASEC berhasil disimpan!');
    }

    /**
     * Halaman Hasil (Finish)
     * Route: riasec.finish
     */
    /**
     * UPDATE PADA FUNGSI FINISH
     */
    public function finish()
    {
        $user = Auth::user();

        // 1. Ambil hasil tes TERBARU
        $result = RiasecResult::where('user_id', $user->id)->latest()->first();

        if (!$result) {
            return redirect()->route('riasec.index');
        }

        // 2. HITUNG SKOR (LOGIKA BARU SESUAI VIEW ANDA)
        $answers = is_string($result->answers) ? json_decode($result->answers, true) : $result->answers;
        if (!is_array($answers)) $answers = [];

        // Inisialisasi Skor
        $scores = ['R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0];

        foreach ($answers as $key => $val) {
            // Format Key dari View: "ans_realistic-r_0"

            // Cek apakah key dimulai dengan "ans_"
            if (str_starts_with($key, 'ans_')) {
                // Kita perlu ekstrak huruf kodenya (r, i, a, s, e, c)
                // Contoh: "ans_realistic-r_0" -> Kita cari "-r_" atau huruf sebelum underscore terakhir

                $parts = explode('_', $key);
                // $parts[0] = "ans"
                // $parts[1] = "realistic-r" (SLUG KATEGORI)
                // $parts[2] = "0" (INDEX)

                if (isset($parts[1])) {
                    $slug = $parts[1]; // "realistic-r", "social-s", dll.

                    // Ambil huruf terakhir dari slug (r, i, a, s, e, c)
                    $codeChar = strtoupper(substr($slug, -1));

                    // Pastikan hurufnya valid (R, I, A, S, E, C)
                    if (array_key_exists($codeChar, $scores)) {
                        // Tambahkan nilai (1-5) ke skor kategori tersebut
                        // Pastikan $val adalah angka (integer)
                        $scores[$codeChar] += (int)$val;
                    }
                }
            }
        }

        // 3. Urutkan Skor (Tertinggi -> Terendah)
        arsort($scores);

        // 4. Ambil 3 Kode Teratas
        $topThreeKeys = array_keys(array_slice($scores, 0, 3));
        $riasecCode = implode('', $topThreeKeys);
        $topKey = $topThreeKeys[0] ?? 'R';

        // 5. Ambil Deskripsi & Karir
        $descriptions = $this->getDescriptions();
        $topResultName = $descriptions[$topKey]['name'] ?? $topKey;
        $topDescription = $descriptions[$topKey]['desc'] ?? 'Deskripsi tidak tersedia.';


        // 6. KIRIM DATA KE VIEW
        session()->now('topResult', $topResultName);
        session()->now('riasecCode', $riasecCode);
        session()->now('description', $topDescription);
        session()->now('topThree', $topThreeKeys);
        session()->now('scores', $scores);

        return view('riasec_finish', compact('user', 'result'));
    }
}

