<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Motivasi Belajar - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out forwards;
        }
    </style>
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col font-sans">

    {{-- HEADER / NAVIGATION BAR --}}
    <nav class="bg-[#0A2A43] text-white px-10 py-4 flex justify-between items-center shadow-lg sticky top-0 z-10">
        <div class="flex items-center gap-3">
            <span class="text-xl font-serif font-bold">SMK5TEST</span>
        </div>

        {{-- MENU NAVIGASI --}}
        <ul class="flex gap-8 text-white/80 font-semibold hidden md:flex mx-auto">
            {{-- 1. DASHBOARD: DIUBAH MENJADI NON-AKTIF (Border Transparent) --}}
            <li>
                <a href="{{ route('dashboard') }}" class="hover:text-white pb-1 border-b-2 border-transparent transition">
                    Dashboard
                </a>
            </li>

            {{-- 2. TES SAYA: DIUBAH MENJADI AKTIF (Border White + Text White + Hover Kuning) --}}
            <li>
                <a href="{{ route('tes.saya') }}" class="text-white border-b-2 border-white pb-1 hover:text-[#FFE27A] transition">
                    Tes Saya
                </a>
            </li>
        </ul>

        {{-- PROFIL & LOGOUT --}}
        @auth
        {{-- Link ke Halaman Profile --}}
        <a href="{{ route('profile.index') }}" class="flex items-center gap-3 ml-auto hover:opacity-90 transition group">

            {{-- Nama User --}}
            <span class="text-white text-base font-semibold hidden sm:block group-hover:text-[#FFE27A] transition">
                {{ explode(' ', $user->name)[0] }}
            </span>

            {{-- Avatar User --}}
            <div class="w-10 h-10 rounded-full bg-white text-[#0A2A43] flex items-center justify-center font-bold text-lg cursor-pointer overflow-hidden border-2 border-transparent group-hover:border-[#FFE27A] transition">
                @if($user->profile_photo_path)
                    {{-- Tampilkan Foto Jika Ada --}}
                    <img src="{{ asset('public/app/public/' . $user->profile_photo_path) }}" alt="Profil" class="w-full h-full object-cover">
                @else
                    {{-- Tampilkan Inisial Jika Tidak Ada Foto --}}
                    {{ substr(explode(' ', $user->name)[0], 0, 1) }}
                @endif
            </div>
        </a>
        @endauth
    </nav>

    {{-- KONTEN UTAMA --}}
    {{-- MODIFIKASI: Menggunakan max-w-6xl agar lebih lebar & Grid System --}}
    <main class="grow py-10 px-4 sm:px-6 lg:px-8">
        
        {{-- Grid Layout: 1 Kolom di HP, 3 Kolom di Laptop (1 Kiri : 2 Kanan) --}}
        <div class="w-full max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            {{-- === KOLOM KIRI (SIDEBAR): HASIL UTAMA === --}}
            <div class="lg:col-span-1 flex flex-col gap-6 animate-fade-in-up">

                {{-- KARTU HASIL --}}
                <div class="bg-white shadow-xl rounded-2xl p-6 text-center border-t-8 border-[#FFE27A] relative overflow-hidden h-full">
                    
                    {{-- Badge di pojok kanan atas --}}
                    <div class="absolute top-0 right-0 bg-[#FFE27A] text-[#0A2A43] text-xs font-bold px-4 py-1 rounded-bl-xl shadow-sm">
                        Dominan
                    </div>

                    {{-- Lingkaran Skor (Dibuat Lebih Besar) --}}
                    <div class="w-32 h-32 mx-auto bg-[#0A2A43] rounded-full flex items-center justify-center text-[#FFE27A] text-5xl font-bold mb-6 shadow-lg border-4 border-white ring-2 ring-[#0A2A43]/20 mt-4">
                        {{ session('totalScore') }}
                    </div>

                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-2">Tipe Anda</h2>
                    
                    {{-- Nama Kategori --}}
                    <div class="text-2xl font-extrabold text-[#0A2A43] mb-6">
                        {{ session('kategori') }}
                    </div>

                    {{-- Deskripsi --}}
                    <div class="bg-gray-50 rounded-xl p-5 text-left border border-gray-100 shadow-inner">
                        <p class="text-gray-700 text-sm leading-relaxed italic">
                            "{{ session('deskripsi') }}"
                        </p>
                    </div>
                </div>

                {{-- TOMBOL KEMBALI (Ditaruh di kiri agar struktur kanan lebih bersih) --}}
                <a href="{{ route('tes.saya') }}" class="block w-full bg-[#0A2A43] text-white text-center py-4 rounded-xl font-bold hover:bg-[#153e5e] transition shadow-lg transform hover:-translate-y-1">
                    Kembali ke Tes Saya
                </a>
            </div>

            {{-- === KOLOM KANAN (MAIN): DETAIL SKOR === --}}
            <div class="lg:col-span-2 bg-white shadow-xl rounded-2xl p-8 animate-fade-in-up h-full" style="animation-delay: 0.2s;">
                
                <h3 class="text-2xl font-bold text-[#0A2A43] mb-8 flex items-center gap-3 border-b pb-4">
                    <svg class="w-7 h-7 text-[#FFE27A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Analisis Skor Lengkap
                </h3>

                <div class="space-y-8">
                    @php
                        $scores = session('scoresPerSection', []);
                        $maxSectionScore = 20; // Sesuaikan dengan nilai max soal
                    @endphp

                    @foreach($scores as $category => $score)
                        @php
                            $percentage = ($score / $maxSectionScore) * 100;
                            // Logika warna bar sederhana
                            if($percentage <= 50) $barColor = 'bg-gray-400';
                            elseif($percentage <= 75) $barColor = 'bg-[#FFE27A]';
                            else $barColor = 'bg-[#0A2A43]';
                        @endphp

                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-[#0A2A43] font-bold text-lg">{{ $category }}</span>
                                <span class="text-sm font-bold text-gray-600">{{ $score }} <span class="text-xs font-normal text-gray-400">Poin</span></span>
                            </div>
                            
                            {{-- Progress Bar yang lebih modern --}}
                            <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden">
                                <div class="{{ $barColor }} h-4 rounded-full transition-all duration-1000 ease-out shadow-sm" style="width: {{ $percentage }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#0A2A43] text-white/70 text-center py-6 text-sm mt-auto">
        <p>Copyright &copy; SMKN 5 Malang {{ date('Y') }}. All rights reserved.</p>
    </footer>

</body>
</html>