<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preferensi Kelompok - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Tailwind CSS utility: 'Mulai Tes Preferensi Kelompok' design is highly centered. --}}
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col">

    {{-- HEADER / NAVIGATION BAR --}}
    <nav class="bg-[#0A2A43] text-white px-10 py-4 flex justify-between items-center shadow-lg sticky top-0 z-10">
        <div class="flex items-center gap-3">
            <span class="text-xl font-serif font-bold">SMK5TEST</span>
        </div>

        {{-- MENU NAVIGASI --}}
        <ul class="flex gap-8 text-white/80 font-semibold hidden md:flex mx-auto">
            <li><a href="{{ route('dashboard') }}" class="text-white hover:text-[#FFE27A] border-b-2 border-white pb-1">Dashboard</a></li>

            {{-- PERBAIKAN: Menambahkan route('tes.saya') pada href --}}
            <li><a href="{{ route('tes.saya') }}" class="hover:text-white pb-1 border-b-2 border-transparent">Tes Saya</a></li>
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

    <main class="flex-grow flex items-center justify-center py-10 px-4">
    <div class="w-full max-w-4xl">

        {{-- TOMBOL KEMBALI (mengikuti desain gambar kedua) --}}
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="flex items-center text-[#0A2A43] font-semibold hover:text-gray-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        {{-- KARTU UTAMA (mengikuti desain abu-abu dari gambar pertama) --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

            {{-- HEADER BIRU (seperti gambar kedua) --}}
            <div class="bg-[#0A2A43] text-white p-6 md:p-8">
                <h1 class="text-2xl font-bold">Preferensi Kelompok</h1>
                <p class="text-sm text-white/80 mt-1">Identifikasi preferensi kerja kelompok Anda sebelum memulai tes.</p>
            </div>

            {{-- ISI KARTU (bentuk abu-abu seperti gambar pertama) --}}
            <div class="p-8 bg-[#F4F1FF]">

                {{-- BOX RULES MIRIP GAMBAR PERTAMA --}}
                <div class="space-y-4">

                    <div class="bg-[#E9ECF5] rounded-xl p-5">
                        <h3 class="font-semibold text-[#0A2A43]">Jawab dengan Jujur</h3>
                        <p class="text-gray-700 text-sm">Tidak ada jawaban benar atau salah. Jawablah sesuai kondisi dirimu yang sebenarnya.</p>
                    </div>

                    <div class="bg-[#E9ECF5] rounded-xl p-5">
                        <h3 class="font-semibold text-[#0A2A43]">Kerjakan Sendiri</h3>
                        <p class="text-gray-700 text-sm">Pastikan mengerjakan tes ini tanpa bantuan orang lain agar hasil akurat.</p>
                    </div>

                    <div class="bg-[#E9ECF5] rounded-xl p-5">
                        <h3 class="font-semibold text-[#0A2A43]">Fokus dan Tenang</h3>
                        <p class="text-gray-700 text-sm">Cari tempat tenang dan internet stabil. Kamu punya waktu cukup untuk menyelesaikan tes.</p>
                    </div>

                    <div class="bg-[#E9ECF5] rounded-xl p-5">
                        <h3 class="font-semibold text-[#0A2A43]">Jangan Overthink</h3>
                        <p class="text-gray-700 text-sm">Jawablah sesuai kondisi dirimu yang sebenarnya.</p>
                    </div>

                    <div class="bg-[#E9ECF5] rounded-xl p-5">
                        <h3 class="font-semibold text-[#0A2A43]">Selesaikan sampai Akhir</h3>
                        <p class="text-gray-700 text-sm">Tes harus selesai satu sesi. Jawaban akan otomatis tersimpan.</p>
                    </div>

                </div>

                {{-- CHECKBOX PERSETUJUAN --}}
                <div class="mt-8">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" class="mt-1 w-5 h-5 rounded border-gray-400" id="agreement">
                            <span class="text-gray-700 text-sm">
                            Saya memahami petunjuk di atas dan siap memulai tes. Jawaban akan saya isi berdasarkan kondisi diri saya yang sebenarnya.
                        </span>
                    </label>
                </div>

                {{-- TOMBOL LANJUT --}}
                <div class="mt-8 flex justify-center">
                    <a href="{{ route('preferensi_kelompok.form') }}"onclick="if(!document.getElementById('agreement').checked){alert('Silakan centang persetujuan terlebih dahulu.'); return false;}"
                    class="bg-[#FFE27A] text-[#0A2A43] font-bold px-10 py-3 rounded-xl shadow-md hover:bg-yellow-400 transition">
                     Mulai
                    </a>
                </div>

            </div>

        </div>
    </div>
</main>


    {{-- FOOTER (Sama dengan Dashboard) --}}
    <footer class="bg-[#0A2A43] text-white text-center mt-10 py-5 text-sm">
        Copyright (c) SMKN 5 Malang {{ date('Y') }}. All rights reserved.
    </footer>
</body>
</html>
