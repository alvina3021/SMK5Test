<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon; // Import Carbon untuk manipulasi waktu

// Import Semua Model
use App\Models\SiswaData;
use App\Models\RiasecResult;
use App\Models\MotivasiBelajarResult;
use App\Models\StudiHabitResult;
use App\Models\SosialEmosionalResult;
use App\Models\PreferensiKelompok;
use App\Models\AumResult;
use App\Models\SkalaPreferensiBelajar;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil User Login
        $user = Auth::user();
        $userId = $user->id;

        // -----------------------------------------------------------
        // BAGIAN 1: CEK STATUS (Untuk Warna Tombol)
        // -----------------------------------------------------------
        $statusDataPribadi     = SiswaData::where('user_id', $userId)->exists();
        $statusRiasec          = RiasecResult::where('user_id', $userId)->exists();
        $statusMotivasi        = MotivasiBelajarResult::where('user_id', $userId)->exists();
        $statusStudiHabit      = StudiHabitResult::where('user_id', $userId)->exists();
        $statusSosialEmosional = SosialEmosionalResult::where('user_id', $userId)->exists();
        $statusPreferensi      = PreferensiKelompok::where('user_id', $userId)->exists();
        $statusAum             = AumResult::where('user_id', $userId)->exists();
        $statusSkalaPreferensi = SkalaPreferensiBelajar::where('user_id', $userId)->exists();

        // -----------------------------------------------------------
        // BAGIAN 2: AKTIVITAS TERKINI (DINAMIS)
        // -----------------------------------------------------------
        $rawActivities = [];

        // Fungsi helper kecil untuk format data agar seragam
        // Menggunakan 'created_at' untuk sorting nanti
        $addActivity = function($model, $title, $desc) use (&$rawActivities, $userId) {
            $data = $model::where('user_id', $userId)->latest()->first();
            if ($data) {
                // Set locale Carbon ke Indonesia (opsional, jika config app belum 'id')
                Carbon::setLocale('id');

                $rawActivities[] = [
                    'title' => $title,
                    'desc'  => $desc,
                    'timestamp' => $data->created_at, // Untuk sorting
                    'time'  => $data->created_at->diffForHumans(), // Contoh: "10 menit yang lalu"
                ];
            }
        };

        // Masukkan data dari masing-masing tabel ke array penampung
        $addActivity(SiswaData::class, 'Data Pribadi Lengkap', 'Anda telah berhasil melengkapi biodata diri.');
        $addActivity(RiasecResult::class, 'Tes RIASEC Selesai', 'Anda telah menyelesaikan tes minat karir.');
        $addActivity(MotivasiBelajarResult::class, 'Tes Motivasi Selesai', 'Anda telah menyelesaikan asesmen motivasi belajar.');
        $addActivity(StudiHabitResult::class, 'Tes Studi Habit Selesai', 'Anda telah menyelesaikan tes kebiasaan belajar.');
        $addActivity(SosialEmosionalResult::class, 'Tes Sosial Emosional Selesai', 'Anda telah menyelesaikan asesmen kesehatan mental.');
        $addActivity(PreferensiKelompok::class, 'Tes Preferensi Kelompok Selesai', 'Anda telah menyelesaikan preferensi kerja kelompok.');
        $addActivity(AumResult::class, 'Tes Alat Ungkap Masalah Selesai', 'Anda telah menyelesaikan identifikasi masalah umum.');
        $addActivity(SkalaPreferensiBelajar::class, 'Tes Skala Preferensi Belajar', 'Anda telah menyelesaikan Skala Preferensi Belajar.');

        // Urutkan array berdasarkan 'timestamp' (Terbaru di atas / Descending)
        usort($rawActivities, function ($a, $b) {
            return $b['timestamp'] <=> $a['timestamp'];
        });

        // Jika tidak ada aktivitas sama sekali, beri pesan default
        if (empty($rawActivities)) {
            $aktivitas = [
                [
                    'title' => 'Selamat Datang',
                    'desc' => 'Silakan mulai dengan mengisi Data Pribadi Anda.',
                    'time' => 'Sekarang'
                ]
            ];
        } else {
            // Ambil 5 aktivitas terakhir saja
            $aktivitas = array_slice($rawActivities, 0, 5);
        }

        // -----------------------------------------------------------
        // BAGIAN 3: KIRIM DATA KE VIEW
        // -----------------------------------------------------------
        return view('dashboard', compact(
            'user',
            'statusDataPribadi',
            'statusRiasec',
            'statusMotivasi',
            'statusStudiHabit',
            'statusSosialEmosional',
            'statusPreferensi',
            'statusSkalaPreferensi',
            'statusAum',
            'aktivitas'
        ));
    }

    public function testSaya() {
    $user = Auth::user();
    // ... logika cek status sama seperti index dashboard ...
    return view('test_saya', compact('user', 'statusDataPribadi', 'statusAum', 'statusRiasec',
            'statusMotivasi',
            'statusStudiHabit',
            'statusSosialEmosional',
            'statusPreferensi',
            'statusSkalaPreferensi'));
    }
}


