<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuruDetailController extends Controller
{
    // 1. DETAIL BIODATA SISWA
    public function detailSiswa($id)
    {
        $siswa = DB::table('users')
            ->join('siswa_data', 'users.id', '=', 'siswa_data.user_id')
            ->where('users.id', $id)
            ->first();

        if (!$siswa) abort(404);

        return view('guru.detail.biodata', compact('siswa'));
    }

    // 2. DETAIL RIASEC (Perlu hitung skor)
    public function hasilRiasec($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        $data = DB::table('riasec_results')->where('user_id', $id)->first();

        if (!$data) abort(404);

        // Decode JSON jawaban
        $answers = json_decode($data->answers, true);
        
        // Hitung Skor RIASEC
        $scores = ['R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0];
        if (is_array($answers)) {
            foreach ($answers as $key => $val) {
                // Logic: Kadang formatnya { "R": ["1","2"] } atau { "1": "R" } tergantung kodingan tes kamu
                // Asumsi format jawaban: Key = nomor soal, Value = Tipe (R/I/A/S/E/C)
                // ATAU Key = Tipe, Value = Array of selected items. 
                // Kita pakai logic umum:
                $type = substr($key, 0, 1); // Ambil huruf pertama key jika formatnya R1, R2
                if (array_key_exists($key, $scores)) {
                    $scores[$key] = count($val); // Jika format { "R": [..] }
                } elseif (array_key_exists($type, $scores)) {
                     // Jika format lain, sesuaikan. 
                     // SEMENTARA: Kita anggap user menyimpan array jawaban, kita hitung manual
                     // Jika kamu ragu formatnya, kita kirim raw data dulu.
                }
            }
            // Logic Sederhana: Hitung jumlah kemunculan huruf di jawaban (sesuaikan dengan format save kamu)
            // Code di bawah asumsi $answers = ["R", "R", "I", "A"...] atau sejenisnya
            // Agar aman, saya kirim raw answers ke view biar di view di loop.
        }

        return view('guru.detail.riasec', compact('user', 'data', 'answers'));
    }

    // 3. DETAIL AUM (Alat Ungkap Masalah)
    public function hasilAum($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        $data = DB::table('aum_results')->where('user_id', $id)->first();

        if (!$data) abort(404);

        $masalah = json_decode($data->selected_problems, true) ?? [];
        $masalahBerat = json_decode($data->heavy_problems, true) ?? [];

        return view('guru.detail.aum', compact('user', 'data', 'masalah', 'masalahBerat'));
    }

    // 4. GENERIC RESULT (Untuk Motivasi, Study Habit, dll yang isinya Skala 1-4/Ya-Tidak)
    public function genericResult($jenis, $id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        
        // Mapping URL slug ke Nama Tabel & Judul
        $map = [
            'hasil-motivasi' => ['table' => 'motivasi_belajar', 'title' => 'Motivasi Belajar'],
            'hasil-studi-habit' => ['table' => 'studi_habit', 'title' => 'Study Habit'],
            'hasil-sosial-emosional' => ['table' => 'sosial_emosional', 'title' => 'Sosial Emosional'],
            'hasil-preferensi-kelompok' => ['table' => 'preferensi_kelompok', 'title' => 'Preferensi Kelompok'],
            'hasil-skala-preferensi' => ['table' => 'skala_preferensi_belajar', 'title' => 'Skala Preferensi Belajar'],
        ];

        if (!array_key_exists($jenis, $map)) abort(404);

        $config = $map[$jenis];
        $data = DB::table($config['table'])->where('user_id', $id)->first();

        if (!$data) abort(404);

        $answers = json_decode($data->answers, true);

        return view('guru.detail.generic', compact('user', 'answers', 'config'));
    }
}