<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Sosial Emosional - SMK5TEST</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Styling Custom Radio agar mirip Google Form */
        .custom-radio-input:checked + div {
            border-color: #652D90;
            background-color: #f3e8ff;
        }
        .custom-radio-input:checked + div .radio-inner {
            background-color: #652D90;
            transform: scale(1);
        }
        .radio-option:hover div {
            border-color: #652D90;
        }
        input[type="radio"]:checked + div {
            border-color: #652D90;
            background-color: #f3e8ff;
        }
        input[type="radio"]:checked + div > div {
            background-color: #652D90;
        }
        label:hover input[type="radio"] + div {
            border-color: #652D90;
        }
    </style>
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col font-sans">

    {{-- DATA SOAL --}}
    @php
        $sections = [
            'Hubungan dengan Teman Sebaya' => [
                ['type' => 'radio5', 'question' => 'Seberapa sering Anda bergaul dengan teman-teman di luar jam sekolah?', 'name' => 'hubungan_teman_1', 'options' => ['Setiap hari', 'Beberapa kali seminggu', 'Beberapa kali sebulan', 'Jarang', 'Tidak pernah']],
                ['type' => 'radio5', 'question' => 'Bagaimana Anda menilai kualitas hubungan Anda dengan teman-teman di sekolah?', 'name' => 'hubungan_teman_2', 'options' => ['Sangat baik', 'Baik', 'Cukup', 'Kurang baik', 'Sangat buruk']],
                ['type' => 'radio5', 'question' => 'Apakah Anda pernah merasa sulit untuk menjalin pertemanan?', 'name' => 'hubungan_teman_3', 'options' => ['Tidak pernah', 'Jarang', 'Kadang-kadang', 'Sering', 'Sangat sering']]
            ],
            'Kegiatan Ekstrakurikuler dan Sosial' => [
                ['type' => 'radio2', 'question' => 'Apakah Anda terlibat dalam kegiatan ekstrakurikuler atau organisasi di sekolah?', 'name' => 'ekstrakurikuler_1', 'options' => ['Ya', 'Tidak']],
                ['type' => 'text', 'question' => 'Jika ya, sebutkan kegiatan atau organisasi yang Anda ikuti.', 'name' => 'ekstrakurikuler_2', 'placeholder' => 'Ketik jawaban Anda di sini...'],
                ['type' => 'radio5', 'question' => 'Bagaimana perasaan Anda tentang keterlibatan Anda dalam kegiatan tersebut?', 'name' => 'ekstrakurikuler_3', 'options' => ['Sangat puas', 'Puas', 'Netral', 'Tidak puas', 'Sangat tidak puas']]
            ],
            'Pengalaman Bullying' => [
                ['type' => 'radio5', 'question' => 'Apakah Anda pernah menjadi korban bullying di sekolah?', 'name' => 'bullying_korban_1', 'options' => ['Tidak pernah', 'Jarang', 'Kadang-kadang', 'Sering', 'Sangat sering']],
                ['type' => 'radio5', 'question' => 'Apakah Anda pernah menyaksikan orang lain menjadi korban bullying di sekolah?', 'name' => 'bullying_saksi_1', 'options' => ['Tidak pernah', 'Jarang', 'Kadang-kadang', 'Sering', 'Sangat sering']],
                ['type' => 'radio2', 'question' => 'Jika Anda pernah mengalami atau menyaksikan bullying, apakah Anda melaporkannya kepada seseorang?', 'name' => 'bullying_laporan_1', 'options' => ['Ya', 'Tidak']]
            ],
            'Keterampilan Sosial dan Kepercayaan Diri' => [
                ['type' => 'radio5', 'question' => 'Seberapa nyaman Anda berbicara di depan umum atau dalam kelompok besar?', 'name' => 'percaya_diri_nyaman_bicara', 'options' => ['Sangat nyaman', 'Nyaman', 'Cukup nyaman', 'Tidak nyaman', 'Sangat tidak nyaman']],
                ['type' => 'radio5', 'question' => 'Bagaimana Anda menilai tingkat kepercayaan diri Anda dalam situasi sosial?', 'name' => 'percaya_diri_1', 'options' => ['Sangat percaya diri', 'Percaya diri', 'Cukup percaya diri', 'Kurang percaya diri', 'Sangat kurang percaya diri']]
            ],
            'Dukungan Sosial' => [
                ['type' => 'radio5', 'question' => 'Apakah Anda merasa memiliki seseorang yang bisa diajak berbicara ketika menghadapi masalah?', 'name' => 'dukungan_sosial_bicara', 'options' => ['Ya, selalu', 'Ya, kadang-kadang', 'Jarang', 'Tidak pernah']],
                ['type' => 'radio5', 'question' => 'Seberapa sering Anda merasa didukung oleh teman-teman atau keluarga Anda?', 'name' => 'dukungan_sosial_1', 'options' => ['Sangat sering', 'Sering', 'Kadang-kadang', 'Jarang', 'Tidak pernah']]
            ],
            'Perasaan dan Emosi' => [
                ['type' => 'radio5', 'question' => 'Seberapa sering Anda merasa bahagia dan puas dengan kehidupan Anda sehari-hari?', 'name' => 'perasaan_emosi_bahagia', 'options' => ['Sangat sering', 'Sering', 'Kadang-kadang', 'Jarang', 'Tidak pernah']],
                ['type' => 'radio5', 'question' => 'Apakah Anda pernah merasa kesepian atau terisolasi?', 'name' => 'perasaan_emosi_kesepian', 'options' => ['Tidak pernah', 'Jarang', 'Kadang-kadang', 'Sering', 'Sangat sering']],

                // PERBAIKAN 1: Mengubah type menjadi 'radio2' karena opsinya berupa kalimat panjang (bukan skala)
                ['type' => 'radio2', 'question' => 'Bagaimana perasaan Anda dalam dua minggu terakhir?', 'name' => 'perasaan_emosi_dua_minggu', 'options' => ['Selalu bahagia dan bersemangat', 'Kadang-kadang merasa bahagia dan bersemangat', 'Sering merasa sedih atau cemas', 'Selalu merasa sedih atau cemas']]
            ]
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

    <main class="grow py-8 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-3xl mx-auto">

            <form action="{{ route('sosial_emosional.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- JUDUL FORM --}}
                <div class="bg-[#0A2A43] rounded-t-xl p-6 text-center shadow-lg">
                    <h1 class="text-2xl font-bold text-white mb-2">Tes Sosial Emosional - Bagian 1</h1>
                    <div class="inline-block bg-[#FFE27A] text-[#0A2A43] px-4 py-1 rounded-full font-bold text-sm">
                        Data Sosial dan Emosional
                    </div>
                </div>

                {{-- LOOPING SOAL --}}
                @foreach($sections as $categoryTitle => $questions)
                    <div class="bg-yellow-50 border-l-4 border-[#FFE27A] p-4 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-1 rounded-full bg-[#FFE27A]"></div>
                            <h2 class="text-xl font-bold text-gray-800">{{ $categoryTitle }}</h2>
                        </div>
                    </div>

                    @foreach($questions as $index => $question)
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md mb-4">
        <p class="text-gray-800 font-medium text-lg mb-6">{{ $question['question'] }}</p>

        {{-- TIPE 1: SKALA 1-5 (Sudah dibahas sebelumnya) --}}
        @if($question['type'] == 'radio5')
            {{-- ... (Kode radio5 yang sudah benar) ... --}}
             <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">{{ $question['options'][0] }}</span>
                <div class="flex items-center justify-center gap-4 sm:gap-8 w-full sm:w-auto">
                    @for ($i = 0; $i < count($question['options']); $i++)
                    <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                        <span class="text-xs text-gray-400 font-medium mb-1">{{ $i + 1 }}</span>
                        <input type="radio" 
                               name="{{ $question['name'] }}" 
                               value="{{ $question['options'][$i] }}" 
                               class="custom-radio-input sr-only"
                               {{-- LOGIKA SESSION --}}
                               @if(isset($currentSession[$question['name']]) && $currentSession[$question['name']] == $question['options'][$i]) checked @endif
                               required>
                        <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                            <div class="radio-inner w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                        </div>
                    </label>
                    @endfor
                </div>
                <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">{{ end($question['options']) }}</span>
            </div>

        {{-- TIPE 2: RADIO BUTTON BIASA / YES-NO / PILIHAN PANJANG --}}
        {{-- Menangani: "Apakah Anda terlibat ekskul?", "Apakah lapor bullying?", "Perasaan 2 minggu terakhir" --}}
        @elseif($question['type'] == 'radio2')
        <div class="space-y-3">
            @foreach($question['options'] as $option)
            <label class="cursor-pointer flex items-center gap-3 p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                <input type="radio" 
                       name="{{ $question['name'] }}" 
                       value="{{ $option }}" 
                       class="sr-only"
                       {{-- LOGIKA: Cek apakah opsi ini sama dengan yang tersimpan di session --}}
                       @if(isset($currentSession[$question['name']]) && $currentSession[$question['name']] == $option) checked @endif
                       required>
                
                {{-- Styling Radio Button --}}
                <div class="w-5 h-5 border-2 border-gray-400 rounded-full flex items-center justify-center transition-all">
                    <div class="w-2.5 h-2.5 rounded-full bg-transparent transition-all"></div>
                </div>
                <span class="text-gray-700 font-medium">{{ $option }}</span>
            </label>
            @endforeach
        </div>

        {{-- TIPE 3: ISIAN TEXT --}}
        {{-- Menangani: "Jika ya, sebutkan kegiatan..." --}}
        @elseif($question['type'] == 'text')
        <input type="text" 
               name="{{ $question['name'] }}" 
               {{-- LOGIKA: Isi value dengan data session jika ada --}}
               value="{{ $currentSession[$question['name']] ?? '' }}"
               placeholder="{{ $question['placeholder'] }}" 
               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-[#0A2A43] focus:ring-1 focus:ring-[#0A2A43] transition">
        @endif
        
    </div>
    @endforeach
                @endforeach

                {{-- TOMBOL NAVIGASI --}}
                <div class="mt-10 flex justify-between gap-4">
                    <a href="{{ route('sosial_emosional.index') }}" class="w-1/2 text-center bg-gray-200 text-gray-700 font-bold text-lg py-3 px-6 rounded-xl shadow hover:bg-gray-300 transition duration-200">
                        Kembali
                    </a>

                    <button type="submit" class="w-1/2 text-center bg-[#0A2A43] text-white font-bold text-lg py-3 px-6 rounded-xl shadow-lg hover:bg-[#143d5e] transition duration-200">
                        Selanjutnya
                    </button>
                </div>
            </form>
        </div>
    </main>

    <footer class="bg-[#0A2A43] text-white/70 text-center py-6 text-sm mt-auto">
        Copyright &copy; SMKN 5 Malang {{ date('Y') }}. All rights reserved.
    </footer>

</body>
</html>
