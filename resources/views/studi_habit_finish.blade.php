<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Studi Habit & Gaya Belajar - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
    <main class="grow py-10 px-4 md:px-10 flex justify-center">
        <div class="max-w-4xl w-full space-y-8">

            {{-- JUDUL HALAMAN --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-[#0A2A43]">Laporan Analisis Belajar</h1>
                <p class="text-gray-600 mt-2">Berikut adalah hasil analisis kebiasaan dan gaya belajar Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- KARTU 1: HASIL STUDI HABIT (KEBIASAAN BELAJAR) --}}
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col">
                    <div class="bg-[#0A2A43] text-white p-6">
                        <h2 class="text-xl font-bold flex items-center gap-2">
                            <span>📚</span> Kebiasaan Belajar
                        </h2>
                    </div>
                    <div class="p-8 flex-grow flex flex-col items-center justify-center text-center">

                        <div class="text-gray-500 font-medium mb-2">Skor Anda</div>
                        <div class="text-5xl font-extrabold text-[#0A2A43] mb-4">
                            {{ session('habitScore') }} <span class="text-lg text-gray-400 font-normal">/ 60</span>
                        </div>

                        {{-- Kategori Badge --}}
                        <div class="px-6 py-2 rounded-full font-bold text-lg mb-6 {{ session('habitColor') }}">
                            {{ session('habitCategory') }}
                        </div>

                        <p class="text-gray-600 text-sm leading-relaxed">
                            @if(session('habitScore') >= 48)
                                Luar biasa! Anda memiliki disiplin dan kebiasaan belajar yang sangat efektif. Pertahankan!
                            @elseif(session('habitScore') >= 36)
                                Bagus. Anda sudah memiliki dasar kebiasaan yang baik, namun masih bisa ditingkatkan lagi agar lebih maksimal.
                            @else
                                Perlu perhatian. Sebaiknya Anda mulai menjadwalkan waktu belajar yang lebih teratur dan mengurangi gangguan.
                            @endif
                        </p>
                    </div>
                </div>

                {{-- KARTU 2: HASIL GAYA BELAJAR --}}
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col">
                    <div class="bg-[#FFE27A] text-[#0A2A43] p-6">
                        <h2 class="text-xl font-bold flex items-center gap-2">
                            <span>🧠</span> Gaya Belajar Dominan
                        </h2>
                    </div>
                    <div class="p-8 flex-grow">

                        {{-- Hasil Dominan --}}
                        <div class="text-center mb-8">
                            <div class="text-gray-500 font-medium mb-1">Tipe Belajar Anda:</div>
                            <h3 class="text-3xl font-bold text-[#0A2A43] mb-2 uppercase tracking-wide">
                                {{ session('dominantStyle') }}
                            </h3>
                            <p class="text-gray-600 text-sm italic">"{{ session('dominantDesc') }}"</p>
                        </div>

                        {{-- Grafik Bar Sederhana --}}
                        <div class="space-y-4">
                            @foreach(session('styleScores', []) as $style => $score)
                                {{-- Hitung Persentase (Max Score per gaya = 4 soal * 5 = 20) --}}
                                @php $percent = ($score / 20) * 100; @endphp
                                <div>
                                    <div class="flex justify-between text-sm font-bold text-gray-700 mb-1">
                                        <span>{{ $style }}</span>
                                        <span>{{ $score }} Poin</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                        <div class="h-3 rounded-full transition-all duration-1000 ease-out
                                            {{ $style == 'Visual' ? 'bg-blue-500' : ($style == 'Auditori' ? 'bg-green-500' : 'bg-orange-500') }}"
                                            style="width: {{ $percent }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>

            {{-- TOMBOL AKSI --}}
            <div class="flex justify-center mt-8">
                <a href="{{ route('tes.saya') }}" class="bg-[#0A2A43] text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-[#143d5e] transition transform hover:-translate-y-1">
                    Kembali ke Tes Saya
                </a>
            </div>

        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#0A2A43] text-white text-center py-5 text-sm mt-auto">
        Copyright (c) SMKN 5 Malang {{ date('Y') }}. All rights reserved.
    </footer>

</body>
</html>
