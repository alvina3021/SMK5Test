<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SosialEmosionalResult;

class SosialEmosionalController extends Controller
{
    /**
     * Konfigurasi Skor (Private Method)
     * Menentukan poin untuk setiap jawaban.
     * Sesuaikan bobot ini dengan rubrik psikologis yang Anda gunakan.
     */
    private function getScoringRules()
    {
        // Asumsi: Pertanyaan bersifat negatif (Gejala).
        // Semakin sering = Semakin tinggi skor = Semakin Rentan.
        return [
            'Sangat sering' => 3,
            'Sering' => 2,
            'Kadang-kadang' => 1,
            'Jarang' => 0,
            'Tidak pernah' => 0,

            // Untuk pertanyaan Yes/No
            'Ya' => 2,
            'Tidak' => 0,

            // Kualitas Tidur/Makan (Khusus)
            'Sangat baik' => 0,
            'Baik' => 1,
            'Cukup' => 2,
            'Buruk' => 3,
        ];
    }

    /**
     * Menentukan Kategori Berdasarkan Total Skor
     */
    private function getCategory($score)
    {
        // Batas skor (Threshold) - Silakan disesuaikan dengan standar PDF Anda
        if ($score <= 10) {
            return [
                'name' => 'Baik',
                'color' => 'bg-green-100 text-green-800 border-green-200',
                'desc' => 'Kondisi kesehatan mental dan sosial emosional Anda sangat stabil. Pertahankan gaya hidup positif ini.'
            ];
        } elseif ($score <= 20) {
            return [
                'name' => 'Cukup',
                'color' => 'bg-blue-100 text-blue-800 border-blue-200',
                'desc' => 'Secara umum kondisi Anda baik, namun ada beberapa aspek kecil yang mungkin perlu diperhatikan agar tidak berkembang.'
            ];
        } elseif ($score <= 30) {
            return [
                'name' => 'Perlu Perhatian',
                'color' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                'desc' => 'Anda mengalami gejala stres atau gangguan emosional tingkat sedang. Disarankan untuk mulai melakukan relaksasi atau bercerita kepada teman.'
            ];
        } else {
            return [
                'name' => 'Rentan',
                'color' => 'bg-red-100 text-red-800 border-red-200',
                'desc' => 'Skor Anda menunjukkan indikasi beban emosional yang tinggi. Sangat disarankan untuk berkonsultasi dengan Guru BK atau profesional.'
            ];
        }
    }

    /**
     * HALAMAN PINTU MASUK (GATEKEEPER)
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
     */
    public function form()
    {
        $user = Auth::user();
        $currentSession = session('sosial_emosional_step1', []);
        // LOGIKA ULANGI TES: Hapus pengecekan exists() agar bisa re-take.
		return view('sosial_emosional_form', compact('user', 'currentSession'));
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
     */
    public function step2()
    {
        $user = Auth::user();

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
     */
    public function finish()
    {
        $user = Auth::user();

        // 1. Ambil hasil TERBARU
        $result = SosialEmosionalResult::where('user_id', $user->id)->latest()->first();

        if (!$result) {
            return redirect()->route('sosial_emosional.form');
        }

        // 2. HITUNG SKOR
        $answers = is_string($result->answers) ? json_decode($result->answers, true) : $result->answers;
        $scoringRules = $this->getScoringRules();
        $totalScore = 0;

        if (is_array($answers)) {
            foreach ($answers as $question => $answer) {
                // Cari poin berdasarkan jawaban text (misal "Sering" -> 2)
                // Jika jawaban tidak ada di rules, default 0
                if (isset($scoringRules[$answer])) {
                    $totalScore += $scoringRules[$answer];
                }
            }
        }

        // 3. TENTUKAN KATEGORI
        $category = $this->getCategory($totalScore);

        // 4. KIRIM KE VIEW (Via Session Flash agar bersih)
        session()->now('score', $totalScore);
        session()->now('category_name', $category['name']);
        session()->now('category_color', $category['color']);
        session()->now('category_desc', $category['desc']);

        // Tampilkan View Hasil
        return view('sosial_emosional_finish', compact('user', 'result'));
    }
}
