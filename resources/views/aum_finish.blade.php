<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil AUM - SMK5TEST</title>
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
            <li><a href="{{ route('dashboard') }}" class="text-white hover:text-[#FFE27A] border-b-2 border-white pb-1">Dashboard</a></li>
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
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profil" class="w-full h-full object-cover">
                @else
                    {{-- Tampilkan Inisial Jika Tidak Ada Foto --}}
                    {{ substr(explode(' ', $user->name)[0], 0, 1) }}
                @endif
            </div>
        </a>
        @endauth
    </nav>

    <main class="grow py-10 px-4 md:px-10">
        <div class="max-w-4xl mx-auto">

            {{-- KARTU SUKSES --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">

                {{-- HEADER SUKSES --}}
                <div class="bg-[#0A2A43] text-white p-8 text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold mb-2">Terima Kasih!</h1>
                    <p class="text-white/80">Jawaban Alat Ungkap Masalah (AUM) Anda telah berhasil disimpan.</p>
                </div>

                <div class="p-8 space-y-8">

                    {{-- --- HASIL LANGKAH 2: MASALAH TERBERAT --- --}}
                    <div class="bg-yellow-50 rounded-xl border-l-8 border-[#FFE27A] p-6 shadow-sm">
                        <h3 class="font-bold text-[#0A2A43] text-lg mb-3 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Masalah Paling Berat / Mengganggu
                        </h3>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 text-gray-700 italic leading-relaxed">
                            {{-- Mengambil data deskripsi dari array JSON --}}
                            "{{ $result->heavy_problems['description'] ?? 'Tidak ada deskripsi.' }}"
                        </div>
                    </div>

                    {{-- --- HASIL LANGKAH 3: RENCANA KONSULTASI --- --}}
                    <div class="bg-[#F4F1FF] rounded-xl border border-[#d8e4ff] p-6 shadow-sm">
                        <h3 class="font-bold text-[#0A2A43] text-lg mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                            </svg>
                            Rencana Konsultasi
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Item 1 --}}
                            <div>
                                <span class="text-sm text-gray-500 block mb-1">Ingin membicarakan masalah?</span>
                                <span class="font-bold text-[#0A2A43] text-lg">
                                    {{ $result->consultation_data['ingin_bicara'] ?? '-' }}
                                </span>
                            </div>

                            {{-- Item 2 --}}
                            <div>
                                <span class="text-sm text-gray-500 block mb-1">Ingin bantuan khusus?</span>
                                <span class="font-bold text-[#0A2A43] text-lg">
                                    {{ $result->consultation_data['ingin_bantuan'] ?? '-' }}
                                </span>
                            </div>

                            {{-- Item 3 (Mitra Bicara - Array) --}}
                            <div class="md:col-span-2">
                                <span class="text-sm text-gray-500 block mb-1">Ingin berbicara kepada:</span>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    @if(!empty($result->consultation_data['mitra_bicara']))
                                        @foreach($result->consultation_data['mitra_bicara'] as $mitra)
                                            <span class="bg-white border border-gray-300 text-gray-700 px-3 py-1 rounded-full text-sm font-medium">
                                                {{ $mitra }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-gray-400 italic">- Tidak memilih mitra -</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Item 4 --}}
                            <div class="md:col-span-2">
                                <span class="text-sm text-gray-500 block mb-1">Waktu Konsultasi:</span>
                                <span class="font-bold text-[#0A2A43]">
                                    {{ $result->consultation_data['waktu_konsultasi'] ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- FOOTER TOMBOL --}}
                <div class="p-6 bg-gray-50 border-t border-gray-200 text-center">
                    {{-- Tombol Kembali ke Tes Saya (MODIFIKASI DISINI) --}}
                    <a href="{{ route('tes.saya') }}" class="inline-block bg-[#0A2A43] text-white font-bold text-lg py-3 px-10 rounded-xl shadow-lg hover:bg-[#143d5e] hover:shadow-xl transform hover:-translate-y-1 transition duration-200">
                        Kembali ke Tes Saya
                    </a>
                </div>

            </div>
        </div>
    </main>

    <footer class="bg-[#0A2A43] text-white text-center mt-10 py-5 text-sm">
        Copyright (c) SMKN 5 Malang {{ date('Y') }}. All rights reserved.
    </footer>
</body>
</html>
