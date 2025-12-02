<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SMK5TEST</title>
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
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profil" class="w-full h-full object-cover">
                @else
                    {{-- Tampilkan Inisial Jika Tidak Ada Foto --}}
                    {{ substr(explode(' ', $user->name)[0], 0, 1) }}
                @endif
            </div>
        </a>
        @endauth
    </nav>

    {{-- KONTEN UTAMA --}}
    <main class="flex-grow">
        <section class="px-10 mt-6">
            <div class="bg-[#0A2A43] text-white text-center py-6 rounded-xl text-xl font-semibold shadow-md">
                Temukan potensi dan arah masa depanmu disini
            </div>
        </section>

        <section class="px-10 mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- KOLOM KIRI (Menu Kartu) --}}
            <div class="col-span-1 lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-5">

                @php
                    // Definisi Array Kartu
                    // Status 'completed' diambil dari variabel yang dikirim DashboardController
                    $cards = [
                        [
                            'title' => 'Data Pribadi Siswa',
                            'desc' => 'Lengkapi informasi dasar sebagai identitas awal untuk analisis tes selanjutnya.',
                            'completed' => $statusDataPribadi,
                            'icon' => 'data.svg'
                        ],
                        [
                            'title' => 'RIASEC',
                            'desc' => 'Kenali minat kariermu berdasarkan tipe kepribadian Holland (RIASEC).',
                            'completed' => $statusRiasec,
                            'icon' => 'riasec.svg'
                        ],
                        [
                            'title' => 'Motivasi Belajar',
                            'desc' => 'Cari tahu seberapa besar motivasi yang kamu miliki dalam menjalani proses belajar.',
                            'completed' => $statusMotivasi,
                            'icon' => 'motivasi.svg'
                        ],
                        [
                            'title' => 'Studi Habit & Gaya Belajar',
                            'desc' => 'Ketahui kebiasaan belajarmu dan metode belajar yang paling cocok untukmu.',
                            'completed' => $statusStudiHabit,
                            'icon' => 'studiHabit.svg'
                        ],
                        [
                            'title' => 'Sosial Emosional & Kesehatan Mental',
                            'desc' => 'Pahami kondisi emosimu, tingkat stres, dan kesejahteraan mentalmu secara umum.',
                            'completed' => $statusSosialEmosional,
                            'icon' => 'sosial.svg'
                        ],
                        [
                            'title' => 'Preferensi Kelompok & Kebutuhan Sosial',
                            'desc' => 'Kenali kecenderunganmu dalam bekerja sama dan kebutuhan sosial di lingkungan belajar.',
                            'completed' => $statusPreferensi,
                            'icon' => 'preferensi.svg'
                        ],
                        // Kartu Dummy (Belum ada Logic Controller)
                        [
                            'title' => 'Skala Preferensi Belajar',
                            'desc' => 'Temukan gaya belajar utama yang paling memengaruhi efektivitas belajarmu.',
                            'completed' => false,
                            'icon' => 'skalaPreferensi.svg'
                        ],
                        [
                            'title' => 'Alat Ungkap Masalah',
                            'desc' => 'Identifikasi permasalahan belajar, pribadi, atau sosial yang sedang kamu hadapi.',
                            'completed' => $statusAum,
                            'icon' => 'alat.svg'
                        ]
                    ];
                @endphp

                @foreach ($cards as $card)
                    @php
                        // Tentukan URL Link Berdasarkan Judul
                        $url = '#';
                        if ($card['title'] == 'Data Pribadi Siswa') $url = route('data_pribadi');
                        elseif ($card['title'] == 'RIASEC') $url = route('riasec.index');
                        elseif ($card['title'] == 'Motivasi Belajar') $url = route('motivasi.index');
                        elseif ($card['title'] == 'Studi Habit & Gaya Belajar') $url = route('studi_habit.index');
                        elseif ($card['title'] == 'Sosial Emosional & Kesehatan Mental') $url = route('sosial_emosional.index');
                        elseif ($card['title'] == 'Preferensi Kelompok & Kebutuhan Sosial') $url = route('preferensi_kelompok.index');
                        elseif ($card['title'] == 'Alat Ungkap Masalah') $url = route('aum.index');
                    @endphp

                    <a href="{{ $url }}" class="bg-white shadow rounded-xl p-5 border border-gray-100 transform hover:shadow-lg transition duration-200 cursor-pointer block h-full flex flex-col justify-between group">
                        <div>
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-[#d8e4ff] rounded flex items-center justify-center flex-shrink-0 group-hover:bg-[#FFE27A] transition">
                                    {{-- Pastikan file icon ada di public/icons/ --}}
                                    <img src="{{ asset('storage/icons/' . $card['icon']) }}" alt="{{ $card['title'] }}" class="h-6 w-6 object-contain" />
                                </div>
                                <h3 class="font-bold text-[17px] text-[#0A2A43] leading-tight">{{ $card['title'] }}</h3>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">{{ $card['desc'] }}</p>
                        </div>

                        <div>
                            @if ($card['completed'])
                                {{-- SUDAH DIKERJAKAN (ORANGE) --}}
                                <button type="button" class="w-full bg-orange-500 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-orange-600 transition flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Sudah Dikerjakan
                                </button>
                            @else
                                {{-- BELUM DIKERJAKAN (ABU-ABU) --}}
                                <button type="button" class="w-full bg-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-300 transition">
                                    Belum Dikerjakan
                                </button>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- KOLOM KANAN (Aktivitas Terkini) --}}
            <div class="col-span-1">
                <div class="bg-white shadow-md rounded-xl p-5 sticky top-20">
                    <h3 class="font-bold text-[18px] mb-4 flex items-center gap-2 text-[#0A2A43] border-b pb-2">
                        {{--  " alt="Aktivitas" class="h-5 w-5 object-contain" /> --}}
                        Aktivitas Terkini
                    </h3>

                    @foreach ($aktivitas as $item)
                        <div class="border-l-[3px] border-[#FFE27A] pl-3 mb-4 last:mb-0 animate-fade-in-up">
                            <h4 class="font-semibold text-[#0A2A43]">{{ $item['title'] }}</h4>
                            <p class="text-gray-600 text-sm">{{ $item['desc'] }}</p>
                            <p class="text-gray-500 text-xs mt-1 italic">{{ $item['time'] }}</p>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#0A2A43] text-white text-center mt-10 py-5 text-sm">
        Copyright (c) SMKN 5 Malang {{ date('Y') }}. All rights reserved.
    </footer>
</body>
</html>
