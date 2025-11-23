<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Data dummy status tes
        $status_tes = [
            'total_sesi' => 8, // Total sesi disesuaikan dengan 8 kartu
            'sesi_selesai' => 3,
        ];

        // Data kartu menu
        $menu_items = [
            ['title' => 'Tes Minat', 'desc' => 'Mulai asesmen minat Anda.', 'icon' => 'M'],
            ['title' => 'Tes Bakat', 'desc' => 'Mulai asesmen bakat Anda.', 'icon' => 'B'],
            ['title' => 'Tes Gaya Belajar', 'desc' => 'Kenali cara belajar terbaik.', 'icon' => 'G'],
            ['title' => 'Tes Multiple Intelligences', 'desc' => 'Ukur potensi kecerdasan.', 'icon' => 'I'],
            ['title' => 'Materi Jurusan', 'desc' => 'Lihat deskripsi dan prospek.', 'icon' => 'J'],
            ['title' => 'Materi Karier', 'desc' => 'Peta jalan karier masa depan.', 'icon' => 'K'],
            ['title' => 'Rekomendasi', 'desc' => 'Lihat hasil rekomendasi final.', 'icon' => 'R'],
            ['title' => 'Lihat Hasil Tes', 'desc' => 'Lihat riwayat dan skor tes.', 'icon' => 'H'],
        ];

        // Data aktivitas terkini (Dummy)
        $aktivitas = [
            ['activity' => 'Mengerjakan Tes Minat', 'time' => '10 menit lalu'],
            ['activity' => 'Melihat Hasil Rekomendasi', 'time' => '2 jam lalu'],
            ['activity' => 'Membaca Materi Jurusan TKJ', 'time' => 'Kemarin'],
        ];

        return view('dashboard', compact('user', 'status_tes', 'menu_items', 'aktivitas'));
    }
}
