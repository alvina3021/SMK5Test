<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PreferensiKelompok;

class PreferensiKelompokController extends Controller
{
    /**
     * HALAMAN PINTU MASUK (GATEKEEPER)
     * Route: preferensi_kelompok.index
     */
    public function index()
    {
        // 1. RESET SESSION: Bersihkan jika ada sisa session (Best Practice)
        session()->forget(['preferensi_answers']);

        $user = Auth::user();

        // 2. Ambil data terakhir untuk cek status di view
        $result = PreferensiKelompok::where('user_id', $user->id)->latest()->first();

        return view('preferensi_kelompok', compact('user', 'result'));
    }

    /**
     * HALAMAN FORM SOAL
     * Route: preferensi_kelompok.form
     */
    public function form()
    {
        $user = Auth::user();

        // PERBAIKAN LOGIKA "ULANGI TES":
        // Kita HAPUS pengecekan "if (exists) redirect".
        // Agar siswa BISA mengerjakan ulang (Re-take).

        return view('preferensi_kelompok_form', compact('user'));
    }

    /**
     * MENYIMPAN JAWABAN
     * Route: preferensi_kelompok.store
     */
    public function store(Request $request)
    {
        // 1. Ambil data jawaban
        $data = $request->except('_token');

        // 2. Validasi sederhana
        if (empty($data)) {
            return back()->with('error', 'Mohon isi kuesioner terlebih dahulu.');
        }

        // 3. Simpan ke Database (History Baru)
        PreferensiKelompok::create([
            'user_id' => Auth::id(),
            'answers' => $data, // Pastikan model punya $casts = ['answers' => 'array']
        ]);

        // 4. Redirect ke halaman FINISH (Hasil)
        return redirect()->route('preferensi_kelompok.finish')->with('success', 'Tes Preferensi Kelompok berhasil disimpan!');
    }

    /**
     * HALAMAN SELESAI / HASIL
     * Route: preferensi_kelompok.finish
     */
    public function finish()
    {
        $user = Auth::user();

        // 1. Ambil hasil tes TERBARU
        $result = PreferensiKelompok::where('user_id', $user->id)->latest()->first();

        if (!$result) {
            return redirect()->route('preferensi_kelompok.form');
        }

        // 2. Decode Jawaban
        $answers = is_string($result->answers) ? json_decode($result->answers, true) : $result->answers;
        if (!is_array($answers)) $answers = [];

        // 3. Ambil Data Deskriptif (Bagian 1, 3, 4)
        // Pastikan key sesuai dengan 'name' di form blade
        $preferensiKerja = $answers['preferensi_kerja_soal1'] ?? []; // Array Checkbox
        $peranKelompok   = $answers['preferensi_kerja_soal2'] ?? '-'; // Radio String
        $karakteristik   = $answers['karakteristik_diri'] ?? [];      // Array Checkbox
        $kebutuhanKhusus = $answers['kebutuhan_khusus'] ?? [];        // Array Checkbox

        // 4. Hitung Skor Kebutuhan Sosial (Bagian 2 - Skala Likert 1-5)
        // Soal: kebutuhan_sosial_1 s/d kebutuhan_sosial_4
        $totalSosial = 0;
        $countSosial = 4; // Jumlah soal bagian 2

        $totalSosial += (int)($answers['kebutuhan_sosial_1'] ?? 0);
        $totalSosial += (int)($answers['kebutuhan_sosial_2'] ?? 0);
        $totalSosial += (int)($answers['kebutuhan_sosial_3'] ?? 0);
        $totalSosial += (int)($answers['kebutuhan_sosial_4'] ?? 0);

        // Hitung Rata-rata
        $avgSosial = $totalSosial / $countSosial;

        // 5. Tentukan Kategori Analisis (Sesuai PDF)
        $analisisSosial = '';
        $warnaSosial = '';

        if ($avgSosial <= 2.5) {
            $analisisSosial = 'Butuh Pendampingan Sosial';
            $warnaSosial = 'text-red-600 bg-red-100 border-red-200';
            $descSosial = 'Siswa cenderung merasa kesulitan beradaptasi atau kurang nyaman dalam interaksi sosial. Perlu dukungan guru/teman untuk mencairkan suasana.';
        } elseif ($avgSosial <= 3.5) {
            $analisisSosial = 'Cukup Adaptif';
            $warnaSosial = 'text-yellow-600 bg-yellow-100 border-yellow-200';
            $descSosial = 'Siswa memiliki kemampuan sosial yang wajar, bisa beradaptasi namun mungkin membutuhkan waktu di lingkungan baru.';
        } else {
            $analisisSosial = 'Mandiri & Sosial';
            $warnaSosial = 'text-green-600 bg-green-100 border-green-200';
            $descSosial = 'Siswa sangat mandiri, mudah bergaul, dan proaktif dalam kegiatan kelompok. Potensi menjadi pemimpin atau mediator.';
        }

        // 6. Format Data untuk View (Agar rapi saat ditampilkan)
        $preferensiString = is_array($preferensiKerja) ? implode(', ', $preferensiKerja) : $preferensiKerja;
        $karakteristikString = is_array($karakteristik) ? implode(', ', $karakteristik) : '-';
        $kebutuhanString = is_array($kebutuhanKhusus) ? implode(', ', $kebutuhanKhusus) : '-';

        // 7. Kirim Data via Session Flash
        session()->now('preferensiKerja', $preferensiString);
        session()->now('peranKelompok', $peranKelompok);
        session()->now('karakteristik', $karakteristikString);
        session()->now('kebutuhanKhusus', $kebutuhanString);

        session()->now('avgSosial', number_format($avgSosial, 1)); // Format desimal 1 angka (misal: 3.5)
        session()->now('analisisSosial', $analisisSosial);
        session()->now('warnaSosial', $warnaSosial);
        session()->now('descSosial', $descSosial);

        return view('preferensi_kelompok_finish', compact('user', 'result'));
    }
}
