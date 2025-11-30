<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaData;
use App\Models\AumResult;
use App\Models\RiasecResult;
use App\Models\MotivasiBelajarResult;
use App\Models\StudiHabitResult;
use App\Models\SosialEmosionalResult;
use App\Models\PreferensiKelompok;

class TesSayaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // -----------------------------------------------------------
        // 1. CEK STATUS PENGERJAAN TERBARU (Logika Database)
        // -----------------------------------------------------------
        // Menggunakan latest()->first() untuk memastikan data yang diambil
        // adalah percobaan terakhir (paling update).

        // --- Data Pribadi ---
        $dataPribadi = SiswaData::where('user_id', $user->id)->latest()->first();
        $statusDataPribadi = $dataPribadi ? true : false;
        $tglDataPribadi = $dataPribadi ? $dataPribadi->updated_at->format('d M Y') : '-';

        // --- RIASEC ---
        $riasec = RiasecResult::where('user_id', $user->id)->latest()->first();
        $statusRiasec = $riasec ? true : false;
        $tglRiasec = $riasec ? $riasec->updated_at->format('d M Y') : '-';

        // --- Motivasi Belajar ---
        $motivasi = MotivasiBelajarResult::where('user_id', $user->id)->latest()->first();
        $statusMotivasi = $motivasi ? true : false;
        $tglMotivasi = $motivasi ? $motivasi->updated_at->format('d M Y') : '-';

        // --- Studi Habit ---
        $studiHabit = StudiHabitResult::where('user_id', $user->id)->latest()->first();
        $statusStudiHabit = $studiHabit ? true : false;
        $tglStudiHabit = $studiHabit ? $studiHabit->updated_at->format('d M Y') : '-';

        // --- Sosial Emosional ---
        $sosial = SosialEmosionalResult::where('user_id', $user->id)->latest()->first();
        $statusSosialEmosional = $sosial ? true : false;
        $tglSosial = $sosial ? $sosial->updated_at->format('d M Y') : '-';

        // --- Preferensi Kelompok ---
        $preferensi = PreferensiKelompok::where('user_id', $user->id)->latest()->first();
        $statusPreferensi = $preferensi ? true : false;
        $tglPreferensi = $preferensi ? $preferensi->updated_at->format('d M Y') : '-';

        // --- AUM (Alat Ungkap Masalah) ---
        $aum = AumResult::where('user_id', $user->id)->latest()->first();
        $statusAum = $aum ? true : false;
        $tglAum = $aum ? $aum->updated_at->format('d M Y') : '-';


        // -----------------------------------------------------------
        // 2. SUSUN DATA UNTUK VIEW
        // -----------------------------------------------------------
        // 'route_result' => Halaman Hasil (Finish) - Untuk melihat skor
        // 'route_start'  => Halaman Mulai/Instruksi (Index) - Untuk mengerjakan ulang

        $listTes = [
            [
                'title' => 'Data Pribadi Siswa',
                'desc' => 'Identitas dasar siswa.',
                'completed' => $statusDataPribadi,
                'icon' => 'data.svg',
                'route_result' => route('data_pribadi.finish'),
                'route_start' => route('data_pribadi'),
                'date' => $tglDataPribadi
            ],
            [
                'title' => 'RIASEC',
                'desc' => 'Tipe kepribadian Holland.',
                'completed' => $statusRiasec,
                'icon' => 'riasec.svg',
                'route_result' => route('riasec.finish'),
                'route_start' => route('riasec.index'),
                'date' => $tglRiasec
            ],
            [
                'title' => 'Motivasi Belajar',
                'desc' => 'Tingkat dorongan belajar.',
                'completed' => $statusMotivasi,
                'icon' => 'motivasi.svg',
                'route_result' => route('motivasi.finish'),
                'route_start' => route('motivasi.index'),
                'date' => $tglMotivasi
            ],
            [
                'title' => 'Studi Habit',
                'desc' => 'Kebiasaan & metode belajar.',
                'completed' => $statusStudiHabit,
                'icon' => 'studiHabit.svg',
                'route_result' => route('studi_habit.finish'),
                'route_start' => route('studi_habit.index'),
                'date' => $tglStudiHabit
            ],
            [
                'title' => 'Sosial Emosional',
                'desc' => 'Kesehatan mental & emosi.',
                'completed' => $statusSosialEmosional,
                'icon' => 'sosial.svg',
                'route_result' => route('sosial_emosional.finish'),
                'route_start' => route('sosial_emosional.index'),
                'date' => $tglSosial
            ],
            [
                'title' => 'Preferensi Kelompok',
                'desc' => 'Gaya interaksi sosial.',
                'completed' => $statusPreferensi,
                'icon' => 'preferensi.svg',
                'route_result' => route('preferensi_kelompok.finish'),
                'route_start' => route('preferensi_kelompok.index'),
                'date' => $tglPreferensi
            ],
            [
                'title' => 'Alat Ungkap Masalah',
                'desc' => 'Identifikasi masalah belajar/pribadi.',
                'completed' => $statusAum,
                'icon' => 'alat.svg',
                'route_result' => route('aum.finish'),
                'route_start' => route('aum.index'),
                'date' => $tglAum
            ]
        ];

        return view('test_saya', compact('user', 'listTes'));
    }
}
