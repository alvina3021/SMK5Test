<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selesai - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col">


    {{-- HEADER / NAVIGATION BAR --}}
    <nav class="bg-[#0A2A43] text-white px-10 py-4 flex justify-between items-center shadow-lg sticky top-0 z-10">
        <div class="flex items-center gap-3">
            <span class="text-xl font-serif font-bold">SMK5TEST</span>
        </div>

        <ul class="flex gap-8 text-white/80 font-semibold hidden md:flex mx-auto">
            <li><a href="{{ route('dashboard') }}" class="text-white hover:text-[#FFE27A] border-b-2 border-white pb-1">Dashboard</a></li>
            <li><a href="#" class="hover:text-white pb-1 border-b-2 border-transparent">Tes Saya</a></li>
            <li><a href="#" class="hover:text-white pb-1 border-b-2 border-transparent">Materi</a></li>
        </ul>

        @auth
        <div class="flex items-center gap-3 ml-auto">
            <span class="text-white text-base font-semibold hidden sm:block">{{ explode(' ', $user->name)[0] }}</span>
            <div class="w-10 h-10 rounded-full bg-white text-[#0A2A43] flex items-center justify-center font-bold text-lg cursor-pointer">
                {{ substr(explode(' ', $user->name)[0], 0, 1) }}
            </div>
        </div>
        @endauth
    </nav>

    {{-- KONTEN UTAMA --}}
    <main class="flex-grow flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-2xl mx-auto">

            <div class="bg-white shadow-2xl rounded-2xl p-10 text-center relative overflow-hidden">

                {{-- Hiasan Background (Opsional) --}}
                <div class="absolute top-0 left-0 w-full h-2 bg-[#FFE27A]"></div>

                {{-- Ikon Sukses Animasi --}}
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-6 animate-bounce-slow">
                    <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                {{-- Judul --}}
                <h2 class="text-3xl font-bold text-[#0A2A43] mb-4">Data Berhasil Disimpan!</h2>

                {{-- Pesan Sesuai Permintaan --}}
                <p class="text-gray-600 text-lg mb-10 leading-relaxed">
                    Terima kasih telah mengisi angket Data Pribadi
                </p>

                {{-- Tombol Kembali ke Dashboard --}}
                <a href="{{ route('dashboard') }}" class="inline-block bg-[#0A2A43] text-white font-bold text-lg py-3 px-10 rounded-xl shadow-lg hover:bg-[#143d5e] hover:shadow-xl transform hover:-translate-y-1 transition duration-200">
                    Kembali ke Dashboard
                </a>

            </div>
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#0A2A43] text-white text-center py-5 text-sm">
        Copyright (c) SMKN 5 Malang {{ date('Y') }}. All rights reserved.
    </footer>

    <style>
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(-5%); }
            50% { transform: translateY(5%); }
        }
        .animate-bounce-slow {
            animation: bounce-slow 2s infinite;
        }
    </style>
</body>
</html>
