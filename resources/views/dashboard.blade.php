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
                    use Illuminate\Support\Facades\Auth;
                    use Illuminate\Support\Facades\DB;
                    use App\Models\SiswaData;     // Pastikan Model ini ada
                    use App\Models\RiasecResult;  // Pastikan Model ini ada

                    $userId = Auth::id();

                    // --- LOGIKA PENGECEKAN STATUS (Cek Database) ---

                    // 1. Data Pribadi (Menggunakan Model SiswaData)
                    $statusDataPribadi = SiswaData::where('user_id', $userId)->exists();

                    // 2. RIASEC (Menggunakan Model RiasecResult)
                    // Pastikan tabelnya benar (biasanya plural: riasec_results)
                    $statusRiasec = RiasecResult::where('user_id', $userId)->exists();

                    // 3. Motivasi Belajar (Menggunakan Query Builder - Asumsi nama tabel 'motivasi_belajar_results' atau sesuaikan)
                    // Jika Anda belum buat tabel, ini akan error. Pastikan tabel ada.
                    // Gunakan try-catch atau pastikan tabel exist jika ragu. Di sini saya asumsikan tabel ada.
                    $statusMotivasi = DB::table('motivasi_belajar')->where('user_id', $userId)->exists();

                    // 4. Studi Habit (Menggunakan Query Builder)
                    $statusStudiHabit = DB::table('studi_habit')->where('user_id', $userId)->exists();

                    // 5. Sosial Emosional (Menggunakan Query Builder)
                    $statusSosialEmosional = DB::table('sosial_emosional')->where('user_id', $userId)->exists();

                    // 6. Preferensi Kelompok (Menggunakan Query Builder)
                    $statusPreferensi = DB::table('preferensi_kelompok')->where('user_id', $userId)->exists();


                    // --- DEFINISI KARTU ---
                    $cards = [
                        [
                            'title' => 'Data Pribadi Siswa',
                            'desc' => 'Lengkapi informasi dasar sebagai identitas awal untuk analisis tes selanjutnya.',
                            'completed' => $statusDataPribadi,
                            'icon' => 'user.svg'
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
                            'icon' => 'motivation.svg'
                        ],
                        [
                            'title' => 'Studi Habit & Gaya Belajar',
                            'desc' => 'Ketahui kebiasaan belajarmu dan metode belajar yang paling cocok untukmu.',
                            'completed' => $statusStudiHabit,
                            'icon' => 'habit.svg'
                        ],
                        [
                            'title' => 'Sosial Emosional & Kesehatan Mental',
                            'desc' => 'Pahami kondisi emosimu, tingkat stres, dan kesejahteraan mentalmu secara umum.',
                            'completed' => $statusSosialEmosional,
                            'icon' => 'mental.svg'
                        ],
                        [
                            'title' => 'Preferensi Kelompok & Kebutuhan Sosial',
                            'desc' => 'Kenali kecenderunganmu dalam bekerja sama dan kebutuhan sosial di lingkungan belajar.',
                            'completed' => $statusPreferensi,
                            'icon' => 'group.svg'
                        ],
                        // Tes lain yang belum diimplementasikan logikanya (Default: False)
                        [
                            'title' => 'Skala Preferensi Belajar',
                            'desc' => 'Temukan gaya belajar utama yang paling memengaruhi efektivitas belajarmu.',
                            'completed' => false,
                            'icon' => 'book.svg'
                        ],
                        [
                            'title' => 'Alat Ungkap Masalah',
                            'desc' => 'Identifikasi permasalahan belajar, pribadi, atau sosial yang sedang kamu hadapi.',
                            'completed' => false,
                            'icon' => 'checklist.svg'
                        ],
                    ];
                @endphp

                @foreach ($cards as $card)
                    @php
                        // Tentukan URL Link
                        $url = '#';
                        if ($card['title'] == 'Data Pribadi Siswa') $url = route('data_pribadi');
                        elseif ($card['title'] == 'RIASEC') $url = route('riasec.index');
                        elseif ($card['title'] == 'Motivasi Belajar') $url = route('motivasi.index');
                        elseif ($card['title'] == 'Studi Habit & Gaya Belajar') $url = route('studi_habit.index');
                        elseif ($card['title'] == 'Sosial Emosional & Kesehatan Mental') $url = route('sosial_emosional.index'); // Pastikan route ini ada
                        elseif ($card['title'] == 'Preferensi Kelompok & Kebutuhan Sosial') $url = route('preferensi_kelompok.index'); // Pastikan route ini ada
                    @endphp

                    <a href="{{ $url }}" class="bg-white shadow rounded-xl p-5 border border-gray-100 transform hover:shadow-lg transition duration-200 cursor-pointer block h-full flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-[#d8e4ff] rounded flex items-center justify-center flex-shrink-0">
                                    <img src="{{ asset('icons/' . $card['icon']) }}" alt="{{ $card['title'] }}" class="h-6 w-6 object-contain" />
                                </div>
                                <h3 class="font-bold text-[17px] text-[#0A2A43] leading-tight">{{ $card['title'] }}</h3>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">{{ $card['desc'] }}</p>
                        </div>

                        {{-- LOGIKA TOMBOL STATUS --}}
                        <div>
                            @if ($card['completed'])
                                {{-- JIKA SUDAH DIKERJAKAN: WARNA ORANGE --}}
                                <button type="button" class="w-full bg-orange-500 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-orange-600 transition">
                                    Sudah Dikerjakan
                                </button>
                            @else
                                {{-- JIKA BELUM DIKERJAKAN: WARNA ABU-ABU --}}
                                <button type="button" class="w-full bg-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-300 transition">
                                    Belum Dikerjakan
                                </button>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- KOLOM KANAN (Aktivitas Terkini) --}}
            {{-- KOLOM KANAN (Aktivitas Terkini) --}}
<div class="col-span-1">
    <div class="bg-white shadow-md rounded-xl p-5 sticky top-20">
        <h3 class="font-bold text-[18px] mb-4 flex items-center gap-2 text-[#0A2A43] border-b pb-2">
            {{-- Pastikan path icon benar --}}
            <img src="{{ asset('icons/activity.svg') }}" alt="Aktivitas" class="h-5 w-5 object-contain" />
            Aktivitas Terkini
        </h3>

        {{-- Looping Data Dinamis dari Controller --}}
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
