<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaya Belajar - SMK5TEST</title>
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
            <form action="{{ route('studi_habit.store_step2') }}" method="POST" class="space-y-6">
                @csrf

                {{-- JUDUL FORM --}}
                <div class="bg-[#0A2A43] rounded-t-xl p-6 text-center shadow-lg">
                    <h1 class="text-2xl font-bold text-white mb-2">Gaya Belajar Anda</h1>
                    <div class="inline-block bg-[#FFE27A] text-[#0A2A43] px-4 py-1 rounded-full font-bold text-sm">
                        Identifikasi Gaya Belajar
                    </div>
                </div>

                {{-- ==================== VISUAL ==================== --}}
                <div class="bg-yellow-50 border-l-4 border-[#FFE27A] p-4 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-1 rounded-full bg-[#FFE27A]"></div>
                        <h2 class="text-xl font-bold text-gray-800">VISUAL</h2>
                    </div>
                </div>

                {{-- Pertanyaan 1: Visual --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md mb-4">
                    <p class="text-gray-800 font-medium text-lg mb-6">Saya lebih mudah memahami pelajaran melalui gambar atau diagram.</p>
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Sangat tidak sesuai</span>
                        <div class="flex items-center justify-center gap-4 sm:gap-8 w-full sm:w-auto">
                            @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                <span class="text-xs text-gray-400 font-medium mb-1">{{ $i }}</span>
                                <input type="radio" name="visual_1" value="{{ $i }}" class="custom-radio-input sr-only" required>
                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                    <div class="radio-inner w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                                </div>
                            </label>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Sangat sesuai</span>
                    </div>
                </div>

                {{-- Pertanyaan 2: Visual --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md mb-4">
                    <p class="text-gray-800 font-medium text-lg mb-6">Saya suka mencatat dengan warna atau simbol.</p>
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Sangat tidak sesuai</span>
                        <div class="flex items-center justify-center gap-4 sm:gap-8 w-full sm:w-auto">
                            @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                <span class="text-xs text-gray-400 font-medium mb-1">{{ $i }}</span>
                                <input type="radio" name="visual_2" value="{{ $i }}" class="custom-radio-input sr-only" required>
                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                    <div class="radio-inner w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                                </div>
                            </label>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Sangat sesuai</span>
                    </div>
                </div>

                {{-- Pertanyaan 3: Visual --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md mb-4">
                    <p class="text-gray-800 font-medium text-lg mb-6">Saya suka melihat guru menulis di papan tulis.</p>
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Sangat tidak sesuai</span>
                        <div class="flex items-center justify-center gap-4 sm:gap-8 w-full sm:w-auto">
                            @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                <span class="text-xs text-gray-400 font-medium mb-1">{{ $i }}</span>
                                <input type="radio" name="visual_3" value="{{ $i }}" class="custom-radio-input sr-only" required>
                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                    <div class="radio-inner w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                                </div>
                            </label>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Sangat sesuai</span>
                    </div>
                </div>

                {{-- Pertanyaan 4: Visual --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md mb-4">
                    <p class="text-gray-800 font-medium text-lg mb-6">Saya suka menggunakan video pembelajaran.</p>
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Sangat tidak sesuai</span>
                        <div class="flex items-center justify-center gap-4 sm:gap-8 w-full sm:w-auto">
                            @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                <span class="text-xs text-gray-400 font-medium mb-1">{{ $i }}</span>
                                <input type="radio" name="visual_4" value="{{ $i }}" class="custom-radio-input sr-only" required>
                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                    <div class="radio-inner w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                                </div>
                            </label>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Sangat sesuai</span>
                    </div>
                </div>

                {{-- ==================== AUDITORI ==================== --}}
                <div class="bg-yellow-50 border-l-4 border-[#FFE27A] p-4 mb-6 mt-10">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-1 rounded-full bg-[#FFE27A]"></div>
                        <h2 class="text-xl font-bold text-gray-800">AUDITORI</h2>
                    </div>
                </div>

                {{-- Pertanyaan 1: Auditori --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md mb-4">
                    <p class="text-gray-800 font-medium text-lg mb-6">Saya lebih mudah memahami pelajaran jika dijelaskan secara lisan.</p>
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Sangat tidak sesuai</span>
                        <div class="flex items-center justify-center gap-4 sm:gap-8 w-full sm:w-auto">
                            @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                <span class="text-xs text-gray-400 font-medium mb-1">{{ $i }}</span>
                                <input type="radio" name="auditori_1" value="{{ $i }}" class="custom-radio-input sr-only" required>
                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                    <div class="radio-inner w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                                </div>
                            </label>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Sangat sesuai</span>
                    </div>
                </div>

                {{-- Pertanyaan 2: Auditori --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md mb-4">
                    <p class="text-gray-800 font-medium text-lg mb-6">Saya suka berdiskusi untuk memahami pelajaran.</p>
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Sangat tidak sesuai</span>
                        <div class="flex items-center justify-center gap-4 sm:gap-8 w-full sm:w-auto">
                            @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                <span class="text-xs text-gray-400 font-medium mb-1">{{ $i }}</span>
                                <input type="radio" name="auditori_2" value="{{ $i }}" class="custom-radio-input sr-only" required>
                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                    <div class="radio-inner w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                                </div>
                            </label>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Sangat sesuai</span>
                    </div>
                </div>

                {{-- Pertanyaan 3: Auditori --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md mb-4">
                    <p class="text-gray-800 font-medium text-lg mb-6">Saya suka mendengarkan rekaman suara atau audio belajar.</p>
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Sangat tidak sesuai</span>
                        <div class="flex items-center justify-center gap-4 sm:gap-8 w-full sm:w-auto">
                            @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                <span class="text-xs text-gray-400 font-medium mb-1">{{ $i }}</span>
                                <input type="radio" name="auditori_3" value="{{ $i }}" class="custom-radio-input sr-only" required>
                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                    <div class="radio-inner w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                                </div>
                            </label>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Sangat sesuai</span>
                    </div>
                </div>

                {{-- Pertanyaan 4: Auditori --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md mb-4">
                    <p class="text-gray-800 font-medium text-lg mb-6">Saya bisa mengingat informasi dengan cara mengucapkannya berulang.</p>
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Sangat tidak sesuai</span>
                        <div class="flex items-center justify-center gap-4 sm:gap-8 w-full sm:w-auto">
                            @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                <span class="text-xs text-gray-400 font-medium mb-1">{{ $i }}</span>
                                <input type="radio" name="auditori_4" value="{{ $i }}" class="custom-radio-input sr-only" required>
                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                    <div class="radio-inner w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                                </div>
                            </label>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Sangat sesuai</span>
                    </div>
                </div>


                {{-- ==================== KINESTIK ==================== --}}
                <div class="bg-yellow-50 border-l-4 border-[#FFE27A] p-4 mb-6 mt-10">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-1 rounded-full bg-[#FFE27A]"></div>
                        <h2 class="text-xl font-bold text-gray-800">KINESTIK</h2>
                    </div>
                </div>

                {{-- Pertanyaan 1: Kinestik --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md mb-4">
                    <p class="text-gray-800 font-medium text-lg mb-6">Saya suka belajar sambil praktik langsung.</p>
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Sangat tidak sesuai</span>
                        <div class="flex items-center justify-center gap-4 sm:gap-8 w-full sm:w-auto">
                            @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                <span class="text-xs text-gray-400 font-medium mb-1">{{ $i }}</span>
                                <input type="radio" name="kinestik_1" value="{{ $i }}" class="custom-radio-input sr-only" required>
                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                    <div class="radio-inner w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                                </div>
                            </label>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Sangat sesuai</span>
                    </div>
                </div>

                {{-- Pertanyaan 2: Kinestik --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md mb-4">
                    <p class="text-gray-800 font-medium text-lg mb-6">Saya mudah paham jika belajar sambil bergerak atau aktivitas.</p>
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Sangat tidak sesuai</span>
                        <div class="flex items-center justify-center gap-4 sm:gap-8 w-full sm:w-auto">
                            @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                <span class="text-xs text-gray-400 font-medium mb-1">{{ $i }}</span>
                                <input type="radio" name="kinestik_2" value="{{ $i }}" class="custom-radio-input sr-only" required>
                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                    <div class="radio-inner w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                                </div>
                            </label>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Sangat sesuai</span>
                    </div>
                </div>

                {{-- Pertanyaan 3: Kinestik --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md mb-4">
                    <p class="text-gray-800 font-medium text-lg mb-6">Saya suka membuat model atau proyek saat belajar.</p>
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Sangat tidak sesuai</span>
                        <div class="flex items-center justify-center gap-4 sm:gap-8 w-full sm:w-auto">
                            @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                <span class="text-xs text-gray-400 font-medium mb-1">{{ $i }}</span>
                                <input type="radio" name="kinestik_3" value="{{ $i }}" class="custom-radio-input sr-only" required>
                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                    <div class="radio-inner w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                                </div>
                            </label>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Sangat sesuai</span>
                    </div>
                </div>

                {{-- Pertanyaan 4: Kinestik --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 transition hover:shadow-md mb-4">
                    <p class="text-gray-800 font-medium text-lg mb-6">Saya tidak bisa duduk lama saat belajar.</p>
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-left">Sangat tidak sesuai</span>
                        <div class="flex items-center justify-center gap-4 sm:gap-8 w-full sm:w-auto">
                            @for ($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer flex flex-col items-center gap-2 radio-option group">
                                <span class="text-xs text-gray-400 font-medium mb-1">{{ $i }}</span>
                                <input type="radio" name="kinestik_4" value="{{ $i }}" class="custom-radio-input sr-only" required>
                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all duration-200">
                                    <div class="radio-inner w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-transparent transition-transform duration-200 transform scale-0"></div>
                                </div>
                            </label>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wide w-24 text-center sm:text-right">Sangat sesuai</span>
                    </div>
                </div>

                {{-- TOMBOL NAVIGASI --}}
                <div class="mt-10 flex justify-between gap-4">
                    <a href="{{ route('studi_habit.form') }}" class="w-1/2 text-center bg-gray-200 text-gray-700 font-bold text-lg py-3 px-6 rounded-xl shadow hover:bg-gray-300 transition duration-200">
                        Kembali
                    </a>
                    <button type="submit" class="w-1/2 bg-[#0A2A43] text-white font-bold text-lg py-3 px-6 rounded-xl shadow-lg hover:bg-[#143d5e] transition duration-200 text-center">
                        Selesai
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
