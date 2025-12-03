<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Preferensi Kelompok - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col font-sans">

    {{-- HEADER --}}
    <nav class="bg-[#0A2A43] text-white px-6 md:px-10 py-4 flex justify-between items-center shadow-lg sticky top-0 z-20">
        <div class="flex items-center gap-3">
            <span class="text-xl font-serif font-bold">SMK5TEST</span>
        </div>
        <ul class="flex gap-8 text-white/80 font-semibold hidden md:flex mx-auto">
            <li><a href="{{ route('dashboard') }}" class="hover:text-white pb-1 border-b-2 border-transparent transition">Dashboard</a></li>
            <li><a href="{{ route('tes.saya') }}" class="text-white border-b-2 border-white pb-1">Tes Saya</a></li>
        </ul>
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
    <main class="grow py-10 px-4 md:px-10 flex justify-center">
        <div class="max-w-4xl w-full space-y-8">

            {{-- HEADER HASIL --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-[#0A2A43]">Profil Kolaborasi & Sosial</h1>
                <p class="text-gray-600 mt-2">Analisis gaya bekerja dalam tim dan kebutuhan sosial Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- KARTU 1: ANALISIS SOSIAL (SKOR) --}}
                <div class="md:col-span-1 bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 flex flex-col">
                    <div class="bg-[#FFE27A] text-[#0A2A43] p-5 text-center">
                        <h2 class="text-lg font-bold">Skor Kebutuhan Sosial</h2>
                    </div>
                    <div class="p-6 flex-grow flex flex-col items-center justify-center text-center">
                        <div class="text-5xl font-extrabold text-[#0A2A43] mb-2">
                            {{ session('avgSosial') }}
                        </div>
                        <div class="text-xs text-gray-400 mb-4">Skala 1.0 - 5.0</div>

                        <div class="px-4 py-2 rounded-lg font-bold text-sm mb-4 border {{ session('warnaSosial') }}">
                            {{ session('analisisSosial') }}
                        </div>
                        <p class="text-gray-500 text-xs leading-relaxed italic">
                            "{{ session('descSosial') }}"
                        </p>
                    </div>
                </div>

                {{-- KARTU 2: DETAIL PREFERENSI (BAGIAN 1 & 3) --}}
                <div class="md:col-span-2 bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <h3 class="font-bold text-[#0A2A43] text-lg mb-4 border-b pb-2">Detail Preferensi</h3>

                    <div class="space-y-4">
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide">Peran Favorit</span>
                            <div class="font-semibold text-lg text-[#0A2A43]">{{ ucfirst(session('peranKelompok')) }}</div>
                        </div>

                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide">Lingkungan Kerja Ideal</span>
                            <div class="text-gray-700">{{ session('preferensiKerja') }}</div>
                        </div>

                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide">Karakteristik Diri</span>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @foreach(explode(', ', session('karakteristik')) as $trait)
                                    <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm font-medium border border-blue-100">
                                        {{ $trait }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- KARTU 3: INTERPRETASI NARATIF (SEPERTI DI PDF) --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                <div class="bg-[#0A2A43] text-white p-5 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#FFE27A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h2 class="text-lg font-bold">Interpretasi & Rekomendasi Guru BK</h2>
                </div>
                <div class="p-8">
                    <div class="prose max-w-none text-gray-700 leading-relaxed text-justify">
                        <p>
                            Siswa lebih suka bekerja pada kelompok yang
                            <span class="font-bold text-[#0A2A43]">{{ session('preferensiKerja') }}</span>.
                            Dan siswa dapat berperan aktif sebagai
                            <span class="font-bold text-[#0A2A43]">{{ ucfirst(session('peranKelompok')) }}</span>.
                        </p>
                        <p class="mt-4">
                            Siswa memiliki karakteristik dominan sebagai berikut:
                            <span class="italic text-blue-600">{{ session('karakteristik') }}</span>.
                            Berdasarkan hasil analisis kebutuhan, Guru BK diharapkan dapat membantu siswa dalam hal:
                            <span class="font-bold text-red-600 border-b-2 border-red-200">{{ session('kebutuhanKhusus') }}</span>.
                        </p>
                    </div>
                </div>
            </div>

            {{-- TOMBOL KEMBALI --}}
            <div class="flex justify-center mt-8">
                <a href="{{ route('tes.saya') }}" class="bg-[#0A2A43] text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-[#143d5e] transition transform hover:-translate-y-1 flex items-center gap-2">
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
