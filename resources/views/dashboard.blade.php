<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col">

    {{-- HEADER / NAVIGATION BAR (Warna #0A2A43) --}}
    <nav class="bg-[#0A2A43] text-white px-10 py-4 flex justify-between items-center shadow-lg sticky top-0 z-10">
        <div class="flex items-center gap-3">
            <span class="text-xl font-serif font-bold">SMK5TEST</span>
        </div>

        {{-- MENU NAVIGASI --}}
        <ul class="flex gap-8 text-white/80 font-semibold hidden md:flex mx-auto">
            <li><a href="{{ route('dashboard') }}" class="text-white hover:text-[#FFE27A] border-b-2 border-white pb-1">Dashboard</a></li>
            <li><a href="#" class="hover:text-white pb-1 border-b-2 border-transparent">Tes Saya</a></li>
            <li><a href="#" class="hover:text-white pb-1 border-b-2 border-transparent">Materi</a></li>
        </ul>

        {{-- PROFIL --}}
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
                    // Data dummy kartu dengan path ikon
                    $cards = [
                        ['title' => 'Data Pribadi Siswa', 'desc' => 'Lengkapi informasi dasar sebagai identitas awal untuk analisis tes selanjutnya.', 'status' => 'Selesai', 'icon' => 'user.svg'],
                        ['title' => 'RIASEC', 'desc' => 'Kenali minat kariermu berdasarkan tipe kepribadian Holland (RIASEC).', 'status' => 'Belum Dikerjakan', 'icon' => 'riasec.svg'],
                        ['title' => 'Skala Preferensi Belajar', 'desc' => 'Temukan gaya belajar utama yang paling memengaruhi efektivitas belajarmu.', 'status' => 'Belum Dikerjakan', 'icon' => 'book.svg'],
                        ['title' => 'Motivasi Belajar', 'desc' => 'Cari tahu seberapa besar motivasi yang kamu miliki dalam menjalani proses belajar.', 'status' => 'Belum Dikerjakan', 'icon' => 'motivation.svg'],
                        ['title' => 'Studi Habit & Gaya Belajar', 'desc' => 'Ketahui kebiasaan belajarmu dan metode belajar yang paling cocok untukmu.', 'status' => 'Belum Dikerjakan', 'icon' => 'habit.svg'],
                        ['title' => 'Sosial Emosional & Kesehatan Mental', 'desc' => 'Pahami kondisi emosimu, tingkat stres, dan kesejahteraan mentalmu secara umum.', 'status' => 'Belum Dikerjakan', 'icon' => 'mental.svg'],
                        ['title' => 'Preferensi Kelompok & Kebutuhan Sosial', 'desc' => 'Kenali kecenderunganmu dalam bekerja sama dan kebutuhan sosial di lingkungan belajar.', 'status' => 'Belum Dikerjakan', 'icon' => 'group.svg'],
                        ['title' => 'Alat Ungkap Masalah', 'desc' => 'Identifikasi permasalahan belajar, pribadi, atau sosial yang sedang kamu hadapi.', 'status' => 'Belum Dikerjakan', 'icon' => 'checklist.svg'],
                    ];
                @endphp

                @foreach ($cards as $card)
    @php
        // Tentukan URL berdasarkan judul kartu
        $url = '#'; // Default untuk kartu yang belum punya halaman

        if ($card['title'] == 'Data Pribadi Siswa') {
            // Gunakan rute yang sudah didefinisikan di web.php
            $url = route('data_pribadi');
        }
        elseif ($card['title'] == 'RIASEC') {
            // PERBAIKAN: Mengarahkan ke route riasec.index
            $url = route('riasec.index');
         }
        // --- PERUBAHAN DI SINI: MENAMBAHKAN LINK KE MOTIVASI BELAJAR ---
        elseif ($card['title'] == 'Motivasi Belajar') {
             $url = route('motivasi.index');
        }
        // --- MENAMBAHKAN LINK KE STUDI HABIT ---
        elseif ($card['title'] == 'Studi Habit & Gaya Belajar') {
             $url = route('studi_habit.index');
        }
    @endphp

    {{-- Gunakan <a> sebagai wrapper yang bisa diklik --}}
    <a href="{{ $url }}" class="bg-white shadow rounded-xl p-5 border border-gray-100 transform hover:shadow-lg transition duration-200 cursor-pointer block h-full">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-[#d8e4ff] rounded flex items-center justify-center flex-shrink-0">
                {{-- Menampilkan ikon dari path yang diberikan --}}
                <img src="{{ asset('icons/' . $card['icon']) }}" alt="{{ $card['title'] }}" class="h-6 w-6 object-contain" />
            </div>
            <h3 class="font-bold text-[17px] text-[#0A2A43]">{{ $card['title'] }}</h3>
        </div>
        <p class="text-gray-600 text-sm mb-4">{{ $card['desc'] }}</p>

        {{-- Button dipertahankan di dalam tautan untuk styling status --}}
        @if ($card['status'] == 'Selesai')
            <button type="button" class="bg-[#FFE27A] text-gray-800 px-4 py-1 rounded-lg text-sm font-semibold">Sudah Selesai</button>
        @else
            <button type="button" class="bg-gray-200 text-gray-600 px-4 py-1 rounded-lg text-sm font-semibold">Belum Dikerjakan</button>
        @endif
    </a>
@endforeach
            </div>

            {{-- KOLOM KANAN (Aktivitas Terkini) --}}
            <div class="col-span-1">
                <div class="bg-white shadow-md rounded-xl p-5 sticky top-20">
                    <h3 class="font-bold text-[18px] mb-4 flex items-center gap-2 text-[#0A2A43] border-b pb-2">
                        <img src="{{ asset('icons/activity.svg') }}" alt="Aktivitas" class="h-5 w-5 object-contain" /> Aktivitas Terkini
                    </h3>

                    @php
                        // Data aktivitas dummy
                        $aktivitas = [
                            ['title' => 'Tes Minat dan Kepribadian Selesai', 'desc' => 'Lihat materi pembelajaran dari guru tanpa proyektor.', 'time' => '4 hari yang lalu'],
                            ['title' => 'Materi Baru: Pemrograman Web Lanjutan', 'desc' => 'Pak Budi mengunggah materi baru tentang Framework Laravel.', 'time' => '4 hari yang lalu'],
                            ['title' => 'Reminder: Tes Potensi & Bakat (Aptitude)', 'desc' => 'Jangan lupa untuk menyelesaikan Tes Minat & Bakat.', 'time' => '3 hari yang lalu'],
                        ];
                    @endphp

                    @foreach ($aktivitas as $item)
                        <div class="border-l-[3px] border-[#FFE27A] pl-3 mb-4 last:mb-0">
                            <h4 class="font-semibold text-[#0A2A43]">{{ $item['title'] }}</h4>
                            <p class="text-gray-600 text-sm">{{ $item['desc'] }}</p>
                            <p class="text-gray-500 text-xs mt-1">{{ $item['time'] }}</p>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
    </main>

    {{-- FOOTER (Warna #0A2A43) --}}
    <footer class="bg-[#0A2A43] text-white text-center mt-10 py-5 text-sm">
        Copyright (c) SMKN 5 Malang {{ date('Y') }}. All rights reserved.
    </footer>
</body>
</html>
