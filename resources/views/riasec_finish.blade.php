<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Tes RIASEC - SMK5TEST</title>
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
    <main class="flex-grow py-10 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- KOLOM KIRI: HASIL UTAMA --}}
            <div class="md:col-span-1 flex flex-col gap-6 animate-fade-in-up">
                <div class="bg-white shadow-xl rounded-2xl p-6 text-center border-t-8 border-[#FFE27A] relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded-bl-lg">
                        Dominan
                    </div>

                    {{-- Ikon / Ilustrasi Besar Huruf --}}
                    <div class="w-24 h-24 mx-auto bg-[#0A2A43] rounded-full flex items-center justify-center text-white text-5xl font-bold mb-4 shadow-lg">
                        {{ substr(session('topResult'), 0, 1) }}
                    </div>

                    <h2 class="text-2xl font-bold text-[#0A2A43] mb-1">{{ session('topResult') }}</h2>
                    <p class="text-gray-500 text-sm font-medium mb-4">Tipe Kepribadian Utama Anda</p>

                    <div class="bg-gray-50 rounded-lg p-4 text-left">
                        <p class="text-gray-700 text-sm leading-relaxed">
                            {{ session('description') }}
                        </p>
                    </div>
                </div>

                {{-- Kode Kombinasi (Top 3) --}}
                <div class="bg-[#0A2A43] text-white rounded-xl p-6 shadow-lg text-center">
                    <h3 class="text-sm uppercase tracking-widest text-gray-300 mb-2">Kode Holland Anda</h3>
                    <div class="flex justify-center gap-2 text-3xl font-bold text-[#FFE27A]">
                        @foreach(session('topThree', []) as $type)
                            <span>{{ substr($type, 0, 1) }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: DETAIL GRAFIK --}}
            <div class="md:col-span-2 bg-white shadow-xl rounded-2xl p-8 animate-fade-in-up" style="animation-delay: 0.2s;">
                <h3 class="text-xl font-bold text-[#0A2A43] mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Analisis Skor Lengkap
                </h3>

                <div class="space-y-5">
                    @php
                        $scores = session('scores', []);
                        // Mencari nilai max untuk menghitung persentase width bar
                        $maxScore = max($scores) > 0 ? max($scores) : 1;
                    @endphp

                    @foreach($scores as $type => $score)
                        @php
                            // Hitung persentase untuk lebar bar (skala visual)
                            $width = ($score / $maxScore) * 100;

                            // Warna khusus untuk skor tertinggi
                            $isTop = $type == session('topResult');
                            $barColor = $isTop ? 'bg-[#FFE27A]' : 'bg-gray-200';
                            $textColor = $isTop ? 'text-[#0A2A43] font-bold' : 'text-gray-500';
                        @endphp

                        <div>
                            <div class="flex justify-between items-end mb-1">
                                <span class="{{ $textColor }} text-sm">{{ $type }}</span>
                                <span class="text-sm font-semibold text-gray-700">{{ $score }} Poin</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden">
                                <div class="{{ $barColor }} h-4 rounded-full transition-all duration-1000 ease-out" style="width: {{ $width }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10 flex justify-end">
                    <a href="{{ route('tes.saya') }}" class="flex items-center gap-2 bg-[#0A2A43] text-white px-6 py-3 rounded-xl font-semibold hover:bg-[#153e5e] transition shadow-lg">
                        Kembali ke Tes Saya
                    </a>
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
