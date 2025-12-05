<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Skala Preferensi Belajar - SMK5TEST</title>
    {{-- Pastikan Vite sudah terload --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Styling Custom Radio agar mirip Google Form */
        .custom-radio-input:checked + div {
            border-color: #652D90; /* Warna Ungu/Biru Utama */
            background-color: #f3e8ff;
        }
        .custom-radio-input:checked + div .radio-inner {
            background-color: #652D90;
            transform: scale(1);
        }
        /* Hover effects */
        .radio-option:hover div {
            border-color: #652D90;
        }
    </style>
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col font-sans">

    {{-- 1. DATA SOAL LENGKAP (Sesuai Gambar yang Diinputkan) --}}
    @php
        $sections = [
            'Linguistik' => [
                'L1' => 'Saya mudah menulis laporan atau presentasi tentang tugas praktik.',
                'L2' => 'Saya senang berdiskusi atau berdebat dengan teman sekelas.',
                'L3' => 'Saya sering membaca buku/panduan teknis di luar materi sekolah.',
                'L4' => 'Saya bisa menjelaskan konsep teknis dengan bahasa yang jelas.',
                'L5' => 'Saya suka mencatat dengan rinci saat guru menjelaskan.'
            ],
            'Logis-Matematis' => [
                'T1' => 'Saya cepat memahami rumus teknik atau hitungan akuntansi.',
                'T2' => 'Saya senang memecahkan masalah mesin dengan analisis logis.',
                'T3' => 'Saya suka permainan strategi seperti catur atau teka-teki angka.',
                'T4' => 'Saya tertarik mempelajari cara kerja program komputer.',
                'T5' => 'Saya terbiasa membuat perencanaan keuangan pribadi.'
            ],
            'Visual-Spasial' => [
                'V1' => 'Saya bisa membayangkan desain produk dalam bentuk 3D.',
                'V2' => 'Saya senang menggambar diagram atau membaca peta.',
                'V3' => 'Saya lebih mudah memahami instruksi melalui gambar daripada tulisan.',
                'V4' => 'Saya suka mengatur tata letak benda di sekitar saya.',
                'V5' => 'Saya tertarik dengan fotografi atau desain grafis.'
            ],
            'Kinestetik' => [
                'K1' => 'Saya lebih cepat belajar dengan praktik langsung di bengkel/lab.',
                'K2' => 'Saya terampil menggunakan alat praktikum atau peralatan bengkel.',
                'K3' => 'Saya tidak bisa diam saat belajar (misalnya: mengetuk-ngetuk pensil).',
                'K4' => 'Saya suka olahraga atau aktivitas fisik yang membutuhkan koordinasi.',
                'K5' => 'Saya mudah mengingat sesuatu setelah melakukannya secara fisik.'
            ],
            'Musikal' => [
                'M1' => 'Saya  peka terhadap suara mesin yang tidak normal.',
                'M2' => 'Saya sering bersenandung atau mengetuk ritme saat berpikir.',
                'M3' => 'Saya mudah mengingat informasi jika diubah menjadi lagu/jingle.',
                'M4' => 'Saya bisa mengenali nada musik tanpa melihat sumbernya.',
                'M5' => 'Saya suka bekerja sambil mendengarkan musik.'
            ],
            'Interpersonal' => [
                'A1' => 'Saya rutin mengevaluasi kekuatan dan kelemahan diri sendiri.',
                'A2' => 'Saya punya tujuan jelas untuk karir saya.',
                'A3' => 'Saya lebih suka bekerja mandiri daripada berkelompok.',
                'A4' => 'Saya senang menulis jurnal atau refleksi pribadi.',
                'A5' => 'Saya tahu cara memotivasi diri sendiri saat menghadapi kesulitan.'
            ],
            'Naturalis' => [
                'N1' => 'Saya senang bekerja di luar ruangan (misalnya: pertanian, lingkungan).',
                'N2' => 'Saya bisa mengidentifikasi masalah pada tanaman atau hewan.',
                'N3' => 'Saya tertarik mempelajari ekosistem atau teknologi ramah lingkungan.',
                'N4' => 'Saya suka mengamati pola cuaca atau perubahan alam.',
                'N5' => 'Saya peduli dengan keberlanjutan lingkungan.'
            ],
        ];
    @endphp

    {{-- HEADER / NAVIGATION BAR --}}
    <nav class="bg-[#0A2A43] text-white px-10 py-4 flex justify-between items-center shadow-lg sticky top-0 z-10">
        <div class="flex items-center gap-3">
            <span class="text-xl font-serif font-bold">SMK5TEST</span>
        </div>

        {{-- MENU NAVIGASI --}}
        <ul class="flex gap-8 text-white/80 font-semibold hidden md:flex mx-auto">
            <li><a href="{{ route('dashboard') }}" class="text-white hover:text-[#FFE27A] border-b-2 border-white pb-1">Dashboard</a></li>
            <li><a href="#" class="hover:text-white pb-1 border-b-2 border-transparent">Tes Saya</a></li>
        </ul>

        {{-- PROFIL & LOGOUT --}}
        @auth
        <a href="{{ route('profile.index') }}" class="flex items-center gap-3 ml-auto hover:opacity-90 transition group">
            {{-- Nama User --}}
            <span class="text-white text-base font-semibold hidden sm:block group-hover:text-[#FFE27A] transition">
                {{ explode(' ', $user->name)[0] }}
            </span>
            {{-- Avatar User --}}
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

    <main class="flex-grow py-8 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-3xl mx-auto">

            {{-- FORM ACTION: Pastikan route ini ada di web.php --}}
            <form action="{{ route('skala_preferensi_belajar.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- JUDUL FORM --}}
                <div class="bg-[#0A2A43] rounded-t-xl p-6 text-center shadow-lg">
                    <h1 class="text-2xl font-bold text-white mb-2">Tes Skala Preferensi Belajar</h1>
                    <div class="inline-block bg-[#FFE27A] text-[#0A2A43] px-4 py-1 rounded-full font-bold text-sm">
                        Potensi Akademik
                    </div>
                </div>

                {{-- LOOPING KATEGORI --}}
                @foreach($sections as $categoryTitle => $questions)

                    {{-- Judul Kategori --}}
                    <div class="bg-yellow-50 border-l-4 border-[#FFE27A] p-4 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-1 rounded-full bg-[#FFE27A]"></div>
                            <h2 class="text-xl font-bold text-gray-800">{{ $categoryTitle }}</h2>
                        </div>
                    </div>

                    {{-- Loop Pertanyaan --}}
                    @foreach($questions as $code => $question)
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md mb-4">

                        {{-- Soal --}}
                        <p class="text-gray-800 font-medium text-lg mb-6">
                            <span class="font-bold text-[#0A2A43] mr-2">{{ $code }}</span> {{ $question }}
                        </p>

                        {{-- Skala 1-5 --}}
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                            <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Sangat Tidak Sesuai</span>

                            <div class="flex items-center justify-center gap-4 sm:gap-8 w-full sm:w-auto">
                                @for ($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                    <span class="text-xs text-gray-400 font-medium mb-1">{{ $i }}</span>
                                    {{--
                                        NAME FORMAT: ans_{kategori}_{kode}
                                        Contoh: ans_visual-spasial_V1
                                        Ini memudahkan Controller untuk parsing data.
                                    --}}
                                    <input type="radio"
                                           name="ans_{{ Str::slug($categoryTitle) }}_{{ $code }}"
                                           value="{{ $i }}"
                                           class="custom-radio-input sr-only"
                                           required>

                                    {{-- Custom Radio Circle --}}
                                    <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                        <div class="radio-inner w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                                    </div>
                                </label>
                                @endfor
                            </div>

                            <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Sangat Sesuai</span>
                        </div>
                    </div>
                    @endforeach
                @endforeach

                {{-- TOMBOL NAVIGASI --}}
                <div class="mt-10 flex justify-between gap-4">
                     <a href="{{ route('skala_preferensi_belajar.index') }}" class="w-1/2 text-center bg-gray-200 text-gray-700 font-bold text-lg py-3 px-6 rounded-xl shadow hover:bg-gray-300 transition duration-200">
                        Kembali
                     </a>

                    <button type="submit" class="w-1/2 bg-[#0A2A43] text-white font-bold text-lg py-3 px-6 rounded-xl shadow-lg hover:bg-[#143d5e] transition duration-200 text-center">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#0A2A43] text-white/70 text-center py-6 text-sm mt-auto">
        <p>Copyright &copy; SMKN 5 Malang {{ date('Y') }}. All rights reserved.</p>
    </footer>

</body>
</html>
