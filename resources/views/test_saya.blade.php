<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tes Saya & Hasil - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col font-sans">

    {{-- HEADER / NAVIGATION BAR --}}
    <nav class="bg-[#0A2A43] text-white px-6 md:px-10 py-4 flex justify-between items-center shadow-lg sticky top-0 z-20">
        <div class="flex items-center gap-3">
            <span class="text-xl font-serif font-bold">SMK5TEST</span>
        </div>

        {{-- MENU NAVIGASI --}}
        <ul class="flex gap-8 text-white/80 font-semibold hidden md:flex mx-auto">
            {{-- 1. DASHBOARD: Inactive (Transparan) --}}
            <li>
                <a href="{{ route('dashboard') }}" class="hover:text-white pb-1 border-b-2 border-transparent transition">
                    Dashboard
                </a>
            </li>

            {{-- 2. TES SAYA: Active (Garis Putih + Hover Kuning) --}}
            <li>
                {{-- Menambahkan hover:text-[#FFE27A] agar sama persis dengan style active dashboard sebelumnya --}}
                <a href="{{ route('tes.saya') }}" class="text-white border-b-2 border-white pb-1 hover:text-[#FFE27A] transition">
                    Tes Saya
                </a>
            </li>
        </ul>

        {{-- PROFIL & LOGOUT --}}
        @auth
        <a href="{{ route('profile.index') }}" class="flex items-center gap-3 ml-auto hover:opacity-90 transition group">
            <span class="text-white text-base font-semibold hidden sm:block group-hover:text-[#FFE27A] transition">
                {{ explode(' ', $user->name)[0] }}
            </span>
            <div class="w-10 h-10 rounded-full bg-white text-[#0A2A43] flex items-center justify-center font-bold text-lg cursor-pointer overflow-hidden border-2 border-transparent group-hover:border-[#FFE27A] transition">
                @if($user->profile_photo_path)
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profil" class="w-full h-full object-cover">
                @else
                    {{ substr(explode(' ', $user->name)[0], 0, 1) }}
                @endif
            </div>
        </a>
        @endauth
    </nav>

    {{-- KONTEN UTAMA --}}
    <main class="flex-grow">

        {{-- JUDUL HALAMAN --}}
        <section class="px-6 md:px-10 mt-8 mb-6">
            <div class="max-w-5xl mx-auto">
                <h1 class="text-2xl font-bold text-[#0A2A43] mb-2">Riwayat & Hasil Tes</h1>
                <p class="text-gray-600">Berikut adalah daftar tes asesmen yang tersedia untuk Anda.</p>
            </div>
        </section>

        {{-- LIST DATA --}}
        <section class="px-6 md:px-10 pb-12">
            <div class="max-w-5xl mx-auto flex flex-col gap-4">

                @php
                    // Sorting: Tes yang sudah selesai (completed=true) ditampilkan paling atas
                    // menggunakan helper collect() dari Laravel
                    $listTes = collect($listTes)->sortByDesc('completed');
                @endphp

                @foreach ($listTes as $tes)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 md:p-6 hover:shadow-md transition duration-300 flex flex-col md:flex-row md:items-center gap-5 md:gap-8">

                        {{-- Icon (Kiri) --}}
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-[#F4F1FF] rounded-xl flex items-center justify-center p-3">
                                <img src="{{ asset('storage/icons/' . $tes['icon']) }}"
                                     alt="{{ $tes['title'] }}"
                                     class="w-full h-full object-contain opacity-80"
                                     onerror="this.src='https://via.placeholder.com/64?text=Icon'">
                            </div>
                        </div>

                        {{-- Deskripsi & Status (Tengah) --}}
                        <div class="flex-grow">
                            <h3 class="font-bold text-[#0A2A43] text-xl leading-tight">{{ $tes['title'] }}</h3>
                            <p class="text-gray-500 text-sm mt-1 mb-3">{{ $tes['desc'] }}</p>

                            <div class="flex items-center gap-3 flex-wrap">
                                @if($tes['completed'])
                                    <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-bold flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Selesai
                                    </span>
                                    <span class="text-xs text-gray-400 border-l pl-3 border-gray-300">
                                        Terakhir: {{ $tes['date'] }}
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-500 text-xs px-3 py-1 rounded-full font-bold">
                                        Belum Dikerjakan
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- TOMBOL AKSI (Kanan) --}}
                        <div class="flex-shrink-0 w-full md:w-auto mt-4 md:mt-0 flex flex-col sm:flex-row gap-2">

                            @if($tes['completed'])
                                {{-- Tombol 1: Lihat Hasil (Menuju Halaman Finish/Result) --}}
                                <a href="{{ $tes['route_result'] }}" class="bg-[#0A2A43] text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-[#143d5e] transition text-sm flex items-center justify-center gap-2 shadow-sm whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Lihat Hasil
                                </a>

                                {{-- Tombol 2: Ulangi Tes (Menuju Halaman Instruksi/Start) --}}
                                {{-- Memungkinkan siswa mengerjakan ulang tes --}}
                                <a href="{{ $tes['route_start'] }}" class="border border-[#0A2A43] text-[#0A2A43] px-5 py-2.5 rounded-lg font-semibold hover:bg-gray-50 transition text-sm flex items-center justify-center gap-2 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Ulangi Tes
                                </a>
                            @else
                                {{-- Jika belum selesai, hanya muncul tombol Kerjakan --}}
                                <a href="{{ $tes['route_start'] }}" class="w-full md:w-48 bg-[#FBAF3C] text-[#0A2A43] px-6 py-2.5 rounded-lg font-bold hover:bg-[#e09b32] transition text-sm flex items-center justify-center shadow-sm">
                                    Kerjakan Sekarang
                                </a>
                            @endif
                        </div>

                    </div>
                @endforeach

            </div>
        </section>

    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#0A2A43] text-white text-center py-5 text-sm mt-auto">
        Copyright (c) SMKN 5 Malang {{ date('Y') }}. All rights reserved.
    </footer>

</body>
</html>
