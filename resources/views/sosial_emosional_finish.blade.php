<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Kesehatan Mental - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col font-sans">

    {{-- HEADER / NAVIGATION BAR --}}
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
    <main class="grow py-10 px-4 md:px-10 flex items-center justify-center">
        <div class="max-w-3xl w-full">

            {{-- KARTU HASIL --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200 mb-8 text-center">

                <div class="bg-[#0A2A43] text-white p-8">
                    <h1 class="text-2xl font-bold mb-2">Hasil Tes Sosial Emosional</h1>
                    <p class="text-white/80 text-sm">Analisis kesejahteraan mental dan stabilitas emosi Anda saat ini.</p>
                </div>

                <div class="p-8 md:p-12">

                    {{-- SKOR UTAMA --}}
                    <div class="mb-6">
                        <span class="block text-gray-500 text-sm font-semibold uppercase tracking-wider mb-2">Skor Kesehatan Mental (KesMen)</span>
                        <div class="text-6xl font-extrabold text-[#0A2A43]">
                            {{ session('score', 0) }}
                        </div>
                    </div>

                    {{-- KATEGORI --}}
                    <div class="mb-8">
                        <span class="inline-block px-6 py-2 rounded-full text-lg font-bold border {{ session('category_color') }}">
                            {{ session('category_name') }}
                        </span>
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="bg-gray-50 rounded-xl p-6 text-left border-l-4 border-[#0A2A43]">
                        <h3 class="font-bold text-[#0A2A43] mb-2 text-lg">Interpretasi:</h3>
                        <p class="text-gray-700 leading-relaxed">
                            {{ session('category_desc') }}
                        </p>
                    </div>

                </div>

                {{-- TOMBOL AKSI --}}
                <div class="bg-gray-50 p-6 border-t border-gray-100 flex justify-center gap-4">
                    <a href="{{ route('tes.saya') }}" class="bg-[#0A2A43] text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-[#143d5e] transition">
                        Kembali ke Tes Saya
                    </a>
                </div>

            </div>

        </div>
    </main>

    <footer class="bg-[#0A2A43] text-white text-center py-5 text-sm mt-auto">
        Copyright (c) SMKN 5 Malang {{ date('Y') }}. All rights reserved.
    </footer>

</body>
</html>
