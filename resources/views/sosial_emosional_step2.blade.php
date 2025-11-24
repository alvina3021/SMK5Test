<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Kesehatan Mental - SMK5TEST</title>
    {{-- Pastikan Vite sudah terload --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Styling Custom Radio agar mirip Google Form */
        .custom-radio-input:checked + div {
            border-color: #652D90; /* Warna Ungu Utama */
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

        /* Styling untuk radio button */
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

    {{-- 1. DATA SOAL LENGKAP --}}
    @php
        $sections = [
            'Kesehatan Mental' => [
                [
                    'type' => 'likert4',
                    'question' => 'Seberapa sering Anda merasa cemas atau khawatir tentang hal-hal sehari-hari?',
                    'name' => 'kesehatan_mental_cemas'
                ],
                [
                    'type' => 'likert4_tidur',
                    'question' => 'Bagaimana kualitas tidur Anda dalam sebulan terakhir?',
                    'name' => 'kesehatan_mental_tidur',
                    'options' => ['Selalu nyenyak dan cukup tidur', 'Jarang sulit tidur atau bangun terlalu pagi', 'Sering sulit tidur atau sering terbangun', 'Selalu sulit tidur atau merasa tidak pernah cukup tidur']
                ],
                [
                    'type' => 'likert4',
                    'question' => 'Seberapa sering Anda merasa lelah atau kurang energi?',
                    'name' => 'kesehatan_mental_energi'
                ],
                [
                    'type' => 'likert4',
                    'question' => 'Apakah Anda pernah merasa kesulitan untuk berkonsentrasi pada tugas atau pelajaran?',
                    'name' => 'kesehatan_mental_konsentrasi'
                ],
                [
                    'type' => 'likert4',
                    'question' => 'Seberapa sering Anda merasa tidak berharga atau merasa bersalah tentang hal-hal kecil?',
                    'name' => 'kesehatan_mental_bersalah'
                ],
                [
                    'type' => 'likert4',
                    'question' => 'Apakah Anda pernah memiliki pikiran untuk menyakiti diri sendiri atau bunuh diri?',
                    'name' => 'kesehatan_mental_pikiran_buruk'
                ],
                [
                    'type' => 'likert4',
                    'question' => 'Seberapa sering Anda merasa tegangan atau stress?',
                    'name' => 'kesehatan_mental_stress'
                ],
                [
                    'type' => 'likert4_kesejahteraan',
                    'question' => 'Bagaimana Anda menilai kesejahteraan emosional Anda secara keseluruhan?',
                    'name' => 'kesehatan_mental_kesejahteraan',
                    'options' => ['Sangat baik', 'Baik', 'Sedang', 'Buruk']
                ],
                [
                    'type' => 'likert4_dukungan',
                    'question' => 'Apakah Anda merasa memiliki dukungan sosial yang cukup dari teman atau keluarga?',
                    'name' => 'kesehatan_mental_dukungan',
                    'options' => ['Selalu', 'Sering', 'Jarang', 'Tidak pernah']
                ]
            ]
        ];
    @endphp

    <nav class="bg-[#0A2A43] text-white px-10 py-4 flex justify-between items-center shadow-lg sticky top-0 z-10">
        <div class="flex items-center gap-3">
            <span class="text-xl font-serif font-bold">SMK5TEST</span>
        </div>

        {{-- MENU NAVIGASI --}}
        <ul class="gap-8 text-white/80 font-semibold hidden md:flex mx-auto">
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

    <main class="grow py-8 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-3xl mx-auto">
            <form action="{{ route('sosial_emosional_step2.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- JUDUL FORM --}}
                <div class="bg-[#0A2A43] rounded-t-xl p-6 text-center shadow-lg">
                    <h1 class="text-2xl font-bold text-white mb-2">Tes Sosial Emosional - Bagian 2</h1>
                    <div class="inline-block bg-[#FFE27A] text-[#0A2A43] px-4 py-1 rounded-full font-bold text-sm">
                        Kesehatan Mental
                    </div>
                </div>

                {{-- BAGIAN SOAL (LOOPING OTOMATIS) --}}
                @foreach($sections as $categoryTitle => $questions)

                    {{-- Judul Kategori --}}
                    <div class="bg-yellow-50 border-l-4 border-[#FFE27A] p-4 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-1 rounded-full bg-[#FFE27A]"></div>
                            <h2 class="text-xl font-bold text-gray-800">{{ $categoryTitle }}</h2>
                        </div>
                    </div>

                    @foreach($questions as $index => $question)
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md mb-4">
                        {{-- Soal --}}
                        <p class="text-gray-800 font-medium text-lg mb-6">{{ $question['question'] }}</p>

                        {{-- TIPE: LIKERT SCALE 4 (SKALA NUMERIK) --}}
                        @if($question['type'] == 'likert4')
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                            <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Tidak pernah</span>

                            <div class="flex items-center justify-center gap-4 sm:gap-8 w-full sm:w-auto">
                                @for ($i = 1; $i <= 4; $i++)
                                <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                    <span class="text-xs text-gray-400 font-medium mb-1">{{ $i }}</span>
                                    <input type="radio"
                                           name="{{ $question['name'] }}"
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

                            <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Sangat sering</span>
                        </div>

                        {{-- TIPE: LIKERT SCALE 4 (TIDUR - VERTICAL) --}}
                        @elseif($question['type'] == 'likert4_tidur')
                        <div class="space-y-3">
                            @foreach($question['options'] as $option)
                            <label class="cursor-pointer flex items-center gap-3 p-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                <input type="radio"
                                       name="{{ $question['name'] }}"
                                       value="{{ $loop->index + 1 }}"
                                       class="sr-only"
                                       required>
                                <div class="w-5 h-5 border-2 border-gray-400 rounded-full flex items-center justify-center transition-all">
                                    <div class="w-2.5 h-2.5 rounded-full bg-transparent transition-all"></div>
                                </div>
                                <span class="text-gray-700 font-medium">{{ $option }}</span>
                            </label>
                            @endforeach
                        </div>

                        {{-- TIPE: LIKERT SCALE 4 (KESEJAHTERAAN - HORIZONTAL SKALA) --}}
                        @elseif($question['type'] == 'likert4_kesejahteraan')
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                            <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Buruk</span>

                            <div class="flex items-center justify-center gap-4 sm:gap-8 w-full sm:w-auto">
                                @for ($i = 1; $i <= 4; $i++)
                                <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                    <span class="text-xs text-gray-400 font-medium mb-1">{{ $i }}</span>
                                    <input type="radio"
                                           name="{{ $question['name'] }}"
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

                            <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Sangat baik</span>
                        </div>

                        {{-- TIPE: LIKERT SCALE 4 (DUKUNGAN - HORIZONTAL SKALA) --}}
                        @elseif($question['type'] == 'likert4_dukungan')
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                            <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Tidak pernah</span>

                            <div class="flex items-center justify-center gap-4 sm:gap-8 w-full sm:w-auto">
                                @for ($i = 1; $i <= 4; $i++)
                                <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                    <span class="text-xs text-gray-400 font-medium mb-1">{{ $i }}</span>
                                    <input type="radio"
                                           name="{{ $question['name'] }}"
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

                            <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Selalu</span>
                        </div>
                        @endif
                    </div>
                    @endforeach
                @endforeach


                {{-- TOMBOL NAVIGASI --}}
                <div class="mt-10 flex justify-between gap-4">
                     <a href="{{ route('sosial_emosional.form') }}" class="w-1/2 text-center bg-gray-200 text-gray-700 font-bold text-lg py-3 px-6 rounded-xl shadow hover:bg-gray-300 transition duration-200">
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
