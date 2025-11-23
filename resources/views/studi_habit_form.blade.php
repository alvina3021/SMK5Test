<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Studi Habit - SMK5TEST</title>
    {{-- Pastikan Vite sudah terload --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Styling Custom Radio agar mirip Google Form & Sesuai Tema */
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
    </style>
</head>
<body class="bg-[#F4F1FF] min-h-screen flex flex-col font-sans">

    {{-- 1. DATA SOAL LENGKAP (Dari Attachment Gambar) --}}
    @php
        $sections = [
            'A. Studi Habit' => [
                'Saya memiliki waktu khusus untuk belajar setiap hari.',
                'Saya belajar di tempat yang tenang dan bebas gangguan.',
                'Saya memiliki jadwal belajar yang teratur.',
                'Saya termotivasi belajar karena ingin meraih cita-cita.',
                'Saya menyelesaikan tugas tepat waktu.',
                'Saya belajar kembali materi setelah pelajaran selesai.',
                'Saya belajar saat menjelang ujian saja.',
                'Saya sering menunda-nunda waktu belajar.',
                'Saya bisa mengatur waktu antara belajar dan bermain.',
                'Saya belajar lebih baik jika suasana hati saya baik.',
                'Saya belajar karena saya merasa bertanggung jawab.',
                'Saya memiliki tempat khusus untuk belajar di rumah.'
            ]
        ];
    @endphp

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

    <main class="flex-grow py-8 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-3xl mx-auto">
            <form action="{{ route('studi_habit.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- JUDUL FORM --}}
                <div class="bg-[#0A2A43] rounded-t-xl p-6 text-center shadow-lg">
                    <h1 class="text-2xl font-bold text-white mb-2">Tes Kebiasaan Belajar (Studi Habit)</h1>
                    <div class="inline-block bg-[#FFE27A] text-[#0A2A43] px-4 py-1 rounded-full font-bold text-sm">
                        Psikologi Pendidikan
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
                        <p class="text-gray-800 font-medium text-lg mb-6">{{ $question }} <span class="text-red-500">*</span></p>

                        {{-- Skala 1-5 (Tidak Pernah s/d Selalu) --}}
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">

                            <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Tidak Pernah</span>

                            <div class="flex items-center justify-center gap-3 sm:gap-5 w-full sm:w-auto">
                                {{-- Loop 1 sampai 5 --}}
                                @for ($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                    <span class="text-xs text-gray-400 font-medium mb-1">{{ $i }}</span>
                                    <input type="radio"
                                           {{-- Name dibuat unik berdasarkan kategori & index --}}
                                           name="ans_{{ Str::slug($categoryTitle) }}_{{ $index }}"
                                           value="{{ $i }}"
                                           class="custom-radio-input sr-only"
                                           required>

                                    {{-- Custom Radio Circle --}}
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                        <div class="radio-inner w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                                    </div>
                                </label>
                                @endfor
                            </div>

                            <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Selalu</span>
                        </div>
                    </div>
                    @endforeach
                @endforeach


                {{-- TOMBOL NAVIGASI --}}
                <div class="mt-10 flex justify-between gap-4">
                     <a href="{{ route('studi_habit.index') }}" class="w-1/2 text-center bg-gray-200 text-gray-700 font-bold text-lg py-3 px-6 rounded-xl shadow hover:bg-gray-300 transition duration-200">
                        Kembali
                     </a>

                    <button type="submit" class="w-1/2 bg-[#0A2A43] text-white font-bold text-lg py-3 px-6 rounded-xl shadow-lg hover:bg-[#143d5e] transition duration-200 text-center">
                        Selanjutnya
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
